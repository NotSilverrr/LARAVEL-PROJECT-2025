@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-xl font-semibold mb-4">@lang('messages.kanban_view')</h2>

    <div class="overflow-x-auto p-1 pb-4 kanban">
        <div class="flex items-start gap-4 w-max">
            @foreach ($columns as $column)
            
            <div class="relative bg-gray-800 p-[10px] rounded-[1rem] w-[250px] overflow-y-auto flex-shrink-0 group kanban-column" id="kanban-column-{{ $column->id }}">
                <!-- Le bouton delete sera caché par défaut et apparaîtra au hover de la colonne -->
                
            
                <div class="flex justify-between mb-2 items-center">
                    <h2 class="text-xl text-white font-bold">{{$column->name}}</h2>
                    <button class="modal-button text-gray-400 opacity-0 p-2 rounded-full group-hover:opacity-100 transition-opacity duration-300 hover:bg-gray-600/20 "
                        data-modal-name="modal-edit-column-{{ $column->id }}">
                        <x-iconpark-edit-o class="w-6 h-6 [&>path]:stroke-[4]"/>
                    </button>
                </div>

                <ul class="flex flex-col text-white kanban-task-list">
                    @foreach ($column->tasks as $task)
                        <li class="bg-gray-600 p-2 mb-2 rounded-[6px] kanban-task task-kanban-item cursor-pointer" draggable="true" id="kanban-task-{{ $task->id }}" data-task-id="{{ $task->id }}">
                            <h3 class="text-lg font-semibold">{{$task->title}}</h3>
                            <p>{{$task->description}}</p>
                            <p>@lang('messages.status'): {{$task->status}}</p>
                            <p>@lang('messages.priority'): {{$task->priority}}</p>
                        </li>
                        <div id="modal-edit-task-{{ $task->id }}" class="modal hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50">
                            <x-projects.task-edit-popup
                                :project="$project"
                                :task="$task"
                                :categories="$categories"
                                :action="route('projects.tasks.update', [$project, $task])"
                                method="PATCH"
                                button="@lang('messages.update')"
                            />
                        </div>
                    @endforeach
                </ul>
                <button
                    class="modal-button text-white w-full text-start flex items-center gap-2 p-2 rounded-[6px] hover:bg-gray-600/20" 
                    data-modal-name="modal-add-task"
                    data-column_id="{{$column->id}}">
                    <x-iconpark-plus class="w-6 font-bold [&>path]:stroke-[4]" stroke-width="8"/>
                    @lang('messages.add_task')
                </button>
            </div>

            <x-projects.delete-column-modal :column="$column" :project="$project" />
            @endforeach
            <button 
                class="modal-button text-gray-100 bg-gray-200/20 backdrop-blur-sm p-4 rounded-[1rem] text-start w-[250px] flex items-center border border-gray-100/40"
                data-modal-name="modal-add-column">
                
                <x-iconpark-plus class="w-8 font-bold [&>path]:stroke-[4]" stroke-width="8" />
                @lang('messages.add_column')
            </button>
        </div>
    </div>
    

    {{-- Modal for create a task --}}
    <x-projects.task-form-popup :project="$project" :categories="$categories" />
    <x-projects.add-column-modal :project="$project" />


    
    {{-- Modal for delete a column --}}

    {{-- Modal for create a task --}}
    
    

    {{-- Contenu Kanban ici --}}
@endsection
