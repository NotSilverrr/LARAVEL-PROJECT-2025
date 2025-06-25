@extends('projects.layouts.view-layout')

@section('project-view-content')
<div class="w-full flex justify-between mt-2">
    <h2 class="text-xl font-semibold mb-4">Vue 3 Jours</h2>
    <div class="flex flex-wrap justify-end" style="flex-wrap: wrap;">
        <div class="flex gap-1 bg-gray-800 rounded-full p-1 mb-4">
            <a href="{{ route('projects.view.day', $project) }}"
                class="text-sm p-2 rounded-full text-white 
                        {{ request()->routeIs('projects.view.day') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                1
            </a>
            <a href="{{ route('projects.view.three_days', $project) }}"
                class="text-sm p-2 rounded-full text-white 
                        {{ request()->routeIs('projects.view.three_days') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                3
            </a>
            <a href="{{ route('projects.view.week', $project) }}"
                class="text-sm p-2 rounded-full text-white 
                        {{ request()->routeIs('projects.view.week') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                7
            </a>
            <a href="{{ route('projects.view.calendar', $project) }}"
                class="text-sm p-2 rounded-full text-white 
                        {{ request()->routeIs('projects.view.calendar') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                M
            </a>
        </div>
    </div>
</div>
<div>
    <div class="flex flex-wrap" style="flex-wrap: wrap;">
        <div class="w-full flex justify-end">
            <div class="bg-gray-700 rounded-lg p-4 w-full mx-auto">
                <div class="flex justify-center items-center space-x-12 mb-10">
                    <a href="{{ route('projects.view.three_days', [$project, 'year' => $prevPeriodYear, 'month' => $prevPeriodMonth, 'day' => $prevPeriodDay]) }}" class="text-white hover:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-16 h-16">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                    <h2 class="text-4xl font-extrabold text-white tracking-wide">
                        {{ $dates[0]->format('d/m/Y') }} - {{ $dates[2]->format('d/m/Y') }}
                    </h2>
                    <a href="{{ route('projects.view.three_days', [$project, 'year' => $nextPeriodYear, 'month' => $nextPeriodMonth, 'day' => $nextPeriodDay]) }}" class="text-white hover:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-16 h-16">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
                <div class="flex w-full justify-center gap-8">
                    @foreach ($dates as $date)
                        @php
                            $taskCount = $tasks->filter(fn($task) => $task->date_end && $task->date_end->isSameDay($date))->count();
                        @endphp
                        <div class="bg-gray-800 rounded-2xl min-w-0 h-[600px] p-8 flex flex-col justify-between shadow-2xl" style="width: 30%;">
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-white text-2xl font-extrabold">{{ ucfirst(__($date->format('l'))) }}<br><span class="text-lg font-bold">{{ $date->format('d/m') }}</span></span>
                                <div class="w-10 h-10 flex items-center justify-center">
                                    @if ($taskCount > 0)
                                        <span class="bg-gradient-to-b from-[#E04E75] to-[#902340] text-white rounded-full w-10 h-10 flex items-center justify-center text-lg font-extrabold">{{ $taskCount }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-1 flex-col justify-start items-start space-y-4 border-t-2 border-gray-400 pt-4 mt-4 overflow-y-auto max-h-[420px] w-full scrollbar-none" style="scrollbar-width: none; -ms-overflow-style: none;">
                                @foreach ($tasks as $task)
                                    @if ($task->date_end && $task->date_end->isSameDay($date))
                                        <div class="w-full bg-transparent flex items-center space-x-6 min-w-0 cursor-pointer task-calendar-item py-3 px-2" data-task-id="{{ $task->id }}">
                                            <span class="flex items-center justify-center">
                                                <span class="w-6 h-6 rounded-full border-4 border-green-400 bg-green-300 flex items-center justify-center">
                                                    <span class="w-4 h-4 rounded-full bg-green-400"></span>
                                                </span>
                                            </span>
                                            <h3 class="text-xl text-white font-bold truncate w-full max-w-[200px]">
                                                {{ $task->title }}
                                            </h3>
                                        </div>
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
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
