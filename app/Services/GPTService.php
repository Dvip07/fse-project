<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GPTService
{
    // private $apiKey;
    private $endpoint;



    public function __construct()
    {
        // $this->apiKey = env('OPENAI_API_KEY');
        $this->endpoint = 'https://api.openai.com/v1/chat/completions';
    }

    public $apiKey = '';

    // public function processMessage($prompt, $maxTokens = 1000)
    // {
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $this->apiKey,
    //     ])->post($this->endpoint, [
    //         'model' => 'gpt-4',
    //         'prompt' => $prompt,
    //         'max_tokens' => $maxTokens,
    //     ]);

    //     if ($response->successful()) {
    //         Log::info('GPT-4 API Response', $response->json());
    //         return $response->json()['choices'][0]['text'];
    //     }

    //     Log::error('GPT-4 API Error', ['response' => $response->body()]);

    //     return null; // or handle error appropriately
    // }

    // public function analyzeText($prompt, $maxTokens = 150)
    // {
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $this->apiKey,
    //         'Content-Type' => 'application/json',
    //     ])->post($this->endpoint, [
    //                 'model' => 'gpt-4',
    //                 'messages' => [
    //                     [
    //                         'role' => 'user',
    //                         'content' => $prompt,
    //                     ]
    //                 ],
    //                 'max_tokens' => $maxTokens,
    //             ]);

    //     // Log entire response for debugging
    //     Log::info('GPT-4 API Response:', [
    //         'status' => $response->status(),
    //         'body' => $response->body(),
    //     ]);

    //     // Handle the successful response
    //     if ($response->successful()) {
    //         return $response->json()['choices'][0]['message']['content'] ?? '';
    //     }

    //     // Log an error if the response fails
    //     Log::error('GPT API Error:', [
    //         'status' => $response->status(),
    //         'error' => $response->body(),
    //     ]);

    //     return null; // or handle error appropriately
    // }

    public function analyzeText($prompt, $maxTokens = 400)
    {
        Log::info('Using API Key:', ['apiKey' => $this->apiKey]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->endpoint, [
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt,
                ]
            ],
            'max_tokens' => $maxTokens,
        ]);
        

        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $this->apiKey,
        //     'Content-Type' => 'application/json',
        // ])->post($this->endpoint, [
        //             'model' => 'gpt-4',
        //             'messages' => [
        //                 [
        //                     'role' => 'user',
        //                     'content' => $prompt,
        //                 ]
        //             ],
        //             'max_tokens' => $maxTokens,
        //         ]);

        // Log entire response for debugging
        Log::info('GPT-4 API Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'] ?? '';
        }

        Log::error('GPT API Error:', [
            'status' => $response->status(),
            'error' => $response->body(),
        ]);

        return null;
    }


}
