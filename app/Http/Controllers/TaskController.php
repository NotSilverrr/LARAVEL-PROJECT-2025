<?php

namespace App\Http\Controllers;

use App\Events\TaskCreated;
use App\Models\Column;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
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
    public function store(\App\Http\Requests\StoreTaskRequest $request, Project $project)
    {
        // Les données sont déjà validées

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

        // Créer la tâche
        $task = $project->tasks()->create($data);

        // Assigner les utilisateurs si fournis
        if ($request->has('assigned_users') && !empty($request->assigned_users)) {
            $task->assignUsers($request->assigned_users);
        }

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
    public function update(\App\Http\Requests\UpdateTaskRequest $request, Project $project, Task $task)
    {
        // Les données sont déjà validées

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
    public function destroy(Project $project, Task $task)
    {
        // Detach relationships if necessary
        $task->users()->detach();
        $task->groups()->detach();
        $task->delete();
        return redirect()->back()->with('success', 'Tâche supprimée avec succès.');
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

    /**
     * Assigner un utilisateur à une tâche existante
     */
    public function assignUser(\App\Http\Requests\AssignUserToTaskRequest $request, Task $task)
    {
        // Les données sont déjà validées

        $user = User::findOrFail($request->user_id);
        
        // Utiliser la méthode assignUser qui déclenche automatiquement l'événement
        $task->assignUser($user);

        return response()->json([
            'message' => 'Utilisateur assigné avec succès',
            'task' => $task->load('users')
        ]);
    }

    /**
     * Retirer un utilisateur d'une tâche
     */
    public function unassignUser(\App\Http\Requests\UnassignUserFromTaskRequest $request, Task $task)
    {
        // Les données sont déjà validées

        $task->users()->detach($request->user_id);

        return response()->json([
            'message' => 'Utilisateur retiré avec succès',
            'task' => $task->load('users')
        ]);
    }

    /**
     * Méthode pour tester l'envoi d'emails (développement uniquement)
     */
    public function testEmailNotification()
    {
        if (!app()->environment('local')) {
            abort(404);
        }

        // Créer une tâche de test
        $project = Project::first();
        $column = Column::first();
        $category = \App\Models\Category::first();
        $testUser = User::where('email', 'test@example.com')->first();

        if (!$project || !$column || !$testUser) {
            return response()->json([
                'error' => 'Données de test manquantes. Assurez-vous d\'avoir des projets, colonnes et utilisateurs en base.'
            ], 400);
        }

        $task = Task::create([
            'title' => 'Tâche de test pour email',
            'description' => 'Ceci est une tâche de test pour vérifier l\'envoi d\'emails.',
            'priority' => 'medium',
            'status' => 'todo',
            'date_start' => now(),
            'date_end' => now()->addDays(7),
            'project_id' => $project->id,
            'column_id' => $column->id,
            'category_id' => $category?->id,
            'created_by' => $testUser->id,
        ]);

        // Assigner l'utilisateur de test
        $task->assignUser($testUser);

        return response()->json([
            'message' => 'Tâche de test créée et email envoyé',
            'task' => $task->load(['users', 'project'])
        ]);
    }
}
