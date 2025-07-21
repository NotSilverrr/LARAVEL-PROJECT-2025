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
        if($data['column_id'] == null) {
            $data['column_id'] = $project->columns()->first()->id;
        }

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
    public function edit(Project $project, Task $task)
    {
        // Fetch all categories for the select dropdown
        $categories = \App\Models\Category::all();
        $groups = $project->groups;
        return view('projects.tasks.task-edit-popup', compact('project', 'task', 'categories', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date|after_or_equal:date_start',
            // 'column_id' => 'nullable|exists:columns,id',
            'status' => 'required|string|in:todo,in_progress,done',
        ]);

        $data = $request->only([
            'title',
            'description',
            'priority',
            'category_id',
            'date_start',
            'date_end',
            // 'column_id',
            'status'
        ]);

        $task->update($data);
        $task->users()->sync($request->input('user_ids', []));
        $task->groups()->sync($request->input('group_ids', []));
        return redirect()->back()->with('success', 'Tâche mise à jour avec succès.');
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

        // Si la colonne est finale, on passe le statut de la tâche à "completed"
        if ($column->is_final) {
            $task->update(['status' => 'done']);
        }

        return response()->json(['success' => 'Task moved to new column']);
    }
}
