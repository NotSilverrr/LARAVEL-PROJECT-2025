@extends('projects.layouts.view-layout')

@section('project-view-content')
<div class="flex flex-col items-center justify-center min-h-[300px]">
    <div class="bg-gray-800/80 border border-gray-700 rounded-xl shadow-lg p-8 w-full max-w-md">
        <div class="flex items-center gap-2 mb-4">
            <x-iconpark-upload-o class="w-7 h-7 text-green-400" />
            <h2 class="text-xl font-semibold text-gray-100">Importer des tâches depuis un fichier Excel</h2>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-sm">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('projects.import', $project) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
            @csrf
            <label class="block">
                <span class="text-gray-200 text-sm font-medium">Fichier Excel ou CSV</span>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="mt-1 block w-full bg-gray-900 text-gray-100 border border-gray-600 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" />
            </label>
            <div class="flex items-center gap-3 mt-2">
                <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow transition">
                    <x-iconpark-upload-o class="w-5 h-5" />
                    Importer
                </button>
                <a href="{{ route('projects.show', $project) }}" class="text-gray-300 hover:text-white hover:underline transition">Annuler</a>
            </div>
        </form>
        <div class="mt-4 text-xs text-gray-400">
            Le fichier doit contenir au moins les colonnes <span class="font-semibold text-gray-300">title</span> et <span class="font-semibold text-gray-300">description</span>.
        </div>
    </div>
</div>
@endsection
