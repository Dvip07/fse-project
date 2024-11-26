<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequirementsRequest;
use App\Http\Requests\UpdateRequirementsRequest;
use App\Models\Requirements;
use App\Models\AIResponse;
use App\Models\Projects;
use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Services\GPTService;

class RequirementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('requirements.create');
    }

    protected $openAIService;
    protected $gptService;
    public function __construct(OpenAIService $openAIService, GPTService $gptService)
    {
        $this->gptService = $gptService; {
            $this->openAIService = $openAIService;
        }
    }

    public function processRequirement(Request $request)
    {
        $requirement = $request->input('requirement');
        $classificationPrompt = "Classify this requirement as functional or non-functional: $requirement";
        $classification = $this->openAIService->getChatGPTResponse($classificationPrompt);

        return response()->json($classification);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequirementsRequest $request)
    {
        $validatedData = $request->validated();

        // Create the new requirement entry in the database
        $requirements = Requirements::create([
            'project_id' => $validatedData['projectId'],
            'title' => $validatedData['requirementTitle'],
            'desc' => $validatedData['requirementDescription'],
            'ai_response_id' => $validatedData['relatedTask'],
            'priority' => $validatedData['requirementPriority'],
            'created_by' => $validatedData['user_id'],
        ]);

        if ($requirements) {
            // Get the project details
            $project = Projects::with('stakeholders.user')->find($validatedData['projectId']);


            if (!$project) {
                return back()->withErrors(['error' => 'Project not found'])->withInput();
            }

            // Retrieve existing AI responses (WBS)
            $wbsRequirements = AIResponse::where('project_id', $project->id)->get();

            // Construct the existing requirements section of the prompt
            $existingRequirements = "Existing Requirements and Tasks: \n";
            foreach ($wbsRequirements as $requirement) {
                $existingRequirements .= "- " . $requirement->response . "\n";
            }

            // Construct the prompt for GPT
            $prompt = "I have a project that requires an update to the Work Breakdown Structure (WBS). Here are the details of the project:\n";
            $prompt .= "Project Name: " . $project->name . "\n";
            $prompt .= "Description: " . $project->desc . "\n";
            $prompt .= "Domain: " . $project->domain . "\n";
            $prompt .= "Technology Stack: " . $project->tech_stack . "\n";
            $prompt .= "Development Methodologies: " . implode(", ", explode(',', $project->dev_methods)) . "\n";
            $prompt .= "Survey Methods Used: " . implode(", ", explode(',', $project->survey_methods)) . "\n";
            $prompt .= "Non-Functional Requirements: " . $project->non_functional_requirements . "\n";
            $prompt .= "Project Milestones: " . $project->milestone . "\n";

            // Add existing requirements to the prompt
            $prompt .= "\n" . $existingRequirements;

            // Add the new requirement details
            $prompt .= "\nThis is a new requirement for the current project:\n";
            $prompt .= "New Requirement Title: " . $validatedData['requirementTitle'] . "\n";
            $prompt .= "Description: " . $validatedData['requirementDescription'] . "\n";
            $prompt .= "Priority: " . $validatedData['requirementPriority'] . "\n";

            // Final WBS request with instructions to avoid repeating tasks or including the title
            $prompt .= "\nBased on the above information, please provide a detailed Work Breakdown Structure (WBS) for this project. ";
            $prompt .= "The WBS should include different phases such as initiation, planning, execution, monitoring, and closing. ";
            $prompt .= "For each phase, provide key tasks and deliverables in a structured manner. ";
            $prompt .= "Make sure to avoid duplicating tasks that are already included in the existing requirements. ";
            $prompt .= "Please also avoid repeating any title or header information, and focus on listing only the new tasks and deliverables for each phase.";

            // Get GPT analysis
            $response = $this->gptService->analyzeText($prompt);

            // Assume response contains multiple WBS entries separated by newlines or some delimiter
            $wbsEntries = explode("\n", $response);

            // Loop through each WBS entry and save it to the database
            foreach ($wbsEntries as $entry) {
                // Skip if the entry is empty
                if (trim($entry) == '') {
                    continue;
                }

                // Save each WBS entry to the database
                AIResponse::create([
                    'project_id' => $project->id,
                    'prompt' => $prompt,
                    'response' => trim($entry)
                ]);
            }

            return redirect()->route('projects.show', ['project' => $project->id])
                ->with('success', 'Requirement and WBS entries created successfully!');

        } else {
            return back()->withErrors($request)->withInput();
        }
    }

    public function updateStatus(Request $request, $taskId)
    {
        // Find the task
        $task = AIResponse::find($taskId);

        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }

        // Update the task status
        $task->status = $request->input('status');
        $task->save();

        return response()->json(['success' => true, 'message' => 'Task status updated successfully']);
    }



    /**
     * Display the specified resource.
     */
    public function show(Requirements $requirements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requirements $requirements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequirementsRequest $request, Requirements $requirements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requirements $requirements)
    {
        //
    }
}
