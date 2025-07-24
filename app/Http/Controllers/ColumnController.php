<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $columns = Column::all();
        return view('columns.index', ['columns' => $columns]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('columns.create', ['projects' => $projects, 'users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project, \App\Http\Requests\StoreColumnRequest $request)
    {
        // Les données sont déjà validées
        $data = $request->only(['name']);
        $data['created_by'] = Auth::id();

        $project->columns()->create($data);
        return redirect()->back()->with('success', 'Colonne créée avec succès.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\UpdateColumnRequest $request, Project $project, Column $column)
    {
        // Les données sont déjà validées
        $column->update([
            'name' => $request->name,
            'is_final' => $request->has('is_final'),
        ]);
        return redirect()->back()->with('success', 'Colonne modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Column $column)
    {
        if ($project->columns()->count() <= 1) {
            return redirect()->back()->with('error', 'Impossible de supprimer la dernière colonne du projet. Veuillez créer une nouvelle colonne avant de supprimer celle-ci.');
        }
        $column->delete();
        return redirect()->back()->with('success', 'La colonne a été supprimée avec succès.');
    }
}
