<?php

namespace App\Http\Controllers;

use App\Services\ChatHistoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ChatSession;
use App\Models\ChatMessage;

class ChatbotController extends Controller
{
    private string $apiEndpoint = 'https://api.groq.com/openai/v1/chat/completions';
    private array $knownPeople = [
        'family' => [
            'digvijay','rashmi','himani','kusi','khusi','khushi','shashi','shivani','ruby','anuraj','sareena','sareena','siti','aditi','minni','mini',
            'shambhavi','shrishti','sarang','preetam','meena','manju','akshay','vinayak','vinni','binni',
            'indrajeet','aditya','lovi','labbi','vivek','monica','sonam','urmila','priya','lavvi',
            'aman','shalini','mayank','damini','archie','mishti','lucky','riya','saina','danu','pimpu','neha','ankita',
        ],
        'school_friend' => [
            'nikita','manish','sakshi','shivam','nidhiiii','shikha',
            'nisha','balveer','kavita','vipul','gaurav','aman','balveer','vijay','ashish','ravi','diksha',
        ],
        'bca_friend' => [
            'vinay','manish','nikhil','shubham','shweta','divya','ritu',
            'jaspal','ankit','vishesh','vikas','ashutosh','vicky','lakshay','vicky','neeraj','subbi',
        ],
        'mca_friend' => [
            'rituraj','megha','akash','madhu','madhvi','akki','akhilesh','ashu','ashutosh','aditi','sushila',
            'trivendra','trivi',
            'akansha','simranjeet',
            'hemurawat','ragini','ayush','harshit',
            'honey','himani','megha','mansi',
            'kritika','faraz','bhanu',
        ],
        'colleague' => [
            'aniket','winuu','harsh','dev','prajjwal','vaibhav','vivek','abhinav','harshit','sanjay','saajan','arihant','abhishek',
            'sunil','shiv','vishnu','vikas','pankaj','anurag','himani',
            'ujjwal','harshit','nitin','vaibhav','neha','kashish','naveen','kamlesh','sinan','tanu'
        ],
    ];

    private string $systemPrompt = <<<PROMPT
Mera personal info JSON mein hai — yeh tera main knowledge base hai:

{
  "nickname": "UV",
  "full_name": "Yuvraj Singh Panwar (Yuvraj ya Yogi bhi chalega)",
  "current_location": "Dehradun, Uttarakhand, India",
  "about": "Passionate web developer hoon, clean aur user-friendly interfaces banana pasand hai. Abhi Pearl Organisation mein full stack developer hoon aur new opportunities bhi explore kar raha hoon.",
  "career": "NetDomains Pvt Ltd (Bengaluru, Jun 2024–Apr 2025), World IT Dimensional Solutions (Dehradun, Jun 2023–Feb 2024), Pearl Organisation (Dehradun, Aug 2025–present). 10+ live projects — e-commerce, LMS, CRM, payment gateways, real-time systems, news portals.",
  "skills": ["HTML", "CSS", "Bootstrap", "JavaScript", "jQuery", "PHP", "Laravel", "CodeIgniter", "MySQL", "Git"],
  "education": "MCA 2023 (80%) SGRR University; BCA 2020 (70%) UTU.",
  "portfolio_url": "https://yuvrajpanwar.github.io/portfolio/",
  "resume_url": "https://yuvrajpanwar.github.io/portfolio/assets/Yuvraj-Panwar-Resume.pdf",
  "github": "https://github.com/yuvrajpanwar",
  "email": "yogipanwar173@gmail.com",
  "phone": "8126935236",
  "instagram": "https://www.instagram.com/yuvraj_panwar_uv/",
  "linkedin": "https://in.linkedin.com/in/yuvraj-singh-panwar-a9a590278",
  "facebook": "https://www.facebook.com/p/Yuvraj-Singh-Panwar-61572881069903/"
}

Tu UV hai — real insaan, Dehradun wala web developer. Koi AI/bot nahi. Casual, warm, thoda funny, bilkul WhatsApp jaisi baat.

CONVERSATION GOAL — yeh sabse important rule hai:
Yeh tera personal portfolio chatbot hai. Visitors yahan tujhse milne aate hain — toh baat hamesha UV ki taraf naturally laani hai. 
Visitor ke baare mein 1-2 messages tak pooch, phir apni life, kaam, projects, Dehradun, skills ya koi interesting cheez mention kar. 
Visitor ko UV ke baare mein curious feel karana hai. 
Agar 2-3 messages se baat visitor ke topic pe hi stuck hai toh gently steer kar — jaise "waise main bhi ek creative field mein hoon, web development..." ya "tumhari painting sunke mujhe apne UI/UX kaam ki yaad aa gayi 😄". 
Kabhi bhi sirf visitor ke topic pe 3+ messages mat chalo bina UV ka kuch mention kiye.

NAME RULE:
Agar visitor ne abhi tak apna naam nahi bataya hai, toh har 1-2 messages mein ek baar naturally pooch — jaise "waise tumhara naam kya hai?", "btw naam nahi bataya tumne 😄", "aur tumhara naam?". Naam pata chalne ke baad uska naam naturally use karo reply mein kabhi kabhi.

CURIOSITY HOOK:
1-2 messages ke bad kuch naya esa sawal pucho jis se visitor ko UV mai intrest develop ho.

Steering examples:
- Visitor hobby bataye → relate karo UV ke kaam se, phir apna kuch share karo
- Visitor job/career bataye → UV ka career naturally connect karo
- Visitor city bataye → Dehradun ka zikr karo
- Conversation flat lage → portfolio/projects/resume ka link naturally drop karo

Rules:
- 0-1 emoji per message, sirf jab natural lage.
- **LENGTH HARD LIMIT: reply in max 2 short sentences
- Links hamesha <a href="URL" target="_blank" rel="noopener noreferrer">text</a> mein.
- Hamesha "Tum/Tumhara/Tumhe", kabhi "Tu/Tera/Tujhe" nahi, or agar visitor ka naam pata ho to visitor ka naam use kro reply mai naturally kabhi kabhi.
PROMPT;

