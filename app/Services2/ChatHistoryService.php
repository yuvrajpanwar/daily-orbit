<?php

namespace App\Services;

use App\Models\ChatMessage;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatHistoryService
{
    private const MAX_HISTORY             = 12;
    private const SESSION_TIMEOUT_MINUTES = 30;

    // The exact static greeting shown in the JS frontend.
    // Stored once per session so the AI has full context.
    private const STATIC_GREETING = "Heyy! mera naam hai UV 😎 \ntumhara naam kya hai?";

    // Single-word/short strings that are definitely NOT names
    private const NAME_BLACKLIST = [
        'hi','hello','hii','hlo','hola','hey','heya','heyy',
        'bye','okay','ok','nope','yes','no','yep','yup','nah',
        'kya','kyun','kaun','kon','koi','kuch','sab','bhi',
        'haan','han','nahi','nai','na','ha','huh','hmm','umm',
        'naam','name','sir','mam','madam','bhai','dost','yaar',
        'bol','hun','hoon','hoo','hu','hai','he','the','and','for',
    ];

    // ── Session resolution ────────────────────────────────────────────────

    public function resolveSession(Request $request): ChatSession
    {
        $key = $request->session()->get('uv_chat_session_id');

        if ($key) {
            $session = ChatSession::where('session_key', $key)
                ->whereNull('ended_at')
                ->where('last_active_at', '>=', now()->subMinutes(self::SESSION_TIMEOUT_MINUTES))
                ->first();

            if ($session) {
                $session->touch('last_active_at');
                return $session;
            }

            // Session exists but timed out → close it
            ChatSession::where('session_key', $key)
                ->whereNull('ended_at')
                ->update(['ended_at' => now()]);
        }

        return $this->createSession($request);
    }

    private function createSession(Request $request): ChatSession
    {
        $key = Str::uuid()->toString();

        $session = ChatSession::create([
            'session_key'    => $key,
            'started_at'     => now(),
            'last_active_at' => now(),
            'ip_address'     => $request->ip(),
            'user_agent'     => substr($request->userAgent() ?? '', 0, 512),
            'meta'           => [],
        ]);

        $request->session()->put('uv_chat_session_id', $key);

        return $session;
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
     * Save the static frontend greeting as the very first assistant message
     * so the DB history is complete and the AI sees the full conversation.
     * Called once per session — idempotent (checks message count first).
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

        // If visitor name is known but has scrolled out of the history window,
        // prepend a tiny synthetic exchange so the AI remembers it (~15 tokens).
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

    // ── Name extraction ───────────────────────────────────────────────────

    /**
     * Main entry point — call this before saveMessage() on every user turn.
     *
     * Strategy (priority order):
     *   1. Already have a name → skip immediately.
     *   2. Is this the first user message in the session? (reply to greeting)
     *      → use the "first-message fast path" which is much more aggressive.
     *   3. For later messages run the full pattern set.
     */
    public function extractAndSaveName(ChatSession $session, string $userMessage): void
    {
        $meta = $session->meta ?? [];

        if (!empty($meta['visitor_name']) && mb_strlen($meta['visitor_name']) >= 2) {
            return; // already known, bail early
        }

        $message = trim($userMessage);
        if (mb_strlen($message) < 1) {
            return;
        }

        // Check if this is the very first user message (only greeting stored so far)
        $userMessageCount = ChatMessage::where('session_id', $session->id)
            ->where('role', 'user')
            ->count();

        $isFirstMessage = ($userMessageCount === 0);

        $name = $isFirstMessage
            ? $this->extractFromFirstMessage($message)
            : $this->extractFromAnyMessage($message);

        if ($name !== null) {
            $meta['visitor_name'] = $name;
            $session->update(['meta' => $meta]);
        }
    }

    // ── First-message fast path ───────────────────────────────────────────

    /**
     * The AI just asked "tumhara naam kya hai?" — so the reply is almost
     * certainly a name, possibly with a greeting prefix or suffix.
     *
     * Order of attempts:
     *   A) Strip greeting words → if what's left is 1-3 clean words, treat as name.
     *   B) Known intro patterns  ("mera naam X", "main X hoon", etc.)
     *   C) Whole message is a clean name (last resort, but very common here)
     */
    private function extractFromFirstMessage(string $raw): ?string
    {
        // ── A) Strip common greeting/filler words and see what's left ────
        $stripped = $this->stripFillerWords($raw);

        if ($stripped !== null) {
            // If 1-3 tokens remain and they look like a name, use them
            $words = preg_split('/\s+/', $stripped, -1, PREG_SPLIT_NO_EMPTY);
            if (count($words) >= 1 && count($words) <= 3) {
                $candidate = implode(' ', $words);
                $name = $this->validateAndClean($candidate);
                if ($name !== null) return $name;
            }
        }

        // ── B) Explicit intro patterns ────────────────────────────────────
        $fromPattern = $this->matchIntroPatterns($raw);
        if ($fromPattern !== null) return $fromPattern;

        // ── C) Whole message as name (very common: user just types their name) ─
        $words = preg_split('/\s+/', trim($raw), -1, PREG_SPLIT_NO_EMPTY);
        if (count($words) >= 1 && count($words) <= 3) {
            $candidate = implode(' ', $words);
            $name = $this->validateAndClean($candidate);
            if ($name !== null) return $name;
        }

        return null;
    }

    /**
     * Remove common greeting/filler tokens from the message.
     * Returns what's left, or null if nothing useful remains.
     */
    private function stripFillerWords(string $raw): ?string
    {
        $fillers = [
            // Greetings
            'hello','hi','hii','hiii','hlo','hey','heya','heyy','heyyyy',
            'namaste','namaskar','salaam','salam','jai hind',
            // Self-intro triggers
            'mera naam','mera name','my name is','main hoon','mai hoon',
            'i am','i\'m','naam hai','name is','naam','name',
            // Suffixes / polite particles
            'hai','hain','he','hoon','hun','hu','hoo',
            'ji','jee','sir','mam','madam','bhai','yaar','dost',
            // Punctuation artifacts
            '!','.',',','?',':','-','—',
        ];

        $lower = mb_strtolower(trim($raw), 'UTF-8');

        // Sort fillers longest-first so multi-word ones match before their parts
        usort($fillers, fn($a, $b) => mb_strlen($b) - mb_strlen($a));

        $changed = true;
        while ($changed) {
            $changed = false;
            foreach ($fillers as $filler) {
                $f = mb_strtolower($filler, 'UTF-8');

                // Strip from start
                if (str_starts_with($lower, $f . ' ') || $lower === $f) {
                    $lower   = ltrim(mb_substr($lower, mb_strlen($filler)), ' ');
                    $changed = true;
                }

                // Strip from end
                if (str_ends_with($lower, ' ' . $f) || $lower === $f) {
                    $lower   = rtrim(mb_substr($lower, 0, mb_strlen($lower) - mb_strlen($filler)), ' ');
                    $changed = true;
                }
            }
        }

        $lower = trim($lower);
        return mb_strlen($lower) >= 2 ? $lower : null;
    }

    // ── General pattern matching (any message) ────────────────────────────

    private function extractFromAnyMessage(string $raw): ?string
    {
        $fromPattern = $this->matchIntroPatterns($raw);
        if ($fromPattern !== null) return $fromPattern;

        return null; // Don't guess on later messages — too risky
    }

    /**
     * Explicit intro patterns — safe to run on any message.
     */
    private function matchIntroPatterns(string $raw): ?string
    {
        $patterns = [
            // ── English ──────────────────────────────────────────────────
            '/\bmy name is\s+([a-zA-Z\'\-\s]{2,35})/i',
            '/\bi(?:\'?m| am)\s+([a-zA-Z\'\-\s]{2,30})(?:\s+(?:here|speaking|talking))?/i',
            '/\bthis is\s+([a-zA-Z\'\-\s]{2,30})(?:\s+(?:here|speaking|talking))?/i',
            '/\bcall(?:\s+me)?\s+([a-zA-Z\'\-\s]{2,30})/i',
            '/\bpeople call me\s+([a-zA-Z\'\-\s]{2,30})/i',
            '/\bknown as\s+([a-zA-Z\'\-\s]{2,30})/i',

            // ── Hinglish ─────────────────────────────────────────────────
            '/\bmera\s+(?:naam|name)\s+([a-zA-Z\'\-\s]{2,35})(?:\s+(?:hai|hain|he|h))?/iu',
            '/\b(?:main|mai|mein)\s+([a-zA-Z\'\-\s]{2,30})\s+(?:hoon|hun|hu|hoo|bol raha|bol rahi|here|speaking)/iu',
            '/\b(?:mujhe|muje)\s+([a-zA-Z\'\-\s]{2,30})\s+(?:bolo|bolte|kehte|kehna)/iu',
            '/\b(?:my|mera|meri)\s+name\s+is\s+([a-zA-Z\'\-\s]{2,30})/iu',
            '/\bnaam\s+([a-zA-Z\'\-\s]{2,30})\s+(?:hai|he|h)\b/iu',

            // ── Pure Hindi (Devanagari) ───────────────────────────────────
            '/मेरा\s+नाम\s+([ऀ-ॿa-zA-Z\s\'\-]{2,35})\s*(?:है|हैं|हूँ|हू|हे)?/u',
            '/मैं\s+([ऀ-ॿa-zA-Z\s\'\-]{2,30})\s*(?:हूँ|हूं|हू|है)/u',
            '/नाम\s+([ऀ-ॿa-zA-Z\s\'\-]{2,30})\s+है/u',

            // ── Casual / short patterns ───────────────────────────────────
            '/^([A-Za-zÀ-ž]{2,25})\s+(?:here|speaking|bol raha|bol rahi|hoon|hun|hu|hoo)$/iu',
            '/^([A-Za-zÀ-ž]{2,25})\s+(?:ji|jee)$/iu',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $raw, $m)) {
                $name = $this->validateAndClean(trim($m[1]));
                if ($name !== null) return $name;
            }
        }

        return null;
    }

    // ── Validation & cleanup ──────────────────────────────────────────────

    /**
     * Clean, de-suffix, validate and properly capitalise a name candidate.
     * Returns null if the candidate fails quality checks.
     */
    private function validateAndClean(string $candidate): ?string
    {
        // Remove trailing filler words that sometimes attach
        $trailFillers = [
            'ji','jee','sir','mam','madam','bhai','yaar','dost',
            'here','speaking','talking','bol','hoon','hun','hu','hoo',
            'hai','hain','he','h',
        ];
        foreach ($trailFillers as $filler) {
            $pattern = '/\s+' . preg_quote($filler, '/') . '$/iu';
            $candidate = preg_replace($pattern, '', $candidate);
        }

        $candidate = trim(preg_replace('/\s+/', ' ', $candidate) ?? '');

        if (mb_strlen($candidate) < 2) return null;

        // Must contain at least one letter
        if (!preg_match('/[a-zA-ZÀ-žऀ-ॿ]/u', $candidate)) return null;

        // Blacklist check (whole string)
        if (in_array(mb_strtolower($candidate, 'UTF-8'), self::NAME_BLACKLIST, true)) {
            return null;
        }

        // Each word individually must not be blacklisted
        $words = preg_split('/\s+/', $candidate, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($words as $w) {
            if (in_array(mb_strtolower($w, 'UTF-8'), self::NAME_BLACKLIST, true)) {
                return null;
            }
        }

        // Max 3 words — longer is probably not a name
        if (count($words) > 3) return null;

        return $this->capitalizeName($candidate);
    }

    private function capitalizeName(string $str): string
    {
        $str   = trim(preg_replace('/\s+/', ' ', $str) ?? '');
        $parts = preg_split('/[\s\-]+/', $str, -1, PREG_SPLIT_NO_EMPTY);

        $capitalized = array_map(function (string $part): string {
            $part = mb_strtolower($part, 'UTF-8');

            // Prefix-aware capitalisation (Mc/Mac/O')
            foreach (['Mc' => 2, 'Mac' => 3, "O'" => 2] as $prefix => $len) {
                if (stripos($part, strtolower($prefix)) === 0) {
                    return $prefix . mb_convert_case(mb_substr($part, $len), MB_CASE_TITLE, 'UTF-8');
                }
            }

            return mb_convert_case($part, MB_CASE_TITLE, 'UTF-8');
        }, $parts);

        return implode(' ', $capitalized);
    }

    // ── Token estimate ────────────────────────────────────────────────────

    private function estimateTokens(string $text): int
    {
        return (int) ceil(mb_strlen($text) / 4);
    }
    public function setMetaFlag($session, string $key, mixed $value): void
    {
        $session->refresh(); // ensure fresh state
        $meta = $session->meta ?? [];
        $meta[$key] = $value;
        $session->update(['meta' => $meta]);
    }
}