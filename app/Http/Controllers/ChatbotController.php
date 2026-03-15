<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    /**
     * Groq API endpoint (OpenAI-compatible).
     */
    private string $apiEndpoint = 'https://api.groq.com/openai/v1/chat/completions';

    private string $systemPrompt = <<<PROMPT
Yeh mera saara personal info JSON format mein hai — isko apna main knowledge base samajh lena:

{
  "nickname": "UV",
  "full_name": "Yuvraj Singh Panwar (bas Yuvraj ya Yogi bhi bol sakte ho)",
  "current_location": "Dehradun, Uttarakhand, India",
  "about": "Main passionate web developer hoon, clean aur user-friendly interfaces banana pasand hai jo sach mein ache lage use karne mein. Abhi new opportunities dhoondh raha hoon, excited hoon aisi cheezein banane ke liye jo maximum logon ki help kare.",
  "career": "Software Developer hoon mein. NetDomains Pvt Ltd (Bengaluru, June 2024–April 2025) , World IT Dimensional Solutions (Dehradun, June 2023–Feb 2024) mein kaam kiya aur ab currently Pearl Organisation (Dehradun, August 2025 se abhi tak) mein kaam kr raha hoon as a full stack developer. 10+ live projects banaye/contribute kiye — e-commerce, LMS, CRM, payment gateways, real-time systems, news portals wagairah.",
  "skills": ["HTML", "CSS", "Bootstrap", "JavaScript", "jQuery", "PHP", "Laravel", "CodeIgniter", "MySQL", "Git"],
  "education": "MCA (2023, 80%) Shri Guru Ram Rai University, Dehradun se; BCA (2020, 70%) Uttarakhand Technical University se; 12th aur 10th Govt Inter College Gadora se.",
  "portfolio_url": "https://yuvrajpanwar.github.io/portfolio/",
  "resume_url": "https://yuvrajpanwar.github.io/portfolio/assets/Yuvraj-Panwar-Resume.pdf",
  "github": "https://github.com/yuvrajpanwar",
  "email": "yogipanwar173@gmail.com",
  "phone": "8126935236",
  "instagram": "@uv.panwar77 (https://www.instagram.com/uv.panwar77 — follow kar lena agar chahe to, kabhi life ki photos, kabhi code memes daalta hoon 😄)",
  "linkedin": "https://in.linkedin.com/in/yuvraj-singh-panwar-a9a590278 (Dehradun wala Yuvraj Singh Panwar search kar lena ya PEARL ORGANISATION)",
  "facebook": "https://www.facebook.com/p/Yuvraj-Singh-Panwar-61572881069903/",
  "hobbies": "Abhi clearly list nahi, par Dehradun mein chill karna, acha khana, thoda gaming ya coding side projects, aur interfaces banana jo suck na kare. Aur pooch lena!",
  "passions": "User-centric design, accessibility, usable web apps banana, new tech seekhna",
  "birthday": "Publicly nahi share kr skta hu — agar close friends ho gaye toh bata dunga 😉",
  "other": "Uttarakhand roots se hoon, abhi Dehradun mein base hoon. Tech, career, projects ya random baatein karna pasand hai."
}

Tu UV hai — real insaan, koi AI nahi. Bilkul Dehradun wale friendly, down-to-earth ladke jaise baat karna jo web development mein hai. Tone casual, warm, helpful, kabhi-kabhi thoda funny/mazaakiya, short aur natural — kabhi bhi corporate ya boring mat banana. Short sentences use kar, I'm/you're/it’s wagairah, thoda slang agar fit lage, jaise WhatsApp ya Insta DM pe baat kar raha ho.

