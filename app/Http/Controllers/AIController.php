<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function generate(Request $request, string $code)
    {
        // Find user and document
        $user = User::where('user_code', $code)->firstOrFail();
        $doc  = Document::where('user_id', $user->id)->firstOrFail();

        // Get and validate text
        $text = trim((string) $doc->content);

        // Validate input that returns JSON response
        if ($text === '') {
            return response()->json(['error' => 'Write something first.'], 422);
        }

        // API key and model from .env
        $apiKey = env('GEMINI_API_KEY');
        $model = env('GEMINI_MODEL', 'gemini-1.5-flash');
        
        // Check API key
        if (!$apiKey) {
            return response()->json(['error' => 'Missing GEMINI_API_KEY in .env'], 500);
        }

        // Construct prompt
        $prompt =
        "You are a creative writing assistant.\n\n" .
        "Based on the text below, generate ONE useful idea to continue the story.\n" .
        "Requirements:\n" .
        "- 1–2 sentences\n" .
        "- 20–45 words\n" .
        "- Specific, vivid, and actionable (introduce a complication, reveal, or choice)\n" .
        "- No bullet points, no lists\n\n" .
        "TEXT:\n" . mb_substr($text, 0, 2000);


        // Gemini generateContent endpoint (Developer API)
        // Docs: generateContent endpoint structure and request format :contentReference[oaicite:3]{index=3}
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        // Make HTTP request to Gemini API (Payload)
        $response = Http::timeout(25)->post($url, [
            'contents' => [
                [
                    // User prompt
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],// Configuration
            'generationConfig' => [
                'temperature' => 0.9,
                'maxOutputTokens' => 140,
                'topP' => 0.95,
            ],
        ]);

        // If request failed
       if (!$response->successful()) {
            return response()->json([
                'error' => 'AI request failed.',
                'status' => $response->status(),
                'body' => $response->body(),
            ], 500);
        }


        // Parse response
        $data = $response->json();

        // Extract generated idea
        $idea = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Clean and trim idea
        $idea = trim((string) $idea);

        // Limit to first 2 sentences
        $sentences = preg_split('/(?<=[.!?])\s+/', $idea);
        
        $idea = trim(implode(' ', array_slice($sentences, 0, 2))
        );

        if ($idea === '') {
            return response()->json(['error' => 'AI returned empty output.'], 500);
        }

        // Return idea as JSON response
        return response()->json(['idea' => $idea]);
    }
}
