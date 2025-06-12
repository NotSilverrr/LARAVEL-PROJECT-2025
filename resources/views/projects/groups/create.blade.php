@extends('projects.layouts.view-layout')

@section('project-view-content')
    <div class="max-w-xl mx-auto mt-10 bg-gray-800 rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Créer un groupe</h2>
        <form method="POST" action="{{ route('projects.groups.store', $project) }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-200 font-semibold mb-2">Nom du groupe</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            </div>
            <div class="mb-6">
                <label for="users" class="block text-gray-200 font-semibold mb-2">Ajouter des membres</label>
                <select name="users[]" id="users" multiple class="w-full px-4 py-2 rounded bg-gray-900 border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-pink-500" size="6">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs utilisateurs.</p>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('projects.groups.index', $project) }}" class="px-4 py-2 rounded bg-gray-600 text-white hover:bg-gray-700">Annuler</a>
                <button type="submit" class="px-4 py-2 rounded bg-gradient-to-b from-[#E04E75] to-[#902340] text-white font-semibold hover:from-[#902340] hover:to-[#E04E75]">Créer le groupe</button>
            </div>
        </form>
    </div>
@endsection