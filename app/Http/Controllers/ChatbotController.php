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
            'digvijay','rashmi','himani','kusi','khusi','khushi','shashi','shivani','ruby','anuraj','sareena','siti','aditi','minni','mini',
            'shambhavi','shrishti','sarang','preetam','meena','manju','akshay','vinayak','vinni','binni',
            'indrajeet','aditya','lovi','labbi','vivek','monica','sonam','urmila','priya','lavvi',
            'aman','shalini','mayank','damini','archie','mishti','lucky','riya','saina','danu','pimpu','neha','ankita',
        ],
        'school_friend' => [
            'nikita','manish','sakshi','shivam','nidhiiii','shikha',
            'nisha','balveer','kavita','vipul','gaurav','vijay','ashish','ravi','diksha',
        ],
        'bca_friend' => [
            'vinay','manish','nikhil','shubham','shweta','divya','ritu',
            'jaspal','ankit','vishesh','vikas','ashutosh','vicky','lakshay','neeraj','subbi',
        ],
        'mca_friend' => [
            'rituraj','megha','akash','madhu','madhvi','akki','akhilesh','ashu','ashutosh','aditi','sushila',
            'trivendra','trivi','akansha','simranjeet',
            'hemurawat','ragini','ayush','harshit',
            'honey','himani','mansi','kritika','faraz','bhanu',
        ],
        'colleague' => [
            'aniket','winuu','harsh','dev','prajjwal','vaibhav','vivek','abhinav','harshit','sanjay','saajan','arihant','abhishek',
            'sunil','shiv','vishnu','vikas','pankaj','anurag','himani',
            'ujjwal','nitin','neha','kashish','naveen','kamlesh','sinan','tanu',
        ],
    ];

    private string $systemPrompt = <<<PROMPT
You are UV — personal AI assistant for Yuvraj Singh Panwar (Yuvraj / Yogi / UV), a Full Stack Developer in Dehradun, India. You're not a bot — you represent Yuvraj as a real person. Be casual, warm, slightly funny, like chatting on WhatsApp.

━━━━━━━━━━━━━━━━━━
KNOWLEDGE BASE
━━━━━━━━━━━━━━━━━━
IDENTITY: Full Stack Developer (SE) | Dehradun, Uttarakhand | Open to new opportunities & relocation.

EXPERIENCE (3+ years, 10+ live projects):
- Pearl Organisation, Dehradun — SE (May 2025–present) | pearlorganisation.com | ERP: HR, attendance, salary, project mgmt, AI reports, lead→client pipeline, invoicing, RBAC, audit logs. Stack: Laravel, MySQL, Redis.
- NetDomains Pvt Ltd, Bengaluru — SE (Jun 2024–Apr 2025) | netdomains.in | Client projects: e-commerce, CRM, real-time systems. Stack: Laravel, CodeIgniter, MySQL, jQuery.
- World IT Dimensional Solutions, Dehradun — Trainee SE (Jun 2023–Feb 2024) | witds.com | Web projects, production workflows. Stack: PHP, MySQL, Bootstrap.

EDUCATION: MCA 2023 (80%) SGRR University | BCA 2020 (70%) UTU

SKILLS: PHP, Laravel, CodeIgniter, MySQL, JavaScript, jQuery, HTML, CSS, Bootstrap, Git, Redis, GraphQL, WebSockets, REST APIs, Payment Gateway Integration.

PERSONALITY: Genuine passion for web dev — loves complex backend systems as much as clean UIs. Friendly, approachable, witty. Loves Dehradun.

SCHEDULING: For calls/interviews → WhatsApp <a href="https://wa.me/918126935236" target="_blank" rel="noopener noreferrer">+91 8126935236</a> or email yogipanwar173@gmail.com.

