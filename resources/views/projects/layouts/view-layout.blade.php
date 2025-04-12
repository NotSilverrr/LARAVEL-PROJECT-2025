{{-- resources/views/components/layouts/project-view.blade.php --}}
<x-app-layout>
    <div class="flex flex-col h-full flex-1">
        <div class="flex justify-between items-center">
            <h1>{{$project->name}}</h1>
            <div class="flex space-x-4">
                <a href="{{ route('projects.view.list', $project) }}"
                    class="text-sm px-3 py-2 rounded 
                            {{ request()->routeIs('projects.view.list') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Liste
                </a>
                <a href="{{ route('projects.view.kanban', $project) }}"
                    class="text-sm px-3 py-2 rounded 
                            {{ request()->routeIs('projects.view.kanban') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Kanban
                </a>
                <a href="{{ route('projects.view.calendar', $project) }}"
                    class="text-sm px-3 py-2 rounded 
                            {{ request()->routeIs('projects.view.calendar') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Calendrier
                </a>
            </div>
        </div>
        <div class="flex-1">
            @yield('project-view-content')
        </div>

    </div>
    
</x-app-layout>