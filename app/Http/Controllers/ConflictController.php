<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConflictRequest;
use App\Http\Requests\UpdateConflictRequest;
use App\Models\Conflict;

class ConflictController extends Controller
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
    public function store(StoreConflictRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Conflict $conflict)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conflict $conflict)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConflictRequest $request, Conflict $conflict)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Conflict $conflict)
    {
        //
    }
}
