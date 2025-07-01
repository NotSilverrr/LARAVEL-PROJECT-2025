@extends('projects.layouts.view-layout')

@section('project-view-content')
<div class="w-full flex justify-between mt-2">
    <h2 class="text-xl font-semibold mb-4">{{ __('messages.week_view') }}</h2>
    <div class="flex flex-wrap justify-end" style="flex-wrap: wrap;">
        <div class="flex gap-1 bg-gray-800 rounded-full p-1 mb-4">
            <a href="{{ route('projects.view.day', $project) }}"
                class="flex items-center justify-center text-sm p-2 rounded-full text-white h-8 w-8 
                        {{ request()->routeIs('projects.view.day') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                1
            </a>
            <a href="{{ route('projects.view.three_days', $project) }}"
                class="flex items-center justify-center text-sm p-2 rounded-full text-white h-8 w-8 
                        {{ request()->routeIs('projects.view.three_days') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                3
            </a>
            <a href="{{ route('projects.view.week', $project) }}"
                class="flex items-center justify-center text-sm p-2 rounded-full text-white h-8 w-8 
                        {{ request()->routeIs('projects.view.week') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                7
            </a>
            <a href="{{ route('projects.view.calendar', $project) }}"
                class="flex items-center justify-center text-sm p-2 rounded-full text-white h-8 w-8 
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
                <div class="flex justify-center items-center space-x-6 mb-6">
                    <a href="{{ route('projects.view.week', [$project, 'week' => $prevWeek, 'year' => $prevWeekYear]) }}" class="text-white hover:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a>

                    <h2 class="text-3xl font-bold text-white">Semaine {{ $selected_week }} {{ $selected_year }}</h2>

                    <a href="{{ route('projects.view.week', [$project, 'week' => $nextWeek, 'year' => $nextWeekYear]) }}" class="text-white hover:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>

                @php
                    $dto = new DateTime();
                    $dto->setISODate($selected_year, $selected_week, 1); // Monday
                    $days = [];
                    for ($i = 0; $i < 7; $i++) {
                        $days[] = (clone $dto)->modify("+{$i} day");
                    }
                @endphp

                <div class="flex w-full">
                    @foreach ($days as $day)
                        <div class="bg-gray-800 rounded-lg w-40 h-64 p-2 m-2 flex flex-col justify-between">
                            <div class="flex justify-between">
                                <span class="text-white text-sm font-bold">{{ ucfirst($day->format('l')) }}<br>{{ $day->format('d/m') }}</span>
                                @php
                                    $taskCount = $tasks->filter(fn($task) => $task->date_end && $task->date_end->format('Y-m-d') === $day->format('Y-m-d'))->count();
                                @endphp
                                <div class="w-4 h-4 flex items-center justify-center">
                                    @if ($taskCount > 0)
                                        <span class="bg-gradient-to-b from-[#E04E75] to-[#902340] text-white rounded-full w-4 h-4 flex items-center justify-center text-xs font-bold">{{ $taskCount }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-1 flex-col justify-start items-start space-y-1 border-t border-gray-400 mt-1 overflow-y-auto max-h-40 w-full scrollbar-none" style="scrollbar-width: none; -ms-overflow-style: none;">
                                @foreach ($tasks as $task)
                                    @if ($task->date_end && $task->date_end->format('Y-m-d') === $day->format('Y-m-d'))
                                        <div class="w-full bg-transparent flex items-center space-x-2 min-w-0 cursor-pointer task-calendar-item" data-task-id="{{ $task->id }}">
                                            <span class="flex items-center justify-center">
                                                <span class="w-2 h-2 rounded-full border-2 border-green-400 bg-green-300 flex items-center justify-center">
                                                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                                                </span>
                                            </span>
                                            <h3 class="text-sm text-white font-semibold truncate w-full max-w-[72px]">
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
                                                button="{{ __('messages.save') }}"
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
