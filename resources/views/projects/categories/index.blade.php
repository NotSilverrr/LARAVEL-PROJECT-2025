@extends('projects.layouts.view-layout')

@section('project-view-content')
<div x-data="categoryManager()">
    <div class="flex justify-between items-center mb-4 mt-4">
        <h2 class="text-3xl font-semibold">Catégories</h2>
        <button class="flex gap-1 px-3 py-2 rounded-[1rem] text-center
                bg-gradient-to-b from-[#E04E75] to-[#902340] 
                hover:bg-gradient-to-t text-white"
                x-on:click="$dispatch('open-modal', 'add-category-modal')">
            <x-iconpark-plus class="w-6 font-bold [&>path]:stroke-[4]" stroke-width="8"/>
            Ajouter une catégorie
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="min-w-full bg-gray-700 rounded-lg shadow-md overflow-hidden">
        <thead>
            <tr class="text-left bg-gray-800 font-bold">
                <th class="p-4">Nom</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr class="odd:bg-gray-700/50">
                    <td class="p-4 text-white">{{ $category->name }}</td>
                    <td class="p-4 flex gap-2">
                        <button class="px-3 py-1 rounded-[1rem] text-center
                                bg-gradient-to-b from-blue-500 to-blue-700 
                                hover:bg-gradient-to-t text-white transition duration-200" 
                                x-on:click="openEditModal({{ $category->id }}, '{{ $category->name }}')">Modifier</button>
                        <button class="px-3 py-1 rounded-[1rem] text-center
                                bg-gradient-to-b from-red-500 to-red-700 
                                hover:bg-gradient-to-t text-white transition duration-200"
                                x-on:click="openDeleteModal({{ $category->id }}, '{{ $category->name }}')">Supprimer</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal ajout -->
    <x-modal name="add-category-modal" maxWidth="md">
        <div class="bg-gray-800 p-6 rounded-[1rem]">
            <h3 class="text-white text-xl font-bold mb-4">Ajouter une catégorie</h3>
            <form method="POST" action="{{ route('projects.categories.store', $project) }}" class="flex flex-col">
                @csrf
                <div class="mb-4">
                    <label for="add_name" class="block text-gray-100 text-sm font-bold mb-2">Nom de la catégorie</label>
                    <input type="text" name="name" id="add_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Nom de la catégorie" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'add-category-modal')" class="px-4 py-2 rounded-[1rem] bg-gray-600 hover:bg-gray-500 text-white transition duration-200">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded-[1rem] bg-gradient-to-b from-[#E04E75] to-[#902340] hover:bg-gradient-to-t text-white">Ajouter</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal édition -->
    <x-modal name="edit-category-modal" maxWidth="md">
        <div class="bg-gray-800 p-6 rounded-[1rem]">
            <h3 class="text-white text-xl font-bold mb-4">Modifier la catégorie</h3>
            <form method="POST" x-bind:action="`/projects/{{ $project->id }}/categories/${editCategoryId}`" class="flex flex-col">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="edit_name" class="block text-gray-100 text-sm font-bold mb-2">Nom de la catégorie</label>
                    <input type="text" name="name" id="edit_name" x-model="editCategoryName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'edit-category-modal')" class="px-4 py-2 rounded-[1rem] bg-gray-600 hover:bg-gray-500 text-white transition duration-200">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded-[1rem] bg-gradient-to-b from-blue-500 to-blue-700 hover:bg-gradient-to-t text-white">Enregistrer</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal suppression -->
    <x-modal name="delete-category-modal" maxWidth="md">
        <div class="bg-gray-800 p-6 rounded-[1rem]">
            <h3 class="text-white text-xl font-bold mb-4">Supprimer la catégorie</h3>
            <p class="mb-4 text-gray-100" x-text="`Supprimer la catégorie \"${deleteCategoryName}\" ?`"></p>
            <form method="POST" x-bind:action="`/projects/{{ $project->id }}/categories/${deleteCategoryId}`" class="flex flex-col">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'delete-category-modal')" class="px-4 py-2 rounded-[1rem] bg-gray-600 hover:bg-gray-500 text-white transition duration-200">Annuler</button>
                    <button type="submit" class="px-4 py-2 rounded-[1rem] bg-gradient-to-b from-red-500 to-red-700 hover:bg-gradient-to-t text-white">Supprimer</button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        function categoryManager() {
            return {
                editCategoryId: null,
                editCategoryName: '',
                deleteCategoryId: null,
                deleteCategoryName: '',
                
                openEditModal(id, name) {
                    this.editCategoryId = id;
                    this.editCategoryName = name;
                    this.$dispatch('open-modal', 'edit-category-modal');
                },
                
                openDeleteModal(id, name) {
                    this.deleteCategoryId = id;
                    this.deleteCategoryName = name;
                    this.$dispatch('open-modal', 'delete-category-modal');
                }
            }
        }
    </script>
</div>
@endsection