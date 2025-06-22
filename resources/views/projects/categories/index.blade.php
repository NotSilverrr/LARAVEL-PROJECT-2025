@extends('projects.layouts.view-layout')

@section('project-view-content')
    <h2 class="text-xl font-semibold mb-4">Catégories</h2>

    <button class="mb-4 px-4 py-2 bg-green-600 text-white rounded" id="openAddCategoryModal">Ajouter une catégorie</button>

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
                        <button class="bg-blue-500 text-white px-2 py-1 rounded edit-category-btn" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Modifier</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded delete-category-btn" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Supprimer</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal ajout -->
    <div id="addCategoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded shadow w-96">
            <h3 class="text-lg font-semibold mb-4">Ajouter une catégorie</h3>
            <form id="addCategoryForm" method="POST" action="{{ route('projects.categories.store', $project) }}">
                @csrf
                <input type="text" name="name" class="w-full border rounded p-2 mb-4" placeholder="Nom de la catégorie" required>
                <div class="flex justify-end gap-2">
                    <button type="button" id="closeAddModal" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal édition -->
    <div id="editCategoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded shadow w-96">
            <h3 class="text-lg font-semibold mb-4">Modifier la catégorie</h3>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="text" name="name" id="editCategoryName" class="w-full border rounded p-2 mb-4" required>
                <div class="flex justify-end gap-2">
                    <button type="button" id="closeEditModal" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal suppression -->
    <div id="deleteCategoryModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded shadow w-96">
            <h3 class="text-lg font-semibold mb-4">Supprimer la catégorie</h3>
            <p id="deleteCategoryText" class="mb-4"></p>
            <form id="deleteCategoryForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-2">
                    <button type="button" id="closeDeleteModal" class="px-3 py-1 bg-gray-300 rounded">Annuler</button>
                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Supprimer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Ajout modal
        const addModal = document.getElementById('addCategoryModal');
        document.getElementById('openAddCategoryModal').onclick = () => addModal.classList.remove('hidden');
        document.getElementById('closeAddModal').onclick = () => addModal.classList.add('hidden');

        const editModal = document.getElementById('editCategoryModal');
        const deleteModal = document.getElementById('deleteCategoryModal');
        const editForm = document.getElementById('editCategoryForm');
        const deleteForm = document.getElementById('deleteCategoryForm');
        const editNameInput = document.getElementById('editCategoryName');
        let currentEditId = null;
        let currentDeleteId = null;

        document.querySelectorAll('.edit-category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentEditId = this.dataset.id;
                editNameInput.value = this.dataset.name;
                editForm.action = `/projects/{{ $project->id }}/categories/${currentEditId}`;
                editModal.classList.remove('hidden');
            });
        });
        document.getElementById('closeEditModal').onclick = () => editModal.classList.add('hidden');

        document.querySelectorAll('.delete-category-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                currentDeleteId = this.dataset.id;
                document.getElementById('deleteCategoryText').textContent = `Supprimer la catégorie "${this.dataset.name}" ?`;
                deleteForm.action = `/projects/{{ $project->id }}/categories/${currentDeleteId}`;
                deleteModal.classList.remove('hidden');
            });
        });
        document.getElementById('closeDeleteModal').onclick = () => deleteModal.classList.add('hidden');
    </script>
@endsection