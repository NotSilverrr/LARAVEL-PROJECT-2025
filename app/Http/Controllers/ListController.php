<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function list(Project $project)
    {
        $this->authorize('view', $project);
        $query = \App\Models\Task::visibleForUser(auth()->user(), $project->id)->with('column', 'category', 'creator', 'groups', 'users');
        
        // Recherche par titre
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        // Filtrer par colonne
        if (request('column_id')) {
            $query->where('column_id', request('column_id'));
        }

        // Filtrer par statut en utilisant finished_at et column_id
        if (request('status')) {
            $status = request('status');
            if ($status == 'en cours') {
                $query->whereNull('finished_at');
            } elseif ($status == 'terminé') {
                $query->whereNotNull('finished_at');
            }
        }

        // Filtrer par priorité
        if (request('priority')) {
            $query->where('priority', request('priority'));
        }

        $tasks = $query->get();
        
        $categories = $project->categories()->get();
        $columns = $project->columns()->get();

        return view('projects.views.list', compact('project', 'tasks', 'categories', 'columns'));
    }
}