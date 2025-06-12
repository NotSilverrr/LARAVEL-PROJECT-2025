@extends('projects.layouts.view-layout')

@section('project-view-content')
    <div class="flex justify-between items-center mb-4 mt-4">
        <h2 class="text-3xl font-semibold">Groupes</h2>
        <a href="{{ route('projects.groups.create', $project) }}"
           class="modal-button flex gap-1 px-3 py-2 rounded-[1rem] text-center
                  bg-gradient-to-b from-[#E04E75] to-[#902340] 
                  hover:bg-gradient-to-t">
            <x-iconpark-plus class="w-6 font-bold [&>path]:stroke-[4]" stroke-width="8"/>
            Ajouter un groupe
        </a>
    </div>

    <table class="min-w-full bg-gray-700 rounded-lg shadow-md overflow-hidden">
        <thead>
            <tr class="text-left bg-gray-800 font-bold">
                <th class="p-4">Nom du groupe</th>
                <th class="p-4">Créé par</th>
                <th class="p-4">Date de création</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groups as $group)
                <tr class="odd:bg-gray-700/50 hover:bg-gray-600/50 cursor-pointer group-row"
                    onclick="window.location='{{ route('projects.groups.edit', [$project, $group]) }}'">
                    <td class="p-4">{{ $group->name }}</td>
                    <td class="p-4">
                        @if($group->creator)
                            {{ $group->creator->firstname }} {{ $group->creator->lastname }}
                            <span class="text-xs text-gray-400">({{ $group->creator->email }})</span>
                        @else
                            <span class="text-gray-400 italic">Inconnu</span>
                        @endif
                    </td>
                    <td class="p-4">{{ $group->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-4 flex gap-2" onclick="event.stopPropagation();">
                        <form action="{{ route('projects.groups.destroy', [$project, $group]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $groups->links() }}
    </div>

@endsection