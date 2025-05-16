<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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
    public function create(Project $project)
    {
        return view('projects.tasks.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date|after_or_equal:date_start',
            'column_id' => 'nullable|exists:columns,id',
        ]);

        $data = $request->only([
            'title',
            'description',
            'priority',
            'category_id',
            'date_start',
            'date_end',
            'column_id'
        ]);
        $data['created_by'] = Auth::id();

        // dd($data); // For debugging

        // Assuming you have a relationship set up in your Project model
        $task = $project->tasks()->create($data);

        return redirect()->back()->with('success', 'Tâche créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    public function moveColumn(Task $task, Column $column)
    {
        // Validate the column ID
        if (!$column) {
            return response()->json(['error' => 'Invalid column ID'], 400);
        }

        // Update the task's column
        $task->update(['column_id' => $column->id]);

        return response()->json(['success' => 'Task moved to new column']);
    }
}
