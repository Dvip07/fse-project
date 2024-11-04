<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectsRequest;
use App\Http\Requests\UpdateProjectsRequest;
use App\Models\Projects;
use App\Models\Stakeholders;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProjectsController extends Controller
{
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
            foreach($validatedData['stakeholderName'] as $index => $stakeholderName) {
                Stakeholders::create([
                    'projects_id' => $project->id,
                    'user_id' => $validatedData['user_id'][$index] ?? '1',
                    'role' => $validatedData['stakeholdersRole'][$index],
                ]);
            } 
    
            return redirect()->route('projects.index')->with('success', 'Project and stakeholders created successfully!');
        } else {
            return back()->withErrors($request)->withInput();
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function show(Projects $projects, $id)
    {
        $projects = Projects::with('stakeholders.user', 'user')->where('id', $id)->first();
        // dd($projects);
        return view('projects.developerView', compact('projects'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $projects)
    {
        //
    }

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
