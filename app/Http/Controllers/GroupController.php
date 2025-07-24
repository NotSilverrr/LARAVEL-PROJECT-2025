<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Group;
use App\Models\Project;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $this->authorize('manageGroups', $project);
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
        $this->authorize('manageGroups', $project);
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
    public function store(\App\Http\Requests\StoreGroupRequest $request, Project $project)
    {
        $this->authorize('manageGroups', $project);
        // Les données sont déjà validées

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
        $this->authorize('manageGroups', $project);
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
    public function update(\App\Http\Requests\UpdateGroupRequest $request, Project $project, Group $group)
    {
        $this->authorize('manageGroups', $project);
        // Les données sont déjà validées

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
        $this->authorize('manageGroups', $project);
        $group->users()->detach();
        $group->delete();
        return redirect()->route('projects.groups.index', $project)
            ->with('success', 'Groupe supprimé avec succès.');
    }
}
