@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-xl font-semibold mb-4">{{ __('messages.task_list') }}</h2>

    <div class="flex flex-col gap-4 mb-6">
        <div class="flex gap-4 bg-gray-800 rounded-lg items-center">
            <div class="flex-1">
                {{-- Filtres --}}
                <form method="GET" class="p-4 rounded-lg flex flex-wrap gap-4 items-end text-white">
                    <div class="flex-1">
                        <label for="search" class="block mb-1">@lang('messages.search')</label>
                        <input type="text" name="search" id="search" 
                               value="{{ request('search') }}"
                               class="text-black rounded p-1 w-full" 
                               placeholder="@lang('messages.search_task_placeholder')">
                    </div>

                    <div>
                        <label for="column_id" class="block mb-1">{{ __('messages.column') }}</label>
                        <select name="column_id" id="column_id" class="text-black rounded p-1 w-40">
                            <option value="">@lang('messages.all')</option>
                            @foreach ($project->columns as $column)
                                <option value="{{ $column->id }}" @selected(request('column_id') == $column->id)>{{ $column->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block mb-1">{{ __('messages.status') }}</label>
                        <select name="status" id="status" class="text-black rounded p-1 w-40">
                            <option value="">@lang('messages.all')</option>
                            <option value="en cours" @selected(request('status') == 'en cours')>@lang('messages.in_progress')</option>
                            <option value="terminé" @selected(request('status') == 'terminé')>@lang('messages.completed')</option>
                        </select>
                    </div>

                    <div>
                        <label for="priority" class="block mb-1">{{ __('messages.priority') }}</label>
                        <select name="priority" id="priority" class="text-black rounded p-1 w-40">
                            <option value="" @selected(request('priority') == '')>Toutes</option>
                            <option value="low" @selected(request('priority') == 'low')>@lang('messages.low')</option>
                            <option value="medium" @selected(request('priority') == 'medium')>@lang('messages.medium')</option>
                            <option value="high" @selected(request('priority') == 'high')>@lang('messages.high')</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">
                            @lang('messages.filter')
                        </button>
                    </div>
                </form>
            </div>
            <div class="flex-shrink-0 w-64">
                <button
                    class="modal-button text-white w-full text-start flex items-center gap-2 p-2 rounded-lg hover:bg-gray-600/20" 
                    data-modal-name="modal-add-task">
                    <x-iconpark-plus class="w-6 font-bold [&>path]:stroke-[4]" stroke-width="8"/>
                    {{ __('messages.add_task') }}
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
                        <th class="px-4 py-2 text-left text-sm font-medium">@lang('messages.task')</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">@lang('messages.description')</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">@lang('messages.priority')</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">@lang('messages.task_group')</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">@lang('messages.created_by')</th>
                        <th class="px-4 py-2 text-left text-sm font-medium">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-gray-800/40 transition task-list-row cursor-pointer {{ $task->isLate() ? 'bg-red-800/20' : '' }}" data-task-id="{{ $task->id }}">
                            <td class="px-4 py-3">
                                <a href="{{ route('projects.show', $task->id) }}" class="hover:underline {{ $task->isLate() ? 'text-red-400' : 'text-blue-300' }}">
                                    {{ $task->title }}
                                    @if($task->isLate())
                                        <span class="text-xs text-red-400">(@lang('messages.late'))</span>
                                    @endif
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $task->description }}</td>
                            <td class="px-4 py-3">{{ $task->priority }}</td>
                            <td class="px-4 py-3">{{ $task->column->name }}</td>
                            <td class="px-4 py-3">{{ $task->creator->firstname ?? '' }} {{ $task->creator->lastname ?? '' }}</td>
                            <td class="px-4 py-3 space-x-2">
                                <button class="text-blue-300 hover:text-blue-400 task-edit-button" data-task-id="{{ $task->id }}">{{ __('messages.edit') }}</button>
                                    <div id="modal-edit-task-{{ $task->id }}" class="modal hidden fixed top-0 left-0 right-0 bottom-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
                                        <x-projects.task-edit-popup
                                            :project="$project"
                                            :task="$task"
                                            :categories="$categories"
                                            :action="route('projects.tasks.update', [$project, $task])"
                                            method="PATCH"
                                            button="{{ __('messages.save') }}"
                                        />
                                    </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6">{{ __('messages.no_tasks') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
        {{-- Modal for create a task --}}
        <x-projects.task-form-popup :project="$project" :categories="$categories" />
@endsection

{{-- Modal show/hide script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Show modal on task edit button click
    document.querySelectorAll('.task-edit-button').forEach(function (el) {
        el.addEventListener('click', function () {
            const taskId = this.dataset.taskId;
            const modal = document.getElementById('modal-edit-task-' + taskId);
            modal.classList.remove('hidden');
        });
    });

    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });
});
</script>
