<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100" x-data="{ profileOpen: false }">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <div x-show="profileOpen" class="fixed inset-0 z-50" style="display: none;">
                <div class="absolute inset-0 bg-black/40" @click="profileOpen = false"></div>
                <div
                    class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl"
                    x-transition:enter="transition transform duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition transform duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                >
                    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3">
                        <h3 class="text-base font-semibold text-gray-800">Profil utilisateur</h3>
                        <button
                            class="rounded-full p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            @click="profileOpen = false"
                            aria-label="Fermer"
                            type="button"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <x-buyer.profile-quick />
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
