<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use App\Services\GptService;
use Illuminate\Support\Facades\Log;
use App\Models\AIResponse;

class GPTController extends Controller
{
    protected $gptService;

    public function __construct(GptService $gptService)
    {
        $this->gptService = $gptService;
    }

    public function testGPTConnection()
    {
        try {
            // Test Prompt
            $prompt = "Please provide a brief description of a Learning Management System (LMS).";

            // Make a request to GPT
            $response = $this->gptService->analyzeText($prompt);

            if ($response) {
                return response()->json(['success' => true, 'response' => $response]);
            } else {
                return response()->json(['success' => false, 'message' => 'No response received from GPT. Check logs for details.']);
            }
        } catch (\Exception $e) {
            Log::error('Error in testing GPT connection: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error in connecting to GPT.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function analyze(Request $request)
    {
        $prompt = $request->input('prompt');
        $analysis = $this->gptService->analyzeText($prompt);
        return response()->json(['analysis' => $analysis]);
    }

    public function analyzeAndStoreResponse($projectId)
    {
        // Fetch project details
        $project = Projects::with('stakeholders.user')->find($projectId);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        // Generate prompt using selected fields
        $prompt = "Analyze the following project details:\n";
        $prompt .= "Project Name: " . $project->name . "\n";
        $prompt .= "Description: " . $project->desc . "\n";
        $prompt .= "Tech Stack: " . $project->tech_stack . "\n";
        $prompt .= "Development Methodology: " . implode(", ", $project->dev_methods) . "\n";
        $prompt .= "Suggest a detailed Work Breakdown Structure (WBS).";

        // Get GPT analysis
        $response = $this->gptService->analyzeText($prompt);

        // Save the GPT response in the database
        AIResponse::create([
            'requirement_id' => $project->id,
            'prompt' => $prompt,
            'response' => $response
        ]);

        return response()->json(['message' => 'GPT Analysis Saved']);
    }


}
