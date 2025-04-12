@extends('projects.layouts.view-layout')

@section('project-view-content')
<form action="{{ route('projects.tasks.store', $project)}}" method="POST">
    @csrf
    <h1>Créer une tache</h1>
    <div class="mb-4">
        <label for="title" class="block text-gray-100 text-sm font-bold mb-2">Titre de la tache</label>
        <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>
    <div class="mb-4">
        <label for="description" class="block text-gray-100 text-sm font-bold mb-2">Déscription de la tache</label>
        <input type="text" id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>
    <div class="mb-4">
        <label for="priority" class="block text-gray-100 text-sm font-bold mb-2">Priorité de la tache</label>
        <select name="priority" id="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <option value="" disabled selected>Choisir une priorité</option>
            <option value="low">Basse</option>
            <option value="medium">Moyenne</option>
            <option value="high">Haute</option>
        </select>
    {{-- <div class="mb-4">
        <label for="name" class="block text-gray-100 text-sm font-bold mb-2">Colonnes de base</label>
        <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div> --}}

    <button type="submit">Créer</button>
</form>

@endsection