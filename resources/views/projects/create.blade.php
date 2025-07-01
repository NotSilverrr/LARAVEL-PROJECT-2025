<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-900 bg-opacity-80 py-10">
        <div class="bg-gray-800 p-8 rounded-[1rem] w-11/12 sm:w-2/4 lg:w-1/3 shadow-lg">
            <h2 class="text-white text-xl font-bold mb-6 text-center">{{ __('messages.create_project') }}</h2>
            <form action="{{ route('projects.store') }}" method="POST" class="flex flex-col">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-100 text-sm font-bold mb-2">{{ __('messages.project_name') }}</label>
                    <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-100 text-sm font-bold mb-2">{{ __('messages.project_description') }}</label>
                    <input type="text" id="description" name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <button type="submit" class="block px-4 py-2 rounded-[1rem] bg-gradient-to-b from-[#E04E75] to-[#902340] hover:bg-gradient-to-t text-white font-bold mt-2">{{ __('messages.create') }}</button>
            </form>
        </div>
    </div>
</x-app-layout>