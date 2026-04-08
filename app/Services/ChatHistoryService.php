<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatHistoryService
{
    private const MAX_HISTORY             = 12;
    private const SESSION_TIMEOUT_MINUTES = 30;
    private const NAME_EXTRACTION_EVERY   = 2;   // run AI extraction every N user messages until name found

    private const STATIC_GREETING = "Heyy! mera naam hai UV 😎 \ntumhara naam kya hai?";

    private const NAME_EXTRACTION_PROMPT = <<<PROMPT
You are a name extractor. Your ONLY job is to find the visitor's real personal name from the conversation.

STRICT OUTPUT RULES — no exceptions:
- If you find a name: respond with ONLY the name. Example: "Rahul" or "Priya Singh"
- If no name found: respond with ONLY this: "NO_NAME"
- No sentences. No explanations. No punctuation. No greetings. No extra words. Nothing else.

WHAT COUNTS AS A NAME:
- A real human name the visitor used to refer to themselves
- Nicknames they introduced themselves with (e.g. "call me Rocky")
- Hinglish/Hindi intros like "mera naam Rohit hai", "main Pooja hoon", "I'm Aryan"

WHAT DOES NOT COUNT AS A NAME:
- Greetings: hi, hello, hey, heyy, namaste
- Common words: ok, yes, no, bye, thanks
- The AI's name "UV" — that is the chatbot, not the visitor
- Any word that is clearly not a person's name
PROMPT;

    // ── Session resolution ────────────────────────────────────────────────

    public function resolveSession(Request $request): ChatSession
    {
        $key = $request->header('X-Chat-Session') ?? $request->input('session_token');

        if ($key) {
            $session = ChatSession::where('session_key', $key)
                ->whereNull('ended_at')
                ->where('last_active_at', '>=', now()->subMinutes(self::SESSION_TIMEOUT_MINUTES))
                ->first();

            if ($session) {
                $session->touch('last_active_at');
                return $session;
            }
        }

        return $this->createSession($request);
    }

    private function createSession(Request $request): ChatSession
    {
        $key = Str::uuid()->toString();

        return ChatSession::create([
            'session_key'    => $key,
            'started_at'     => now(),
            'last_active_at' => now(),
            'ip_address'     => $request->ip(),
            'user_agent'     => substr($request->userAgent() ?? '', 0, 512),
            'meta'           => [],
        ]);
    }

    // ── Message persistence ───────────────────────────────────────────────

    public function saveMessage(ChatSession $session, string $role, string $content): ChatMessage
    {
        return ChatMessage::create([
            'session_id' => $session->id,
            'role'       => $role,
            'content'    => $content,
            'tokens_est' => $this->estimateTokens($content),
            'sent_at'    => now(),
        ]);
    }

    public function ensureGreetingStored(ChatSession $session): void
    {
        $hasMessages = ChatMessage::where('session_id', $session->id)->exists();

        if (!$hasMessages) {
            ChatMessage::create([
                'session_id' => $session->id,
                'role'       => 'assistant',
                'content'    => self::STATIC_GREETING,
                'tokens_est' => $this->estimateTokens(self::STATIC_GREETING),
                'sent_at'    => $session->started_at ?? now(),
            ]);
        }
    }

    // ── History for API ───────────────────────────────────────────────────

    public function getApiHistory(ChatSession $session): array
    {
        $rows = ChatMessage::where('session_id', $session->id)
            ->orderBy('sent_at', 'desc')
            ->limit(self::MAX_HISTORY)
            ->get()
            ->reverse()
            ->values();

        $meta   = $session->meta ?? [];
        $anchor = [];

        if (!empty($meta['visitor_name'])) {
            $name    = $meta['visitor_name'];
            $hasName = $rows->contains(
                fn($m) => stripos($m->content, $name) !== false
            );

            if (!$hasName) {
                $anchor[] = ['role' => 'user',     'content' => "Mera naam {$name} hai."];
                $anchor[] = ['role' => 'assistant', 'content' => "Got it, {$name}! 😄"];
            }
        }

        $history = $rows->map(fn($m) => [
            'role'    => $m->role,
            'content' => $m->content,
        ])->toArray();

        return array_merge($anchor, $history);
    }

    // ── Name extraction — AI powered ─────────────────────────────────────

    /**
     * Called after every user message (before saveMessage).
     *
     * Strategy:
     *   - Skip if name already known.
     *   - Run AI extraction on every Nth user message (every 2 by default).
     *   - Fire-and-forget style: runs async-ish via a short-timeout request.
     *   - Stops permanently once a name is found (meta flag: name_extraction_done).
     */
    public function extractAndSaveName(ChatSession $session, string $userMessage): void
    {
        $meta = $session->meta ?? [];

        // Already have a name — nothing to do
        if (!empty($meta['visitor_name']) && mb_strlen($meta['visitor_name']) >= 2) {
            return;
        }

        // AI already confirmed no name extractable (optional hard-stop after many attempts)
        if (!empty($meta['name_extraction_done'])) {
            return;
        }

        // Count user messages so far (current message not saved yet)
        $userMessageCount = ChatMessage::where('session_id', $session->id)
            ->where('role', 'user')
            ->count();

        // Always try on the very first message; then every N messages
        $shouldRun = ($userMessageCount === 0)
            || ($userMessageCount % self::NAME_EXTRACTION_EVERY === 0);

        if (!$shouldRun) {
            return;
        }

        // Build conversation history for the extraction prompt
        // Include the current unsaved message too
        $history = ChatMessage::where('session_id', $session->id)
            ->orderBy('sent_at', 'asc')
            ->get()
            ->map(fn($m) => $m->role . ': ' . strip_tags($m->content))
            ->push('user: ' . $userMessage)  // include current message
            ->implode("\n");

        $name = $this->callAiForName($history);

        if ($name !== null) {
            $meta['visitor_name']       = $name;
            $meta['name_extraction_done'] = true;   // stop future extractions
            $session->update(['meta' => $meta]);
        }

        // Optional: stop trying after 10 user messages even if no name found
        if ($userMessageCount >= 10) {
            $meta['name_extraction_done'] = true;
            $session->update(['meta' => $meta]);
        }
    }

    /**
     * Fires a secondary Groq API call with a strict name-extraction prompt.
     * Returns the cleaned name string, or null if no name found.
     */
    private function callAiForName(string $conversationText): ?string
    {
        $apiKey = config('services.grok.api_key');

        if (empty($apiKey)) {
            return null;
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(8)          // short timeout — this is a background call
                ->connectTimeout(4)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model'       => 'llama-3.3-70b-versatile',
                    'messages'    => [
                        [
                            'role'    => 'system',
                            'content' => self::NAME_EXTRACTION_PROMPT,
                        ],
                        [
                            'role'    => 'user',
                            'content' => "Extract the visitor's name from this conversation:\n\n" . $conversationText,
                        ],
                    ],
                    'max_tokens'  => 10,    // name or NO_NAME — nothing more needed
                    'temperature' => 0,     // deterministic — no creativity needed
                ]);

            if ($response->failed()) {
                Log::warning('ChatHistoryService: Name extraction API failed.', [
                    'status' => $response->status(),
                ]);
                return null;
            }

            $raw = trim($response->json('choices.0.message.content') ?? '');

            // Normalise and validate the response
            return $this->parseNameResponse($raw);

        } catch (\Exception $e) {
            // Never let name extraction break the main chat flow
            Log::warning('ChatHistoryService: Name extraction exception.', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Validates the raw AI response.
     * Returns clean name string or null.
     */
    private function parseNameResponse(string $raw): ?string
    {
        if (empty($raw)) {
            return null;
        }

        // AI said no name found
        if (strtoupper(str_replace([' ', '_', '-'], '', $raw)) === 'NONAME') {
            return null;
        }

        // Strip any accidental punctuation or extra whitespace
        $cleaned = trim(preg_replace('/[^a-zA-ZÀ-žऀ-ॿ\s\'\-]/u', '', $raw));
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        if (mb_strlen($cleaned) < 2) {
            return null;
        }

        // Sanity check: should be 1-3 words max
        $words = explode(' ', $cleaned);
        if (count($words) > 3) {
            return null;
        }

        return $this->capitalizeName($cleaned);
    }

    // ── Helpers ───────────────────────────────────────────────────────────

    private function capitalizeName(string $str): string
    {
        $str   = trim(preg_replace('/\s+/', ' ', $str) ?? '');
        $parts = preg_split('/[\s\-]+/', $str, -1, PREG_SPLIT_NO_EMPTY);

        $capitalized = array_map(function (string $part): string {
            $part = mb_strtolower($part, 'UTF-8');

            foreach (['Mc' => 2, 'Mac' => 3, "O'" => 2] as $prefix => $len) {
                if (stripos($part, strtolower($prefix)) === 0) {
                    return $prefix . mb_convert_case(mb_substr($part, $len), MB_CASE_TITLE, 'UTF-8');
                }
            }

            return mb_convert_case($part, MB_CASE_TITLE, 'UTF-8');
        }, $parts);

        return implode(' ', $capitalized);
    }

    private function estimateTokens(string $text): int
    {
        return (int) ceil(mb_strlen($text) / 4);
    }

    public function setMetaFlag($session, string $key, mixed $value): void
    {
        $session->refresh();
        $meta        = $session->meta ?? [];
        $meta[$key]  = $value;
        $session->update(['meta' => $meta]);
    }
}