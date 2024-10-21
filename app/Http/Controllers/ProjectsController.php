<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectsRequest;
use App\Http\Requests\UpdateProjectsRequest;
use App\Models\Projects;

class ProjectsController extends Controller
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
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectsRequest $request)
    {
        $validatedData = $request->validate([
            'projectName' => 'required|string|max:255',
            'stakeholders' => 'required|array',
            'projectDescription' => 'required|string',
        ]);

        $project = Projects::create($validatedData);

        $project = Stakeholders::create($validatedData);
    
        if ($project) {
            return redirect()->route('projects.index')->with('success', 'Project created successfully!');
        } else {            
            return back()->withErrors($request)->withInput();
        }
    }

    

    /**
     * Display the specified resource.
     */
    public function show(Projects $projects)
    {
        //
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
