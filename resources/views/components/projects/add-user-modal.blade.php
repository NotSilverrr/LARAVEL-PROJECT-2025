<div id="modal-add-user" class="modal hidden fixed inset-0 z-50 items-center justify-center bg-gray-900 bg-opacity-50">
    <div class="modal-content bg-gray-800 p-6 rounded-[1rem] w-11/12 sm:w-2/4 lg:w-1/3">
        <button class="modal-close text-white text-3xl/4 item-self-end">&times;</button>
        <h2 class="text-white text-xl font-bold mb-4">Ajouter un utilisateur</h2>
        <form action="{{ route('projects.users.invite', $project) }}" method="POST" class="flex flex-col ">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-100 text-sm font-bold mb-2">Adresse email de l'utilisateur</label>
                <input type="text" id="email" name="email" autocomplete="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-100 text-sm font-bold mb-2">Role</label>
                <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="admin">Admin</option>
                    <option value="member" selected>Utilisateur</option>
                </select>
            </div>
            <button type="submit" class="block px-4 py-2 rounded-[1rem] 
            bg-gradient-to-b from-[#E04E75] to-[#902340] 
            hover:bg-gradient-to-t text-white">Créer</button>
        </form>
    </div>
</div>