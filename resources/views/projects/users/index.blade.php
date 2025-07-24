@extends('projects.layouts.view-layout')

@section('project-view-content')
    <div class="flex justify-between items-center mb-4 mt-4">
        <h2 class="text-3xl font-semibold">@lang('messages.members')</h2>
        <button href="{{ route('projects.create') }}" 
            class="modal-button flex gap-1 px-3 py-2 rounded-[1rem] text-center
                    bg-gradient-to-b from-[#E04E75] to-[#902340] 
                    hover:bg-gradient-to-t"
                    data-modal-name="modal-add-user">
                    <x-iconpark-plus class="w-6 font-bold [&>path]:stroke-[4]" stroke-width="8"/>
                @lang('messages.add_user')
        </button>
    </div>

    <table class="min-w-full bg-gray-700 rounded-lg shadow-md overflow-hidden">
        <thead>
            <tr class="text-left bg-gray-800  font-bold">
                <th class="p-4">@lang('messages.lastname')</th>
                <th class="p-4">@lang('messages.firstname')</th>
                <th class="p-4">@lang('messages.email')</th>
                <th class="p-4">@lang('messages.role')</th>
                <th class="p-4">@lang('messages.actions')</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="odd:bg-gray-700/50" onclick="window.location='{{ route('projects.users.edit', [$project, $user]) }}'">
                    <td class="p-4">{{ $user->firstname }}</td>
                    <td class="p-4">{{ $user->lastname }}</td>
                    <td class="p-4">{{ $user->email }}</td>
                    <td class="p-4">{{ $user->pivot->role }}</td>
                    <td>
                        <a href="{{ route('projects.users.history', [$project, $user]) }}" class="text-green-500 mr-2">@lang('messages.history')</a>
                        |
                        <form action="{{ route('projects.users.destroy', [$project, $user]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">@lang('messages.delete')</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <x-projects.add-user-modal :project="$project" />
@endsection