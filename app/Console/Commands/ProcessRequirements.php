<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Requirement;
use App\Models\AIResponse;
use App\Services\GPTService;

class ProcessRequirements extends Command
{
    protected $signature = 'requirements:process';
    protected $description = 'Process new requirements using GPT-4';

    private $gptService;

    public function __construct(GPTService $gptService)
    {
        parent::__construct();
        $this->gptService = $gptService;
    }

    public function handle()
    {
        $requirements = Requirement::where('processed', false)->get();

        foreach ($requirements as $requirement) {
            // Generate response using GPT-4
            $functionalPrompt = "Categorize this requirement into functional: " . $requirement->message;
            $functionalResponse = $this->gptService->processMessage($functionalPrompt);

            $nonFunctionalPrompt = "Categorize this requirement into non-functional: " . $requirement->message;
            $nonFunctionalResponse = $this->gptService->processMessage($nonFunctionalPrompt);

            $wbsPrompt = "Generate a work breakdown structure for this requirement: " . $requirement->message;
            $wbsResponse = $this->gptService->processMessage($wbsPrompt);

            // Save AI response to the database
            AIResponse::create([
                'requirement_id' => $requirement->id,
                'functional_description' => $functionalResponse,
                'non_functional_description' => $nonFunctionalResponse,
                'work_breakdown_structure' => $wbsResponse,
            ]);

            // Mark requirement as processed
            $requirement->processed = true;
            $requirement->save();
        }
    }
}

