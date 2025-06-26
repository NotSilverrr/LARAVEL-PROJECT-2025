@extends('projects.layouts.view-layout')

@section('project-view-content')
<div x-data="categoryManager()">
    <h2 class="text-xl font-semibold mb-4">Catégories</h2>

    <button class="mb-4 px-4 py-2 bg-green-600 text-white rounded" x-on:click="$dispatch('open-modal', 'add-category-modal')">Ajouter une catégorie</button>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="min-w-full bg-white rounded shadow">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nom</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $category->name }}</td>
                    <td class="py-2 px-4 border-b flex gap-2">
                        <button class="bg-blue-500 text-white px-2 py-1 rounded" 
                                x-on:click="openEditModal({{ $category->id }}, '{{ $category->name }}')">Modifier</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded"
                                x-on:click="openDeleteModal({{ $category->id }}, '{{ $category->name }}')">Supprimer</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal ajout -->
    <x-modal name="add-category-modal" maxWidth="md">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Ajouter une catégorie</h3>
            <form method="POST" action="{{ route('projects.categories.store', $project) }}">
                @csrf
                <input type="text" name="name" class="w-full border rounded p-2 mb-4" placeholder="Nom de la catégorie" required>
                <div class="flex justify-end gap-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'add-category-modal')" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Ajouter</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal édition -->
    <x-modal name="edit-category-modal" maxWidth="md">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Modifier la catégorie</h3>
            <form method="POST" x-bind:action="`/projects/{{ $project->id }}/categories/${editCategoryId}`">
                @csrf
                @method('PATCH')
                <input type="text" name="name" x-model="editCategoryName" class="w-full border rounded p-2 mb-4" required>
                <div class="flex justify-end gap-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'edit-category-modal')" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Enregistrer</button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal suppression -->
    <x-modal name="delete-category-modal" maxWidth="md">
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-4">Supprimer la catégorie</h3>
            <p class="mb-4" x-text="`Supprimer la catégorie \"${deleteCategoryName}\" ?`"></p>
            <form method="POST" x-bind:action="`/projects/{{ $project->id }}/categories/${deleteCategoryId}`">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'delete-category-modal')" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Supprimer</button>
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