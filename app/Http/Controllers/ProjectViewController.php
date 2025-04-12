<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectViewController extends Controller
{
    public function list(Project $project)
    {
        return view('projects.views.list', compact('project'));
    }

    public function kanban(Project $project)
    {
        // Tu peux charger ici les colonnes et tâches si besoin
        $columns = $project->columns()->with('tasks')->get();
        $categories = $project->categories()->get();

        // dd($columns, $categories); // Pour déboguer et voir les données

        return view('projects.views.kanban', compact('project', 'columns', 'categories'));
    }

    public function calendar(Project $project)
    {
        $events = $project->tasks()->get(); // ou autre logique
        return view('projects.views.calendar', compact('project', 'events'));
    }
}
