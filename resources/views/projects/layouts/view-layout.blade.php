{{-- resources/views/components/layouts/project-view.blade.php --}}
<x-app-layout>
    @if ($errors->any())
    <script>
        @foreach ($errors->all() as $error)
            Toastify({
                text: "{{ $error }}",
                duration: 5000,
                gravity: "top", 
                position: "right",
                backgroundColor: "#f56565", // rouge
            }).showToast();
        @endforeach
    </script>
    @endif
    <div class="flex flex-col h-full flex-1 p-6 bg-project-image">
        <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>

        <div class="relative z-10">
            <div class="flex justify-between items-center">
                <div class="flex gap-4 items-center">
                    <h1 class="text-3xl mr-4 font-bold">{{$project->name}}</h1>
                    <a href="{{route("projects.edit", $project)}}" class="p-2 rounded-full hover:bg-gray-200/20 transition duration-200" title="Edit">
                        <x-iconpark-edit-o class="w-6 h-6 text-gray-100" />
                    </a>
                    <a href="{{route("projects.users.index", $project)}}" class="p-2 rounded-full hover:bg-gray-200/20 transition duration-200" title="Groups">
                        <x-iconpark-peoples-o class="w-6 h-6 text-gray-100" />
                    </a>
                    <a href="" class="p-2 rounded-full hover:bg-gray-200/20 transition duration-200" title="Delete">
                        <x-iconpark-delete-o class="w-6 h-6 text-gray-100 " />
                    </a>
                    <a href="{{route("projects.categories.index", $project)}}" class="p-2 rounded-full hover:bg-gray-200/20 transition duration-200" title="Category">
                        <x-iconpark-gridfour class="w-6 h-6 text-gray-100 " />
                    </a>

                </div>
                <div class="flex gap-1 bg-gray-800 rounded-full p-1">
                    <a href="{{ route('projects.view.list', $project) }}"
                    class="text-sm p-2 rounded-full text-white
                            {{ request()->routeIs('projects.view.list') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                        <x-iconpark-listtwo class="w-4 h-4" />
                    </a>
                    <a href="{{ route('projects.view.kanban', $project) }}"
                        class="text-sm p-2 rounded-full text-white
                                {{ request()->routeIs('projects.view.kanban') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                        <x-iconpark-aligntoptwo class="w-4 h-4" />
                    </a>
                    <a href="{{ route('projects.view.calendar', $project) }}"
                        class="text-sm p-2 rounded-full text-white 
                                {{ request()->routeIs('projects.view.calendar') ? 'bg-gradient-to-b from-[#E04E75] to-[#902340] ' : 'hover:bg-gray-600' }}">
                        <x-iconpark-calendar class="w-4 h-4" />
                    </a>
                </div>
            </div>
            <div class="flex-1">
                @yield('project-view-content')
            </div>
        </div>
    </div>
</x-app-layout>