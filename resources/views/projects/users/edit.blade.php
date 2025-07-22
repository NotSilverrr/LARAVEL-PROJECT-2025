@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-2xl font-semibold mb-4">@lang('messages.edit_member')</h2>
    <form action="{{ route('projects.users.update', [$project, $user]) }}" method="POST" class="max-w-md mx-auto bg-gray-800 p-6 rounded-lg shadow">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="role" class="block text-gray-300 mb-2">@lang('messages.role')</label>
            <select name="role" id="role" class="w-full p-2 rounded bg-gray-700 text-white">
                <option value="member" {{ isset($pivot) && $pivot->role === 'member' ? 'selected' : '' }}>@lang('messages.member')</option>
                <option value="admin" {{ isset($pivot) && $pivot->role === 'admin' ? 'selected' : '' }}>@lang('messages.admin')</option>
                <option value="owner" {{ isset($pivot) && $pivot->role === 'owner' ? 'selected' : '' }}>@lang('messages.owner')</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">@lang('messages.save')</button>
        <a href="{{ route('projects.users.index', $project) }}" class="ml-4 text-gray-400 hover:text-gray-200">@lang('messages.cancel')</a>
    </form>
@endsection
