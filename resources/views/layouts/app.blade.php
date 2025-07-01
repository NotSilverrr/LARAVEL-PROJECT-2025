<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="/assets/images/KanboardFavIcon.png">

        <style>
            /* Styles pour le mode light */
            [data-theme="light"] {
                background-color: #f8fafc;
                color: #374151;
            }

            /* Fond principal */
            [data-theme="light"] .bg-gray-700 {
                background-color: #f1f5f9 !important;
            }

            [data-theme="light"] .bg-gray-800 {
                background-color: #e2e8f0 !important;
            }

            [data-theme="light"] .bg-gray-600 {
                background-color: #cbd5e1 !important;
            }

            /* Textes */
            [data-theme="light"] .text-white {
                color: #000000 !important;
            }

            [data-theme="light"] .text-gray-100 {
                color: #000000 !important;
            }

            [data-theme="light"] .text-gray-700 {
                color: #000000 !important;
            }

            [data-theme="light"] .text-gray-500 {
                color: #000000 !important;
            }

            [data-theme="light"] .text-gray-400 {
                color: #000000 !important;
            }

            /* Bords */
            [data-theme="light"] .border-gray-400 {
                border-color: #cbd5e1 !important;
            }

            [data-theme="light"] .border-gray-600 {
                border-color: #000000 !important;
            }

            /* Opacités */
            [data-theme="light"] .bg-gray-700/40 {
                background-color: rgba(241, 245, 249, 0.4) !important;
            }

            /* Elements spécifiques */
            [data-theme="light"] .bg-gray-200/20 {
                background-color: rgba(203, 213, 225, 0.2) !important;
            }

            /* Navigation */
            [data-theme="light"] .bg-gray-700 {
                background-color: #f1f5f9 !important;
            }

            [data-theme="light"] .text-white {
                color: #000000 !important;
            }

            /* Boutons et interactions */
            [data-theme="light"] .hover:bg-gray-600/20 {
                background-color: rgba(203, 213, 225, 0.2) !important;
            }

            [data-theme="light"] .hover:bg-gray-700/20 {
                background-color: rgba(241, 245, 249, 0.2) !important;
            }

            /* Modal */
            [data-theme="light"] .modal-content {
                background-color: #f1f5f9 !important;
            }

            /* Image de fond */
            [data-theme="dark"] .bg-project-image {
                background-image: url('{{ asset('assets/images/background.jpg') }}');
                background-size: 100% auto;
            }

            [data-theme="light"] .bg-project-image {
                background-image: url('{{ asset('assets/images/background-light.png') }}');
                background-size: 100% auto;
            }

            /* Image de fond du body */
            [data-theme="dark"] body {
                background-color: #f8fafc;
            }

            [data-theme="light"] body {
                background-color: #f8fafc;
            }
        </style>

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
        
                <section class="flex-1 flex flex-col overflow-y-auto bg-gray-800 relative" >    
                    {{ $slot }}
                </section>
            </main>

        </body>
    </div>
</html>
