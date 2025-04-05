<x-app-layout>
    <form action="">
        @csrf
        <h1>Créer un projet</h1>
        <div class="mb-4">
            <label for="name" class="block text-gray-100 text-sm font-bold mb-2">Nom du projet</label>
            <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
    </form>
</x-app-layout>