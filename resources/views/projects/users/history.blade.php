@extends('projects.layouts.view-layout')

@section('project-view-content')
    <div class="flex justify-between items-center mb-4 mt-4">
        <h2 class="text-3xl font-semibold">
            @lang('messages.user_history') : {{ $user->firstname }} {{ $user->lastname }}
        </h2>
        <a href="{{ route('projects.users.index', $project) }}"
           class="modal-button flex gap-1 px-3 py-2 rounded-[1rem] text-center bg-gradient-to-b from-[#E04E75] to-[#902340] hover:bg-gradient-to-t">
            ← @lang('messages.back')
        </a>
    </div>

    <table class="min-w-full bg-gray-700 rounded-lg shadow-md overflow-hidden">
        <thead>
            <tr class="text-left bg-gray-800 font-bold">
                <th class="p-4">@lang('messages.date')</th>
                <th class="p-4">@lang('messages.event')</th>
                <th class="p-4">@lang('messages.details')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($activities as $activity)
                <tr class="odd:bg-gray-700/50">
                    <td class="p-4">{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                    <td class="p-4">{{ $activity->description }}</td>
                    <td class="p-4">
                        @foreach($activity->properties ?? [] as $key => $value)
                            <div><span class="font-semibold">{{ $key }}:</span> {{ is_array($value) ? json_encode($value) : $value }}</div>
                        @endforeach
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="p-4 text-center text-gray-400">@lang('messages.no_activity_found')</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $activities->links() }}
    </div>
@endsection
