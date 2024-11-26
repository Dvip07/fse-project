<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function getChatGPTResponse($messages, $maxTokens = 500, $temperature = 0.7, $model = 'gpt-4')
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model, // Use 'gpt-4' or 'gpt-4-turbo'
            'messages' => $messages,
            'max_tokens' => $maxTokens,
            'temperature' => $temperature,
        ]);

        if ($response->successful()) {
            return $response->json('choices.0.message.content');
        } else {
            throw new \Exception('Error communicating with OpenAI API: ' . $response->body());
        }
    }
}
