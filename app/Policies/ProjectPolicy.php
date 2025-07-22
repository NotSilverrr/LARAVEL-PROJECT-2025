<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
        // L'utilisateur doit être membre du projet pour pouvoir le voir
        // On suppose une relation many-to-many Project <-> User : $project->users()
        return $project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        // Seuls les membres du projet peuvent le modifier
        return $project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        // Seuls les membres du projet peuvent le supprimer
        return $project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        // Seuls les membres du projet peuvent le restaurer
        return $project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        // Seuls les membres du projet peuvent le supprimer définitivement
        return $project->users()->where('user_id', $user->id)->exists();
    }

    public function manageMembers(User $user, Project $project): bool
    {
        if ($user->id === $project->created_by) {
            return true;
        }
        $pivot = $project->users()->where('user_id', $user->id)->first()?->pivot;
        return $pivot && in_array($pivot->role, ['owner', 'admin']);
    }

    public function manageGroups(User $user, Project $project): bool
    {
        if ($user->id === $project->created_by) {
            return true;
        }
        $pivot = $project->users()->where('user_id', $user->id)->first()?->pivot;
        return $pivot && in_array($pivot->role, ['owner', 'admin']);
    }
}
