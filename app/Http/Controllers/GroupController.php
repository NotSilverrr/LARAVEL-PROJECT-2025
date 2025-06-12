<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $groups = $project->groups()
            ->with('creator')
            ->paginate(10);

        return view('projects.groups.index', [
            'project' => $project,
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        // Get all users in the project
        $users = $project->users;
        return view('projects.groups.create', [
            'project' => $project,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $group = $project->groups()->create([
            'name' => $request->input('name'),
            'created_by' => auth()->id(),
        ]);

        $users = $request->input('users', []);
        $group->users()->sync($users);

        return redirect()->route('projects.groups.index', $project)
            ->with('success', 'Groupe créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Group $group)
    {
        $users = $project->users;
        $groupUserIds = $group->users()->pluck('users.id')->toArray();
        return view('projects.groups.edit', [
            'project' => $project,
            'group' => $group,
            'users' => $users,
            'groupUserIds' => $groupUserIds,
        ]);
    }

    /**
     * Update the specified group in storage.
     */
    public function update(Request $request, Project $project, Group $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $group->update([
            'name' => $validated['name'],
        ]);

        $group->users()->sync($validated['users'] ?? []);

        return redirect()->route('projects.groups.index', $project)
            ->with('success', 'Groupe mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Group $group)
    {
        $group->users()->detach();
        $group->delete();
        return redirect()->route('projects.groups.index', $project)
            ->with('success', 'Groupe supprimé avec succès.');
    }
}
