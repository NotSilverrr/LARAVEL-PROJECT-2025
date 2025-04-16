<aside class="w-64 bg-gray-800 text-white p-4 overflow-y-auto flex flex-col">
    <div class="text-xl font-semibold mb-6">Dashboard</div>

    <div class="flex-1 flex flex-col justify-between">
        <nav class="flex flex-col space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 w-full rounded-[1rem] hover:bg-gray-700">
                Accueil
            </a>
            <h2 class="font-semibold">Mes projets</h2>
            <ul class="space-y-2">
                @foreach (Auth::user()->projects as $project)
                    <li>
                        <a href="{{ route('projects.view.list', $project->id) }}" class="block px-4 py-2 w-full rounded-[1rem] hover:bg-gray-700
                            {{ request()->is('projects/' . $project->id . '*') ? 'bg-gray-600' : '' }}">
                            {{ $project->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="mt-6">
            <a href="{{ route('projects.create') }}" 
            class="block px-4 py-2 rounded-[1rem] text-center
                    bg-gradient-to-b from-[#E04E75] to-[#902340] 
                    hover:bg-gradient-to-t">
                Créer un projet
            </a>
        </div>
    </div>
    
</aside>
