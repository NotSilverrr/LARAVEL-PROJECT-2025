<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
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
    public function view(User $user, Task $task): bool
    {
        // Si l'utilisateur est admin du projet, il peut voir toutes les tâches du projet
        $project = $task->project;
        if ($project && $project->users()->where('user_id', $user->id)->wherePivot('role', 'admin')->exists()) {
            return true;
        }
        // Vérifie si l'utilisateur est directement affecté à la tâche
        if ($task->users()->where('user_id', $user->id)->exists()) {
            return true;
        }
        // Vérifie si l'utilisateur appartient à un groupe affecté à la tâche
        $userGroupIds = $user->groups ? $user->groups->pluck('id')->toArray() : [];
        if (!empty($userGroupIds)) {
            return $task->groups()->whereIn('group_id', $userGroupIds)->exists();
        }
        return false;
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
    public function update(User $user, Task $task): bool
    {
        // Seuls les utilisateurs affectés à la tâche (directement ou via un groupe) peuvent la modifier
        if ($task->users()->where('user_id', $user->id)->exists()) {
            return true;
        }
        $userGroupIds = $user->groups ? $user->groups->pluck('id')->toArray() : [];
        if (!empty($userGroupIds)) {
            return $task->groups()->whereIn('group_id', $userGroupIds)->exists();
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        // Seuls les utilisateurs affectés à la tâche (directement ou via un groupe) peuvent la supprimer
        if ($task->users()->where('user_id', $user->id)->exists()) {
            return true;
        }
        $userGroupIds = $user->groups ? $user->groups->pluck('id')->toArray() : [];
        if (!empty($userGroupIds)) {
            return $task->groups()->whereIn('group_id', $userGroupIds)->exists();
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        // Seuls les utilisateurs affectés à la tâche (directement ou via un groupe) peuvent la restaurer
        if ($task->users()->where('user_id', $user->id)->exists()) {
            return true;
        }
        $userGroupIds = $user->groups ? $user->groups->pluck('id')->toArray() : [];
        if (!empty($userGroupIds)) {
            return $task->groups()->whereIn('group_id', $userGroupIds)->exists();
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        // Seuls les utilisateurs affectés à la tâche (directement ou via un groupe) peuvent la supprimer définitivement
        if ($task->users()->where('user_id', $user->id)->exists()) {
            return true;
        }
        $userGroupIds = $user->groups ? $user->groups->pluck('id')->toArray() : [];
        if (!empty($userGroupIds)) {
            return $task->groups()->whereIn('group_id', $userGroupIds)->exists();
        }
        return false;
    }
}
