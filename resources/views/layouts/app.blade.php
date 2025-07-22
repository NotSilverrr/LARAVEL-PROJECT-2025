<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="/assets/images/KanboardFavIcon.png">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- Toastify JS -->
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            // Fonction pour sauvegarder le mode dans localStorage
            function setTheme(theme) {
                localStorage.setItem('theme', theme);
                document.documentElement.setAttribute('data-theme', theme);
            }

            // Fonction pour charger le mode sauvegardé
            function loadTheme() {
                const savedTheme = localStorage.getItem('theme') || 'dark';
                document.documentElement.setAttribute('data-theme', savedTheme);
                updateThemeIcon(savedTheme);
            }

            // Fonction pour mettre à jour l'icône
            function updateThemeIcon(theme) {
                const lightIcon = document.getElementById('light-icon');
                const darkIcon = document.getElementById('dark-icon');
                
                if (theme === 'dark') {
                    lightIcon.classList.add('hidden');
                    darkIcon.classList.remove('hidden');
                } else {
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                }
            }

            // Écouter le changement de mode système
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                if (!localStorage.getItem('theme')) {
                    setTheme(e.matches ? 'dark' : 'light');
                }
            });

            // Initialiser le mode
            document.addEventListener('DOMContentLoaded', () => {
                loadTheme();
                
                // Ajouter l'écouteur d'événement au bouton
                const themeToggle = document.getElementById('theme-toggle');
                themeToggle.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    setTheme(newTheme);
                    updateThemeIcon(newTheme);
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased text-white bg-gray-700">
        <div class="h-screen flex flex-col overflow-hidden">
            @include('layouts.navigation')

                <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow text-white">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <main class="flex-1 flex overflow-hidden">

                <x-sidebar />
        
                <section class="flex-1 flex flex-col overflow-y-auto relative bg-project-image" >   
                    <div class="absolute inset-0 bg-black bg-opacity-40 z-0"></div>
                    {{ $slot }}
                </section>
            </main>

        </body>
    </div>
</html>
