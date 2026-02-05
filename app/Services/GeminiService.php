<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key') ?? env('GEMINI_API_KEY');
    }

    public function generateContent($prompt, $systemInstruction = null)
    {
        try {
            $contents = [];
            
            if ($systemInstruction) {
                // Prepend system instruction as a user message or context
                // 'system_instruction' param is available in beta API but for simplicity and robustness
                // with the 'generateContent' endpoint, we can embed it.
                // However, let's try to use the proper internal structure if possible.
                // For now, prepending is the most reliable "hack" if the specific model version support varies.
                // Let's format it clearly.
                $finalPrompt = "SYSTEM INSTRUCTION:\n" . $systemInstruction . "\n\nUSER REQUEST:\n" . $prompt;
            } else {
                $finalPrompt = $prompt;
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $finalPrompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Gemini API Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return null;
        }
    }
}
