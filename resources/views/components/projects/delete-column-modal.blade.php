<div id="modal-edit-column-{{ $column->id }}" class="modal hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="modal-content bg-gray-800 p-6 rounded-[1rem] w-11/12 sm:w-2/4 lg:w-1/3">
        <button class="modal-close text-white text-3xl/4 item-self-end">&times;</button>
        <h2 class="text-white text-xl font-bold mb-4">Modifier la colonne "{{$column->name}}"</h2>
        <form action="{{ route('projects.columns.update', [$project, $column]) }}" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('PATCH')
            <label for="column-name-{{ $column->id }}" class="block text-gray-100 text-sm font-bold mb-2">Nom de la colonne</label>
            <input type="text" id="column-name-{{ $column->id }}" name="name" value="{{ old('name', $column->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="is-final-{{ $column->id }}" name="is_final" value="1" {{ old('is_final', $column->is_final) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-pink-600">
                <label for="is-final-{{ $column->id }}" class="text-gray-100">Définir cette colonne comme colonne finale (toute tâche déplacée ici sera marquée comme terminée)</label>
            </div>
            <div class="flex justify-between mt-6 gap-2">
                <button type="submit" class="px-4 py-2 rounded-[1rem] bg-gradient-to-b from-blue-500 to-blue-700 hover:bg-gradient-to-t text-white font-semibold">Enregistrer</button>
            </div>
        </form>
        <form action="{{ route('projects.columns.destroy', [$project, $column]) }}" method="POST" class="mt-2" onsubmit="return confirm('Voulez-vous vraiment supprimer cette colonne ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 rounded-[1rem] bg-gradient-to-b from-[#E04E75] to-[#902340] hover:bg-gradient-to-t text-white font-semibold w-full">Supprimer</button>
        </form>
    </div>
</div>