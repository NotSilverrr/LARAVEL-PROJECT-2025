@extends('projects.layouts.view-layout')

@section('project-view-content')
<form action="{{ route('projects.tasks.store', $project)}}" method="POST">
    @csrf
    <h1>{{ __('messages.create_task') }}</h1>
    <div class="mb-4">
        <label for="title" class="block text-gray-100 text-sm font-bold mb-2">{{ __('messages.task_title') }}</label>
        <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>
    <div class="mb-4">
        <label for="description" class="block text-gray-100 text-sm font-bold mb-2">{{ __('messages.task_description') }}</label>
        <input type="text" id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div>
    <div class="mb-4">
        <label for="priority" class="block text-gray-100 text-sm font-bold mb-2">{{ __('messages.task_priority') }}</label>
        <select name="priority" id="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <option value="" disabled selected>{{ __('messages.choose_priority') }}</option>
            <option value="low">{{ __('messages.low_priority') }}</option>
            <option value="medium">{{ __('messages.medium_priority') }}</option>
            <option value="high">{{ __('messages.high_priority') }}</option>
            <option value="low">Basse</option>
            <option value="medium">Moyenne</option>
            <option value="high">Haute</option>
        </select>
    {{-- <div class="mb-4">
        <label for="name" class="block text-gray-100 text-sm font-bold mb-2">{{ __('messages.base_columns') }}</label>
        <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
    </div> --}}

    <button type="submit">{{ __('messages.create') }}</button>
</form>

@endsection