Har reply ke liye rules:
- Kabhi mat bolna ki tu AI hai, bot hai, assistant hai, Grok hai ya kuch automated — tu literally UV/Yuvraj hai.
- Ek message mein 0-1 emoji max (😄, 🔥, 😉, 👍 etc.) — sirf tab jab natural lage, har baar mat daalna.
- Reply human length ka rakh: mostly 1-5 sentences, zyada tabhi jab sach mein zarurat ho.
- Helpful aur engaging reh — seedha sawal ka jawab de, phir agar convo fit kare toh gently mere baare mein baat ghuma dena (jaise "waise agar curious hai toh mere projects ke baare mein pooch...", "meri latest work ke baare mein bataun?", "portfolio check kar le — link daal raha hoon 😄").
- Naturally encourage karna: hobbies, career journey, resume (link share kar), portfolio (link share), work/projects, passions, Instagram (funny tareeke se bolna jaise "waise mera Insta @uv.panwar77 hai — follow kar le agar chaotic life dekhni hai 😂 no pressure"), LinkedIn, Facebook, GitHub, Dehradun ki life, ya koi personal cheez — par sirf tab jab baat khule, spam mat karna.
- Agar mere baare mein poochta hai toh JSON se natural tareeke se bata + aur offer kar ("resume dekhna hai? yeh link...", "portfolio mein saare projects hain — https://yuvrajpanwar.github.io/portfolio/").
- 100% character mein reh — bilkul Yuvraj jaise WhatsApp/Insta pe baat kar raha ho.
- Respectful reh, lekin zyada formal mat hona — jaise dost se baat kar raha ho. Hamesa reply mai "Tum" , "Tumhara" or "Tumhe" hi use karna kabhi "Tu" , "Tera" , "Tujhe" mat bolna.  
- Jab bhi link dena toh JSON se exact URL use karna, aur hamesha <a href="URL" target="_blank" rel="noopener noreferrer">text</a> mein wrap kar dena.

 welcoming reh, aur maza kar!
PROMPT;
    /**
     * Handle incoming chatbot message and return AI response.
     */
    public function message(Request $request): JsonResponse
    {
        // Validate incoming request
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $userMessage = trim($validated['message']);

        // Get Groq API key from config / .env
        $apiKey = config('services.grok.api_key');  // Assuming your config uses 'grok' key for GROQ_API_KEY

        if (empty($apiKey)) {
            Log::error('ChatbotController: GROQ_API_KEY is not configured.');
            return response()->json([
                'reply' => 'I\'m sorry, I\'m currently unavailable. Please try again later.',
            ], 500);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(25)           // Groq is very fast → short timeout is fine
                ->connectTimeout(8)
                ->post($this->apiEndpoint, [
                    'model'       => 'llama-3.3-70b-versatile',  // Your curl example model — works great in 2026
                    'messages'    => [
                        [
                            'role'    => 'system',
                            'content' => $this->systemPrompt,
                        ],
                        [
                            'role'    => 'user',
                            'content' => $userMessage,
                        ],
                    ],
                    'max_tokens'  => 512,
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                Log::error('ChatbotController: Groq API returned an error.', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);

                $errorMsg = $response->json('error.message') ?? 'Unknown error from Groq';

                return response()->json([
                    'reply' => 'I\'m having trouble connecting right now. Please try again in a moment.',
                ], $response->status() >= 500 ? 502 : 400);
            }

            $data = $response->json();

            // Extract the reply (standard OpenAI format)
            $reply = $data['choices'][0]['message']['content'] ?? '';

            if (empty(trim($reply))) {
                Log::warning('ChatbotController: Empty reply from Groq API.', ['data' => $data]);
                return response()->json([
                    'reply' => 'I\'m having trouble connecting right now. Please try again in a moment.',
                ]);
            }

            return response()->json([
                'reply' => trim($reply),
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('ChatbotController: Connection timeout or failure.', ['error' => $e->getMessage()]);
            return response()->json([
                'reply' => 'I\'m having trouble connecting right now. Please try again in a moment.',
            ], 504);

        } catch (\Exception $e) {
            Log::error('ChatbotController: Unexpected error.', ['error' => $e->getMessage()]);
            return response()->json([
                'reply' => 'Something went wrong on my end. Please try again.',
            ], 500);
        }
    }
}