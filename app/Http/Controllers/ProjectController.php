<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
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
    public function store(\App\Http\Requests\StoreProjectRequest $request)
    {
        // Les données sont déjà validées

        $data = $request->all();
        $data['created_by'] = Auth::id();

        $project = Project::create($data);

        $project->users()->attach(Auth::id());

        // create default columns with the cerated_by user
        $project->columns()->create([
            'name' => 'To Do',
            'created_by' => Auth::id(),
        ]);
        $project->columns()->create([
            'name' => 'In Progress',
            'created_by' => Auth::id(),
        ]);
        $project->columns()->create([
            'name' => 'Done',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('projects.view.kanban', $project->id)->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateProjectRequest $request, Project $project)
    {
        // Les données sont déjà validées

        $project->update($request->all());

        return redirect()->route('projects.view.kanban', $project->id)->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Check if the user has permission to delete the project
        if (Auth::user()->cannot('delete', $project)) {
            return redirect()->route('projects.view.kanban', $project->id)
                ->with('error', 'You do not have permission to delete this project.');
        }

        // Delete the project and its related data
        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully.');
    }
}
