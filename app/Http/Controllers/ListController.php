<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function list(Project $project)
    {
        $query = $project->tasks();

        // Recherche fulltext uniquement sur le title avec Scout, filtre par projet conservé
        if (request('search')) {
            $searchTerm = request('search');
            $searchResults = \App\Models\Task::search($searchTerm)
                ->where('project_id', $project->id)
                ->get();

            $ids = is_array($searchResults)
                ? array_column($searchResults, 'id')
                : $searchResults->pluck('id')->toArray();

            $query->whereIn('id', $ids);
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

        // Charger les relations après tous les filtres
        $tasks = $query->with('column', 'category', 'creator', 'groups', 'users')->get();

        $categories = $project->categories()->get();
        $columns = $project->columns()->get();

        return view('projects.views.list', compact('project', 'tasks', 'categories', 'columns'));
    }
}