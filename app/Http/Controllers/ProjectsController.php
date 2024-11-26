<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectsRequest;
use App\Http\Requests\UpdateProjectsRequest;
use App\Models\Projects;
use App\Models\Stakeholders;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\OpenAIService;
use App\Services\GPTService;
use App\Models\AIResponse;

class ProjectsController extends Controller
{
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
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('projects.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', '!=', 'Super Admin')->get();

        return view('projects.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectsRequest $request)
    {
        $validatedData = $request->validated();
        $user_id = Auth::user()->id;

        // Create the project entry in the database
        $project = Projects::create([
            'name' => $validatedData['name'],
            'desc' => $validatedData['desc'],
            'domain' => implode(',', $validatedData['domain']),
            'tech_stack' => $validatedData['tech_stack'],
            'dev_methods' => implode(',', $validatedData['dev_methods']),
            'survey_methods' => implode(',', $validatedData['surveyMethod']),
            'non_functional_requirements' => $validatedData['nonFunctional'],
            'milestone' => $validatedData['milestone'],
            'additional_instruction' => $validatedData['additional_instruction'],
            'user_id' => $user_id,
        ]);

        if ($project) {
            // Save each stakeholder entry
            foreach ($validatedData['stakeholderName'] as $index => $stakeholderName) {
                Stakeholders::create([
                    'projects_id' => $project->id,
                    'user_id' => $validatedData['user_id'][$index] ?? '1',
                    // Uncomment if 'stakeholderRole' is part of validated data:
                    // 'role' => $validatedData['stakeholdersRole'][$index],
                ]);
            }

            $projectId = $project->id;
            $project = Projects::with('stakeholders.user')->find($projectId);

            // Generate prompt using selected fields to make it detailed and specific
            $prompt = "You are a project manager and team lead responsible for creating a Work Breakdown Structure (WBS) for a new project. Here are the details of the project:\n";
            $prompt .= "Project Name: " . $project->name . "\n";
            $prompt .= "Description: " . $project->desc . "\n";
            $prompt .= "Domain: " . $project->domain . "\n";
            $prompt .= "Technology Stack: " . $project->tech_stack . "\n";
            $prompt .= "Development Methodologies: " . implode(", ", explode(',', $project->dev_methods)) . "\n";
            $prompt .= "Survey Methods Used: " . implode(", ", explode(',', $project->survey_methods)) . "\n";
            $prompt .= "Non-Functional Requirements: " . $project->non_functional_requirements . "\n";
            $prompt .= "Project Milestones: " . $project->milestone . "\n";

            // Detailed instructions to GPT for creating the WBS
            $prompt .= "\nBased on the above information, please provide a very detailed Work Breakdown Structure (WBS) for this project.";
            $prompt .= "The WBS should include different phases such as initiation, planning, execution, monitoring, and closing. ";
            $prompt .= "For each phase, provide key tasks and deliverables in a structured manner, including technical aspects such as specific features or modules that need to be developed, tested, and deployed. You have to create parts for the development of the project.";
            $prompt .= "Focus on actionable tasks and steps that a development team can use to execute the project effectively. ";
            $prompt .= "Avoid repeating any titles or headers—provide only the new tasks and deliverables for each phase, and make sure not to include tasks that may already exist in similar projects.";

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
                    // 'requirement_id' => $project->id,
                    'prompt' => $prompt,
                    'response' => trim($entry)
                ]);
            }

            return redirect()->route('projects.index')->with('success', 'Project, stakeholders, and WBS entries created successfully!');
        } else {
            return back()->withErrors($request)->withInput();
        }
    }





    /**
     * Display the specified resource.
     */
    public function show(Projects $projects, $id)
    {
        // Fetch project details
        $projects = Projects::with('stakeholders.user', 'user')->where('id', $id)->first();

        // Fetch WBS requirements status-wise
        $wbsRequirements = [
            'to_do' => AIResponse::with('project')->where('project_id', $id)->where('status', 'to_do')->get(),
            'in_progress' => AIResponse::with('project')->where('project_id', $id)->where('status', 'in_progress')->get(),
            'completed' => AIResponse::with('project')->where('project_id', $id)->where('status', 'completed')->get(),
        ];

        // Return the view with project details and WBS requirements categorized by status
        return view('projects.developerView', [
            'projectId' => $id,
            'projects' => $projects,
            'wbsRequirements' => $wbsRequirements
        ]);
    }


    // public function analyzeProjectRequirement($id)
    // {
    //     // Fetch the project requirement
    //     $requirement = Projects::find($id);

    //     if (!$requirement) {
    //         return response()->json(['error' => 'Requirement not found'], 404);
    //     }

    //     // Generate the prompt
    //     $prompt = "Please analyze the following requirement: " . $requirement->details . " and suggest a detailed Work Breakdown Structure.";

    //     // Get the response from GPT
    //     $response = $this->gptService->analyzeText($prompt);

    //     // Store the response in the database
    //     $gptResponse = new AIResponse();
    //     $gptResponse->requirement_id = $requirement->id;
    //     $gptResponse->prompt = $prompt;
    //     $gptResponse->response = $response;
    //     $gptResponse->save();

    //     // Return response or view
    //     return response()->json(['gptResponse' => $gptResponse]);
    // }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $projects)
    {
        //
    }

    // public function projectDetails($id)
    // {
    //     $projects = Projects::with('stakeholders.user', 'user')->where('id', $id)->first();

    //     // Format the project data into a prompt for GPT-4
    //     $prompt = "Project Details:\n";
    //     $prompt .= "Project Name: " . $projects->name . "\n";
    //     $prompt .= "Domain: " . $projects->domain . "\n";
    //     $prompt .= "Description: " . $projects->description . "\n";
    //     $prompt .= "Tech Stack: " . $projects->tech_stack . "\n";

    //     $devMethods = is_string($projects->dev_methods) ? json_decode($projects->dev_methods, true) : $projects->dev_methods;
    //     $surveyMethods = is_string($projects->surveyMethod) ? json_decode($projects->surveyMethod, true) : $projects->surveyMethod;

    //     $prompt .= "Development Methods: " . (is_array($devMethods) ? implode(', ', $devMethods) : $devMethods) . "\n";
    //     $prompt .= "Survey Methods: " . (is_array($surveyMethods) ? implode(', ', $surveyMethods) : $surveyMethods) . "\n";

    //     $prompt .= "Non-Functional Requirements: " . $projects->nonFunctional . "\n";
    //     $prompt .= "Project Milestones: " . $projects->milestone . "\n";
    //     $prompt .= "Additional Instructions: " . $projects->additional_instruction . "\n";
    //     $prompt .= "Stakeholders:\n";
    //     foreach ($projects->stakeholders as $stakeholder) {
    //         $prompt .= "- Name: " . $stakeholder->user->name . ", Role: " . $stakeholder->user->role . "\n";
    //     }

    //     // Use GPTService to process the prompt and generate insights
    //     $gptService = new GPTService();
    //     $gptResponse = $gptService->processMessage($prompt);

    //     // Return view with project and AI response
    //     return view('projects.developerView', compact('projects', 'gptResponse'));
    // }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectsRequest $request, Projects $projects)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $projects)
    {
        //
    }
}