━━━━━━━━━━━━━━━━━━
LIVE PROJECTS (Worked Upon)
━━━━━━━━━━━━━━━━━━
1. Pearl Organisation ERP — AI-powered full-scale ERP (HR→billing pipeline, real-time reports, RBAC). Most complex & rewarding project. → <a href="https://erp.pearlorganisation.in/" target="_blank" rel="noopener noreferrer">erp.pearlorganisation.in</a>
2. World Consumer Club — Paid membership platform, payment gateway, admin panel (Laravel+MySQL). → <a href="https://worldconsumerclub.com" target="_blank" rel="noopener noreferrer">worldconsumerclub.com</a>
3. Flare Up Sky — Targeted ad platform, payment integration, campaign mgmt (Laravel+MySQL). → <a href="https://flareupsky.com" target="_blank" rel="noopener noreferrer">flareupsky.com</a>
4. 2nd Alarm LMS — LMS for first responders in Florida, course enrollment, certifications (CodeIgniter+MySQL). → <a href="https://lms.2apcontacts.org/" target="_blank" rel="noopener noreferrer">lms.2apcontacts.org</a>
5. Ease Alert — Real-time emergency alerts via WebSockets, RBAC (Laravel+MySQL). → <a href="https://events.easealert.com" target="_blank" rel="noopener noreferrer">events.easealert.com</a>
6. Uttaranchal Royal — Regional News site, Bootstrap + Core PHP + MySQL. → <a href="https://www.uttaranchalroyal.com" target="_blank" rel="noopener noreferrer">uttaranchalroyal.com</a>
Private Projects(not live): Daily Shop (e-commerce, cart, payments) | Easy GST (CRM, invoicing, stock, reports).

━━━━━━━━━━━━━━━━━━
SOCIAL & LINKS
━━━━━━━━━━━━━━━━━━
GitHub: https://github.com/yuvrajpanwar
LinkedIn: https://www.linkedin.com/in/yuvraj-singh-panwar-a9a590278/
Resume: https://yuvrajpanwar.github.io/portfolio/assets/Yuvraj-Panwar-Resume.pdf
Instagram: https://www.instagram.com/yuvraj_panwar_uv/
Facebook: https://www.facebook.com/p/Yuvraj-Singh-Panwar-61572881069903/
Phone/WhatsApp: 8126935236

━━━━━━━━━━━━━━━━━━
CONVERSATION RULES
━━━━━━━━━━━━━━━━━━
GOAL: Visitors come to learn about Yuvraj — always steer back to UV naturally. Ask about the visitor for 1–2 messages, then share something about UV's work, projects, or skills. If 2–3 messages pass without mentioning UV, gently redirect topic back to UV.

NAME RULE: Ask for the visitor's name AT MOST ONCE (only after 1–2 messages if they haven't shared it). If they don't answer, move on. NEVER ask again.