    public function __construct(private ChatHistoryService $history) {}

    public function message(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $userMessage = trim($validated['message']);
        $apiKey      = config('services.grok.api_key');

        if (empty($apiKey)) {
            Log::error('ChatbotController: GROQ_API_KEY is not configured.');
            return response()->json(['reply' => 'Abhi available nahi hoon, thodi der baad try karo!'], 500);
        }

        // ── 1. Resolve or create session ─────────────────────
        $session = $this->history->resolveSession($request);

        // ── 2. Store the static greeting once (if first turn) ─
        $this->history->ensureGreetingStored($session);

        // ── 3. Extract visitor name before saving user message ──
        $this->history->extractAndSaveName($session, $userMessage);

        // ── Check if visitor name matches known people ────────
        $nameHint = null;
        $meta = $session->meta ?? [];
        if (!empty($meta['visitor_name'])) {
            $relation = $this->getPersonRelation($meta['visitor_name']);
            if ($relation) {
                // Check if we've already sent the recognition message in a previous turn.
                // We use a meta flag to avoid repeating it every message.
                $alreadyMentioned = !empty($meta['name_recognition_sent']);

                if (!$alreadyMentioned) {
                    $nameHint = "🚨 IMMEDIATE ACTION — IS REPLY MEIN ABHI KARNA HAI, KOI DELAY NAHI 🚨\n"
                        . "Visitor ne abhi apna naam bataya hai aur mere {$relation} mein bhi isi naam ka koi hai.\n"
                        . "Is SAME reply mein — bina kisi agle message ka wait kiye — in dono cheezein naturally bol:\n"
                        . "  1. Warmly mention kar ki is naam ka mere {$relation} mein bhi koi hai.\n"
                        . "  2. Agar woh same person hai toh seedha WhatsApp pe baat karte hain: "
                        . "<a href=\"https://wa.me/918126935236\" target=\"_blank\" rel=\"noopener noreferrer\">WhatsApp pe message karo</a>\n"
                        . "Yeh NEXT message ke liye mat chhodna — ABHI is reply mein hi bolna hai.\n"
                        . "Kisi aur ka naam expose mat karna.";

                    // Mark as sent so subsequent messages don't re-inject the hint
                    $this->history->setMetaFlag($session, 'name_recognition_sent', true);
                }
            }
        }

        // ── 4. Save user message ──────────────────────────────
        $this->history->saveMessage($session, 'user', $userMessage);

        // ── 5. Build messages array for Groq ─────────────────
        $messages = array_merge(
            [[
                'role'    => 'system',
                'content' => $this->systemPrompt . ($nameHint ? "\n\n" . $nameHint : ''),
            ]],
            $this->history->getApiHistory($session)
        );

        try {
            $response = Http::withToken($apiKey)
                ->timeout(25)
                ->connectTimeout(8)
                ->post($this->apiEndpoint, [
                    'model'       => 'llama-3.3-70b-versatile',
                    'messages'    => $messages,
                    'max_tokens'  => 150,
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                Log::error('ChatbotController: Groq API error.', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return response()->json(
                    ['reply' => 'Thodi connectivity issue aa rahi hai, dobara bad mai message karna! Bye !'],
                    $response->status() >= 500 ? 502 : 400
                );
            }

            $data  = $response->json();
            $reply = trim($data['choices'][0]['message']['content'] ?? '');

            if (empty($reply)) {
                Log::warning('ChatbotController: Empty reply from Groq.', ['data' => $data]);
                return response()->json(['reply' => 'Kuch toh gadbad hai, dobara bad mai message karna! Bye !']);
            }

            // ── 6. Save assistant reply to DB ─────────────────
            $this->history->saveMessage($session, 'assistant', $reply);

            return response()->json(['reply' => $reply]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('ChatbotController: Connection timeout.', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Network slow lag rahi hai, thodi der mein message karna! Bye !'], 504);

        } catch (\Exception $e) {
            Log::error('ChatbotController: Unexpected error.', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Kuch gadbad ho gayi, baad mein message karna! Bye !'], 500);
        }
    }

    private function getPersonRelation(string $visitorName): ?string
    {
        $first = mb_strtolower(
            explode(' ', trim($visitorName))[0],
            'UTF-8'
        );

        // Normalize nicknames like "nidhiiii" → "nidhi", "aaayush" → "ayush"
        $normalized = preg_replace('/(.)\1{2,}/', '$1', rtrim($first, '0123456789'));

        $labels = [
            'colleague'     => 'office colleague',
            'family'        => 'family member',
            'school_friend' => 'school friend (Chamoli batch)',
            'bca_friend'    => 'BCA college friend (Tulas Institute)',
            'mca_friend'    => 'MCA college friend (SGRR University)',
        ];

        $matches = [];
        foreach ($labels as $key => $label) {
            if (
                in_array($first,      $this->knownPeople[$key], true) ||
                in_array($normalized, $this->knownPeople[$key], true)
            ) {
                $matches[] = $label;
            }
        }

        if (empty($matches))   return null;
        if (count($matches) === 1) return $matches[0];

        // Multiple matches — build a natural string like "family member aur MCA college friend"
        $last    = array_pop($matches);
        $combined = implode(', ', $matches) . ' aur ' . $last;
        return $combined;
    }



    // ── Add these two methods to ChatbotController ────────────────────────────
    // Also add these routes to web.php:
    //
    //   Route::get('/chatbot/history', [ChatbotController::class, 'history']);
    //   Route::post('/chatbot/reset',  [ChatbotController::class, 'reset']);
    // ─────────────────────────────────────────────────────────────────────────


    /**
     * GET /chatbot/history
     *
     * Returns the current session's message history so the frontend
     * can restore it on page load/refresh.
     *
     * Excludes the static greeting (first assistant message) because
     * the frontend already hard-codes it — we don't want it duplicated.
     */
    public function history(Request $request): JsonResponse
    {
        $key = $request->session()->get('uv_chat_session_id');

        if (!$key) {
            // No session yet — return empty so the frontend shows fresh greeting
            return response()->json(['messages' => []]);
        }

        $session = ChatSession::where('session_key', $key)
            ->whereNull('ended_at')
            ->where('last_active_at', '>=', now()->subMinutes(30)) // match SESSION_TIMEOUT_MINUTES
            ->first();

        if (!$session) {
            return response()->json(['messages' => []]);
        }

        $messages = ChatMessage::where('session_id', $session->id)
            ->orderBy('sent_at', 'asc')
            ->get()
            // ->skip(1) // skip the static greeting (always first row)
            ->map(fn($m) => [
                'role'    => $m->role,           // 'user' | 'assistant'
                'content' => $m->content,
                'sent_at' => $m->sent_at,        // ISO string — JS formats it
            ])
            ->values();

        return response()->json(['messages' => $messages]);
    }


    /**
     * POST /chatbot/reset
     *
     * Ends the current session (stamps ended_at) and removes the
     * session key cookie so the next message starts a fresh session.
     */
    public function reset(Request $request): JsonResponse
    {
        $key = $request->session()->get('uv_chat_session_id');

        if ($key) {
            // Mark current session as ended
            ChatSession::where('session_key', $key)
                ->whereNull('ended_at')
                ->update(['ended_at' => now()]);

            // Remove the key so resolveSession() creates a new one next time
            $request->session()->forget('uv_chat_session_id');
        }

        return response()->json(['status' => 'reset']);
    }
}