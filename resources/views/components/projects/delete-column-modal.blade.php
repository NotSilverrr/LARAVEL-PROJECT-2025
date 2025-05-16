<div id="modal-delete-column-{{ $column->id }}" class="modal hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="modal-content bg-gray-800 p-6 rounded-[1rem] w-11/12 sm:w-2/4 lg:w-1/3">
        <button class="modal-close text-white text-3xl/4 item-self-end">&times;</button>
        <h2 class="text-white text-xl font-bold mb-4">Etes vous sur de vouloir supprimer la colonne {{$column->name}}?</h2>
        <form action="{{ route('projects.columns.destroy', [$project, $column]) }}" method="POST" class="flex flex-col ">
            @csrf
            @method('DELETE')
            <button type="submit" class="block px-4 py-2 rounded-[1rem] 
            bg-gradient-to-b from-[#E04E75] to-[#902340] 
            hover:bg-gradient-to-t text-white">Supprimer</button>
        </form>
    </div>
</div>