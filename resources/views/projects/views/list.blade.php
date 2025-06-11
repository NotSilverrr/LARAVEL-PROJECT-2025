@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-xl font-semibold mb-4">Vue Liste des tâches</h2>

    <div class="flex flex-col gap-4 mb-6">
        <div class="flex gap-4 bg-gray-800 items-center">
            <div class="flex-1">
                {{-- Filtres --}}
                <form method="GET" class="p-4 rounded-lg flex flex-wrap gap-4 items-end text-white">
                    <div>
                        <label for="column_id" class="block mb-1">Colonne</label>
                        <select name="column_id" id="column_id" class="text-black rounded p-1 w-40">
                            <option value="">Toutes</option>

                        </select>
                    </div>

                    <div>
                        <label for="status" class="block mb-1">Statut</label>
                        <select name="status" id="status" class="text-black rounded p-1 w-40">
                            <option value="">Tous</option>
                            <option value="à faire" @selected(request('status') == 'à faire')>À faire</option>
                            <option value="en cours" @selected(request('status') == 'en cours')>En cours</option>
                            <option value="terminé" @selected(request('status') == 'terminé')>Terminé</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block mb-1">Priorité</label>
                        <select name="priority" id="priority" class="text-black rounded p-1 w-40">
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
            </div>
            <div class="flex-shrink-0 w-64">
                <button
                    class="modal-button text-white w-full text-start flex items-center gap-2 p-2 rounded-[6px] hover:bg-gray-600/20" 
                    data-modal-name="modal-add-task">
                    <x-iconpark-plus class="w-6 font-bold [&>path]:stroke-[4]" stroke-width="8"/>
                    Ajouter une tache
                </button>
            </div>
        </div>
    </div>
@php
 //dd($tasks);   
@endphp
    {{-- Tableau --}}
    <div class="bg-gray-700 rounded-lg p-4 max-w-6xl mx-auto">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-600 text-white">
                <thead class="bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium">Tâche</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Description</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Priorité</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Groupe de tâche</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Crée par</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-gray-800/40 transition task-list-row cursor-pointer" data-task-id="{{ $task->id }}">
                            <td class="px-4 py-3">
                                <a href="{{ route('projects.show', $task->id) }}" class="hover:underline text-blue-300">
                                    {{ $task->title }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $task->description }}</td>
                            <td class="px-4 py-3">{{ $task->priority }}</td>
                            <td class="px-4 py-3">{{ $task->column->name }}</td>
                            <td class="px-4 py-3">{{ $task->creator->firstname ?? '' }} {{ $task->creator->lastname ?? '' }}</td>
                            <td class="px-4 py-3 space-x-2">
                                <div id="modal-edit-task-{{ $task->id }}" class="modal hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50">
                                    <x-projects.task-edit-popup
                                        :project="$project"
                                        :task="$task"
                                        :categories="$categories"
                                        :action="route('projects.tasks.update', [$project, $task])"
                                        method="PATCH"
                                        button="Mettre à jour"
                                    />
                                </div>
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
        {{-- Modal for create a task --}}
        <x-projects.task-form-popup :project="$project" :categories="$categories" />
@endsection
