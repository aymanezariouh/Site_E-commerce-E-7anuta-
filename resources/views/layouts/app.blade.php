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
        <div class="min-h-screen bg-gray-100" x-data="{ profileOpen: false, cartOpen: false }">
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
                    class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl flex flex-col"
                    x-transition:enter="transition transform duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition transform duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                >
                    <div class="border-b border-gray-200 px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Profil utilisateur</h3>
                                <p class="text-xs text-gray-500">Compte, commandes et activites.</p>
                            </div>
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
                        <div class="mt-4 flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                            <div class="h-12 w-12 rounded-full bg-slate-200"></div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4">
                        <x-buyer.profile-quick />
                    </div>
                </div>
            </div>

            <div x-show="cartOpen" class="fixed inset-0 z-50" style="display: none;">
                <div class="absolute inset-0 bg-black/40" @click="cartOpen = false"></div>
                <div
                    class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl flex flex-col"
                    x-transition:enter="transition transform duration-300"
                    x-transition:enter-start="translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition transform duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full"
                >
                    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Votre panier</h3>
                            <p class="text-xs text-gray-500">Articles sauvegardes pour l'achat.</p>
                        </div>
                        <button
                            class="rounded-full p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700"
                            @click="cartOpen = false"
                            aria-label="Fermer"
                            type="button"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4">
                        <x-buyer.cart />
                        <div class="mt-4 dash-card p-4">
                            <h5 class="dash-title text-base text-slate-800">Articles dans le panier</h5>
                            <div class="mt-3 space-y-3">
                                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white p-3 text-sm">
                                    <div>
                                        <p class="font-semibold text-slate-800">Casque Bluetooth</p>
                                        <p class="text-xs text-slate-500">Qte 1</p>
                                    </div>
                                    <span class="font-semibold text-slate-800">$49.00</span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white p-3 text-sm">
                                    <div>
                                        <p class="font-semibold text-slate-800">T-shirt coton</p>
                                        <p class="text-xs text-slate-500">Qte 2</p>
                                    </div>
                                    <span class="font-semibold text-slate-800">$37.00</span>
                                </div>
                            </div>
                            <div class="mt-4 flex items-center justify-between text-sm">
                                <span class="text-slate-500">Total</span>
                                <span class="text-base font-semibold text-slate-800">$86.00</span>
                            </div>
                            <button class="mt-3 w-full rounded-lg bg-teal-600 px-3 py-2 text-sm text-white hover:bg-teal-700">Passer commande</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
