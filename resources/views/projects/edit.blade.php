@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-xl font-semibold mb-4">Edit project</h2>
    
    <div class="bg-gray-800 p-6 rounded-lg max-w-2xl mx-auto">
        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-white">Project Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-white bg-gray-700" 
                       required>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-white">Description</label>
                <textarea name="description" id="description" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-white bg-gray-700"
                          required>{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Project
                </button>
            </div>
        </form>
    </div>
@endsection