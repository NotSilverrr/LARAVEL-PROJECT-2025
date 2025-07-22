<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kanboard</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 min-h-screen">
        <main class="flex min-h-screen flex-col items-center justify-center p-8">
            <div class="w-full max-w-4xl">
                <!-- Navigation -->
                <nav class="flex justify-end gap-4 mb-8">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition-colors">Se connecter</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition-colors">S'inscrire</a>
                            @endif
                        @endauth
                    @endif
                </nav>

                <!-- Contenu principal -->
                <div class="relative rounded-2xl overflow-hidden">
                    <!-- Image de fond -->
                    <img src="{{ asset('assets/images/background.jpg') }}" alt="Background Kanboard" class="w-full h-[300px] object-cover">
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-40 rounded-2xl"></div>
                    
                    <!-- Contenu -->
                    <div class="relative p-8 text-white">
                        <h1 class="text-4xl font-bold mb-4">{{ __('messages.welcome_title') }}</h1>
                        <p class="text-xl mb-8">{{ __('messages.welcome_subtitle') }}</p>

                        <!-- Section Auteurs -->
                        <div class="mt-12 text-center">
                            <h2 class="text-2xl font-semibold mb-4">{{ __('messages.created_by') }}</h2>
                            <div class="flex justify-center gap-8">
                                <div class="flex flex-col items-center">
                                    <img src="{{ asset('assets/images/mathis.png') }}" alt="Mathis LATIMIER" class="w-16 h-16 rounded-full mb-2">
                                    <span class="text-gray-200 text-lg font-bold">Mathis LATIMIER</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <img src="{{ asset('assets/images/thomas.png') }}" alt="Thomas RONSIN" class="w-16 h-16 rounded-full mb-2">
                                    <span class="text-gray-200 text-lg font-bold">Thomas RONSIN</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <img src="{{ asset('assets/images/julien.png') }}" alt="Julien LE MOING" class="w-16 h-16 rounded-full mb-2">
                                    <span class="text-gray-200 text-lg font-bold">Julien LE MOING</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>