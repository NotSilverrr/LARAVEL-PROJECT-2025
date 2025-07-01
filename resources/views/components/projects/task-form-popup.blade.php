<div id="modal-add-task" class="modal hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="modal-content bg-gray-800 p-6 rounded-[1rem] w-11/12 sm:w-2/4 lg:w-1/3">
        <button class="modal-close text-white text-3xl item-self-end">&times;</button>
        <h2 class="text-white text-xl font-bold mb-4">Créer une tache</h2>
        <form action="{{ route('projects.tasks.store', $project) }}" method="POST" class="flex flex-col ">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-100 text-sm font-bold mb-2">Titre de la tache</label>
                <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-100 text-sm font-bold mb-2">Déscription de la tache</label>
                <input type="text" id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="priority" class="block text-gray-100 text-sm font-bold mb-2">Priorité de la tache</label>
                <select name="priority" id="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="" disabled selected>Choisir une priorité</option>
                    <option value="low">Basse</option>
                    <option value="medium">Moyenne</option>
                    <option value="high">Haute</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.category')orie de la tache</label>
                <select name="category_id" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" disabled selected>Choisir une categorie</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            {{-- Input de start date --}}
            <div class="mb-4">
                <label for="date_start" class="block text-gray-100 text-sm font-bold mb-2">Date de début</label>
                <input type="date" id="date_start" name="date_start" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            {{-- Input de end date --}}
            <div class="mb-4">
                <label for="date_end" class="block text-gray-100 text-sm font-bold mb-2">Date de fin</label>
                <input type="date" id="date_end" name="date_end" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <input type="hidden" name="column_id" id="column_id" value="">

            <button type="submit" class="block px-4 py-2 rounded-[1rem] 
            bg-gradient-to-b from-[#E04E75] to-[#902340] 
            hover:bg-gradient-to-t text-white">Créer</button>
        </form>
    </div>
</div>