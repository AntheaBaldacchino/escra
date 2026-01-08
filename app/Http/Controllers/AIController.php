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
        $user = User::where('user_code', $code)->firstOrFail();
        $doc  = Document::where('user_id', $user->id)->firstOrFail();

        $text = trim((string) $doc->content);
        if ($text === '') {
            return response()->json(['error' => 'Write something first.'], 422);
        }

        $apiKey = env('GEMINI_API_KEY');
        $model  = env('GEMINI_MODEL', 'gemini-2.5-flash');

        // Construct prompt
        $prompt = "You are a writing assistant. Based on the text below, return ONE short idea to continue the story. "
                . "One sentence only. No lists. No quotes.\n\nTEXT:\n"
                . mb_substr($text, 0, 2000);

        // Gemini generateContent endpoint (Developer API)
        // Docs: generateContent endpoint structure and request format :contentReference[oaicite:3]{index=3}
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::timeout(25)->post($url, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.8,
                'maxOutputTokens' => 60,
            ],
        ]);

        if (!$response->successful()) {
            return response()->json([
                'error' => 'AI request failed.',
                'details' => $response->json(),
            ], 500);
        }

        $data = $response->json();

        // Typical response: candidates[0].content.parts[0].text
        $idea = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $idea = trim((string) $idea);

        // Extract first sentence
        $idea = preg_split('/(?<=[.!?])\s+/', $idea, 2)[0] ?? $idea;
        $idea = trim($idea);

        if ($idea === '') {
            return response()->json(['error' => 'AI returned empty output.'], 500);
        }

        return response()->json(['idea' => $idea]);
    }
}
