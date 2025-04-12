@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-xl font-semibold mb-4">Vue Kanban</h2>

    <div class="overflow-x-auto pb-4">
        <div class="flex items-start gap-4 w-max">
            @foreach ($columns as $column)
            <div class="bg-gray-800 p-4 rounded-[1rem] w-[250px] flex-shrink-0 ">
                <h2 class="text-xl text-white font-bold">{{$column->name}}</h2>
                <ul class="flex flex-col text-white">
                    @foreach ($column->tasks as $task)
                        <li class="bg-gray-600 p-2 mb-2 rounded-[6px]">
                            <h3 class="text-lg font-semibold">{{$task->name}}</h3>
                            <p>{{$task->description}}</p>
                            <p>Statut: {{$task->status}}</p>
                            <p>Priorité: {{$task->priority}}</p>
                        </li>
                    @endforeach
                </ul>
                {{-- Link to the form for create a task --}}
    
                {{-- <a href="{{route("projects.tasks.create", $project)}}">Ajouter une Tache</a> --}}
                <button
                    class="modal-button text-white py-1 w-full text-start" 
                    data-modal-name="modal-add-task"
                    data-column-id="{{$column->id}}">
                    Ajouter une tache
                </button>
            </div>
            @endforeach
            <button 
            class="modal-button text-gray-800 bg-gray-200/50 p-4 rounded-[1rem] text-start w-[250px] flex items-center" >
            <x-iconpark-plus class="w-8 font-bold [&>path]:stroke-[4]" stroke-width="8"/>
                Ajouter une colonne
            </button>
        </div>
    </div>
    

    {{-- Modal for create a task --}}
    <div id="modal-add-task" class="modal hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="modal-content bg-gray-800 p-6 rounded w-11/12 sm:w-2/4 lg:w-1/3">
            <button class="modal-close text-white text-3xl item-self-end">&times;</button>
            <h2 class="text-white text-xl font-bold mb-4">Créer une tache</h2>
            <form action="{{ route('projects.tasks.store', $project)}}" method="POST" class="flex flex-col ">
                @csrf
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
                </div>
                <div class="mb-4">
                    <label for="category_id" class="block text-gray-100 text-sm font-bold mb-2">Catégorie de la tache</label>
                    <select name="category_id" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled selected>Choisir une categorie</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                {{-- Input de start date --}}
                <div class="mb-4">
                    <label for="date_start" class="block text-gray-100 text-sm font-bold mb-2">Date de début</label>
                    <input type="date" id="date_start" name="date_start" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                {{-- Input de end date --}}
                <div class="mb-4">
                    <label for="date_end" class="block text-gray-100 text-sm font-bold mb-2">Date de fin</label>
                    <input type="date" id="date_end" name="date_end" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <input type="hidden" name="column_id" id="column_id" value="">

                <button type="submit" class="block px-4 py-2 rounded-[1rem] 
                bg-gradient-to-b from-[#E04E75] to-[#902340] 
                hover:bg-gradient-to-t text-white">Créer</button>
            </form>
        </div>
    </div>
    

    {{-- Contenu Kanban ici --}}
@endsection
