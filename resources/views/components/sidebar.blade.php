<aside class="w-64 bg-gray-800 text-white p-4 overflow-y-auto flex flex-col">
    <div class="text-xl font-semibold mb-6">Dashboard</div>

    <div class="flex-1 flex flex-col justify-between">
        <nav class="flex space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 w-full rounded-[1rem] hover:bg-gray-700">
                Accueil
            </a>
            <div class="">
    
            </div>
            <ul>
                @foreach (Auth::user()->projects as $project)
                    <li>
                        <a href="{{ route('projects.show', $project) }}" class="block px-4 py-2 w-full rounded-[1rem] hover:bg-gray-700">
                            {{ $project->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="mt-6">
            <a href="{{ route('projects.create') }}" 
            class="block px-4 py-2 rounded-[1rem] 
                    bg-gradient-to-b from-[#E04E75] to-[#902340] 
                    hover:bg-gradient-to-t">
                Créer un projet
            </a>
        </div>
    </div>
    
</aside>
