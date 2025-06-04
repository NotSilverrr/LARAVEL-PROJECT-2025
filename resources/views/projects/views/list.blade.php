@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-xl font-semibold mb-4">Vue Liste des tâches</h2>

    {{-- Filtres --}}
    <form method="GET" class="mb-6 bg-gray-800 p-4 rounded-lg flex flex-wrap gap-4 items-end text-white">
        <div>
            <label for="column_id" class="block mb-1">Colonne</label>
            <select name="column_id" id="column_id" class="text-black rounded p-1">
                <option value="">Toutes</option>

            </select>
        </div>

        <div>
            <label for="status" class="block mb-1">Statut</label>
            <select name="status" id="status" class="text-black rounded p-1">
                <option value="">Tous</option>
                <option value="à faire" @selected(request('status') == 'à faire')>À faire</option>
                <option value="en cours" @selected(request('status') == 'en cours')>En cours</option>
                <option value="terminé" @selected(request('status') == 'terminé')>Terminé</option>
            </select>
        </div>

        <div>
            <label for="priority" class="block mb-1">Priorité</label>
            <select name="priority" id="priority" class="text-black rounded p-1">
                <option value="">Toutes</option>
                <option value="basse" @selected(request('priority') == 'basse')>Basse</option>
                <option value="moyenne" @selected(request('priority') == 'moyenne')>Moyenne</option>
                <option value="haute" @selected(request('priority') == 'haute')>Haute</option>
            </select>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">
                Filtrer
            </button>
            
        </div>
    </form>

    {{-- Tableau --}}
    <div class="bg-gray-700 rounded-lg p-4 max-w-6xl mx-auto">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600 text-white">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium">Nom</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Description</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Statut</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Priorité</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Groupe de tâche</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-gray-800/40 transition">
                            <td class="px-4 py-3">
                                <a href="{{ route('projects.show', $task->id) }}" class="hover:underline text-blue-300">
                                    {{ $task->title }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $task->description }}</td>
                            <td class="px-4 py-3">{{ $task->statut }}</td>
                            <td class="px-4 py-3">{{ $task->priority }}</td>
                            <td class="px-4 py-3">{{ $task->column->name }}</td>
                            <td class="px-4 py-3 space-x-2">
                                <a href="{{ route('projects.edit', $task->id) }}" class="text-blue-300 hover:text-blue-400">Modifier</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6">Aucune tâche trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
