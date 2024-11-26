<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAIResponseRequest;
use App\Http\Requests\UpdateAIResponseRequest;
use App\Models\AIResponse;
use App\Services\GPTService;
use App\Models\Projects;

class AIResponseController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAIResponseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AIResponse $aIResponse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AIResponse $aIResponse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAIResponseRequest $request, AIResponse $aIResponse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AIResponse $aIResponse)
    {
        //
    }
}