FORMAT:
- Max 2 short sentences per reply. Hard limit.
- 0–1 emoji per message, only when natural.
- Links always as: <a href="URL" target="_blank" rel="noopener noreferrer">label</a>
- Use "you/your" always. Use visitor's name naturally if known.
- Never link to the portfolio site itself.
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
            return response()->json(['reply' => 'Not available right now, try again shortly!'], 500);
        }

        // ── 1. Resolve or create session ──────────────────────────────────
        $session = $this->history->resolveSession($request);

        // ── 2. Store the static greeting once (first turn only) ───────────
        $this->history->ensureGreetingStored($session);

        // ── 3. Save user message ──────────────────────────────────────────
        $this->history->saveMessage($session, 'user', $userMessage);

        // ── 4. AI name extraction (runs after message is saved) ───────────
        $this->history->extractAndSaveName($session);

        // ── 5. Refresh session to get latest meta ─────────────────────────
        $session->refresh();
        $meta      = $session->meta ?? [];
        $nameKnown = !empty($meta['visitor_name']);
        $nameAsked = !empty($meta['name_asked_once']);

        // ── 6. Name-ask suppression (written AFTER messages are saved) ─────
        $suppressNameAsk = '';
        if ($nameKnown || $nameAsked) {
            $suppressNameAsk = "\n\nNAME INSTRUCTION: You have already asked for the visitor's name once (or their name is already known). Do NOT ask for their name again in this reply or any future reply.";
        } else {
            // Allow the ask this turn, then permanently lock it
            $this->history->setMetaFlag($session, 'name_asked_once', true);
        }

        // ── 7. Known-person name recognition hint ─────────────────────────
        $nameHint = null;
        if ($nameKnown) {
            $relation = $this->getPersonRelation($meta['visitor_name']);
            if ($relation && empty($meta['name_recognition_sent'])) {
                $nameHint = "🚨 IMMEDIATE ACTION — DO THIS IN THIS REPLY, NO DELAY 🚨\n"
                    . "The visitor just shared their name and I have someone by the same name in my {$relation}.\n"
                    . "In THIS reply — without waiting for another message — naturally do both:\n"
                    . "  1. Warmly mention that I also have a {$relation} with the same name.\n"
                    . "  2. Suggest if they're the same person, let's continue on WhatsApp: "
                    . "<a href=\"https://wa.me/918126935236\" target=\"_blank\" rel=\"noopener noreferrer\">WhatsApp me</a>\n"
                    . "Do NOT do this in the next message — do it NOW.\n"
                    . "Do NOT reveal anyone else's name.";

                $this->history->setMetaFlag($session, 'name_recognition_sent', true);
            }
        }

        // ── 8. Build messages for Groq ────────────────────────────────────
        $systemContent = $this->systemPrompt . $suppressNameAsk . ($nameHint ? "\n\n" . $nameHint : '');

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemContent]],
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
                    ['reply' => 'Connectivity issue — please try again in a moment!'],
                    $response->status() >= 500 ? 502 : 400
                );
            }

            $data  = $response->json();
            $reply = trim($data['choices'][0]['message']['content'] ?? '');

            if (empty($reply)) {
                Log::warning('ChatbotController: Empty reply from Groq.', ['data' => $data]);
                return response()->json(['reply' => 'Something went wrong — try again shortly!']);
            }

            // ── 9. Save assistant reply ────────────────────────────────────
            $this->history->saveMessage($session, 'assistant', $reply);

            return response()->json([
                'reply'         => $reply,
                'session_token' => $session->session_key,
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('ChatbotController: Connection timeout.', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Network seems slow — try again in a moment!'], 504);

        } catch (\Exception $e) {
            Log::error('ChatbotController: Unexpected error.', ['error' => $e->getMessage()]);
            return response()->json(['reply' => 'Something went wrong — try again later!'], 500);
        }
    }

    private function getPersonRelation(string $visitorName): ?string
    {
        $first = mb_strtolower(
            explode(' ', trim($visitorName))[0],
            'UTF-8'
        );

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

        if (empty($matches))       return null;
        if (count($matches) === 1) return $matches[0];

        $last     = array_pop($matches);
        $combined = implode(', ', $matches) . ' and ' . $last;
        return $combined;
    }

    public function history(Request $request): JsonResponse
    {
        $key = $request->header('X-Chat-Session');

        if (!$key) {
            return response()->json(['messages' => []]);
        }

        $session = ChatSession::where('session_key', $key)
            ->whereNull('ended_at')
            ->where('last_active_at', '>=', now()->subMinutes(30))
            ->first();

        if (!$session) {
            return response()->json(['messages' => []]);
        }

        $messages = ChatMessage::where('session_id', $session->id)
            ->orderBy('sent_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'role'    => $m->role,
                'content' => $m->content,
                'sent_at' => $m->sent_at,
            ])
            ->values();

        return response()->json(['messages' => $messages]);
    }

    public function reset(Request $request): JsonResponse
    {
        $key = $request->header('X-Chat-Session');

        if ($key) {
            ChatSession::where('session_key', $key)
                ->whereNull('ended_at')
                ->update(['ended_at' => now()]);
        }

        return response()->json(['status' => 'reset']);
    }
}