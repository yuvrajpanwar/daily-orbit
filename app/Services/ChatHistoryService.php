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
    private const NAME_EXTRACTION_EVERY   = 2;  // run AI extraction every N user messages until name found

    private const STATIC_GREETING = "Heyy! mera naam hai UV 😎 \ntumhara naam kya hai?";

    private const NAME_EXTRACTION_PROMPT = <<<PROMPT
You are a name extractor. Your ONLY job is to find the visitor's real personal name from the conversation.

STRICT OUTPUT RULES — no exceptions:
- If you find a name: respond with ONLY the name. Example: "Rahul" or "Priya Singh"
- If no name found: respond with ONLY the two words: NO_NAME
- No sentences. No explanations. No punctuation. No greetings. No extra words. Nothing else.

WHAT COUNTS AS A NAME:
- A real human first name or full name the visitor used to refer to themselves
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

    /**
     * Stores the static frontend greeting as the very first assistant message
     * so the AI always sees a complete conversation history.
     * Idempotent — checks for existing messages first.
     */
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

    // ── History for Groq API ──────────────────────────────────────────────

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

        // If visitor name is known but has scrolled out of the history window,
        // inject a tiny synthetic exchange so the AI always remembers it.
        if (!empty($meta['visitor_name'])) {
            $name    = $meta['visitor_name'];
            $hasName = $rows->contains(
                fn($m) => stripos($m->content, $name) !== false
            );

            if (!$hasName) {
                $anchor[] = ['role' => 'user',      'content' => "Mera naam {$name} hai."];
                $anchor[] = ['role' => 'assistant',  'content' => "Got it, {$name}! 😄"];
            }
        }

        $history = $rows->map(fn($m) => [
            'role'    => $m->role,
            'content' => $m->content,
        ])->toArray();

        return array_merge($anchor, $history);
    }

    // ── Name extraction — AI powered ──────────────────────────────────────

    /**
     * Called AFTER saveMessage('user') in the controller — so the user's
     * message is already persisted in the DB when this runs.
     *
     * Runs on:
     *   - The very first user message (count === 1)
     *   - Then every NAME_EXTRACTION_EVERY messages
     *   - Stops permanently once a name is found or after 10 user messages
     */
    public function extractAndSaveName(ChatSession $session): void
    {
        $meta = $session->meta ?? [];

        // Already have a confirmed name — nothing to do
        if (!empty($meta['visitor_name']) && mb_strlen($meta['visitor_name']) >= 2) {
            return;
        }

        // Permanently stopped — no more attempts
        if (!empty($meta['name_extraction_done'])) {
            return;
        }

        // Count all user messages now (current message already saved)
        $userMessageCount = ChatMessage::where('session_id', $session->id)
            ->where('role', 'user')
            ->count();

        // Run on message 1, then every N messages
        $shouldRun = ($userMessageCount === 1)
            || ($userMessageCount % self::NAME_EXTRACTION_EVERY === 0);

        if (!$shouldRun) {
            return;
        }

        // Build full conversation text from DB (everything already saved)
        $history = ChatMessage::where('session_id', $session->id)
            ->orderBy('sent_at', 'asc')
            ->get()
            ->map(fn($m) => $m->role . ': ' . strip_tags($m->content))
            ->implode("\n");

        $name = $this->callAiForName($history);

        // Refresh meta before writing to avoid overwriting parallel updates
        $session->refresh();
        $meta = $session->meta ?? [];

        if ($name !== null) {
            $meta['visitor_name']         = $name;
            $meta['name_extraction_done'] = true;  // stop all future extractions
            $session->update(['meta' => $meta]);
            return;
        }

        // Hard stop after 10 user messages even if no name was ever found
        if ($userMessageCount >= 10) {
            $meta['name_extraction_done'] = true;
            $session->update(['meta' => $meta]);
        }
    }

    /**
     * Fires a lean secondary Groq API call with a strict name-extraction prompt.
     * Returns the cleaned name string, or null if no name found / on any error.
     */
    private function callAiForName(string $conversationText): ?string
    {
        $apiKey = config('services.grok.api_key');

        if (empty($apiKey)) {
            return null;
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(8)         // short — never block the main chat response
                ->connectTimeout(4)
                ->post('https://api.groqcloud.com/openai/v1/chat/completions', [
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
                    'max_tokens'  => 10,   // a name needs 2–4 tokens at most
                    'temperature' => 0,    // fully deterministic — no creativity needed
                ]);

            if ($response->failed()) {
                Log::warning('ChatHistoryService: Name extraction API failed.', [
                    'status' => $response->status(),
                ]);
                return null;
            }

            $raw = trim($response->json('choices.0.message.content') ?? '');

            return $this->parseNameResponse($raw);

        } catch (\Exception $e) {
            // Never let this secondary call break the main chat flow
            Log::warning('ChatHistoryService: Name extraction exception.', [
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Validates and cleans the raw AI response.
     * Returns a properly capitalised name string, or null.
     */
    private function parseNameResponse(string $raw): ?string
    {
        if (empty($raw)) {
            return null;
        }

        // Normalise the "no name" signal regardless of spacing/casing/punctuation
        if (strtoupper(str_replace([' ', '_', '-'], '', $raw)) === 'NONAME') {
            return null;
        }

        // Strip everything except letters, spaces, apostrophes, hyphens, and Devanagari
        $cleaned = trim(preg_replace('/[^a-zA-ZÀ-žऀ-ॿ\s\'\-]/u', '', $raw));
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        if (mb_strlen($cleaned) < 2) {
            return null;
        }

        // Must be 1–3 words — anything longer is not a name
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
        $meta       = $session->meta ?? [];
        $meta[$key] = $value;
        $session->update(['meta' => $meta]);
    }
}