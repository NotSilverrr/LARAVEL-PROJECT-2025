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
    public function store(Project $project,Request $request)
    {
        // Validate the name et add the column to the project
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
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
    public function update(Request $request, Column $column)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Column $column)
    {
        // Find the column and delete it
        $column->delete();

        return redirect()->back()->with('success', 'Colonne supprimée avec succès.');
    }
}
