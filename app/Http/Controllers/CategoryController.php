<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $categories = $project->categories()->get();
        // dd($categories);
        return view('projects.categories.index', compact('project', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        // verify if the user has permission to create a category in this project
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $project->categories()->create([
            'name' => $request->name,
            'created_by' => $request->user()->id,
        ]);
        return redirect()->route('projects.categories.index', $project)->with('success', 'Catégorie ajoutée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project, Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $category->update(['name' => $request->name]);
        return redirect()->route('projects.categories.index', $project)->with('success', 'Catégorie modifiée !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, Category $category)
    {
        $category->delete();
        return redirect()->route('projects.categories.index', $project)->with('success', 'Catégorie supprimée !');
    }
}
