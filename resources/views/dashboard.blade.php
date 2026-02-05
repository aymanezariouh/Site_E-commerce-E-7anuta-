<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    @auth
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 font-semibold">Dashboard</a>
                    <a href="{{ route('marketplace') }}" class="text-gray-700 hover:text-gray-900">Marketplace</a>
                    <a href="{{ route('orders') }}" class="text-gray-700 hover:text-gray-900">Orders</a>
                    <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-gray-900">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                <section class="dash-card px-6 py-6 sm:px-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Tableau de bord</p>
                            <h3 class="dash-title text-2xl text-slate-800">Bienvenue, {{ Auth::user()->name }}</h3>
                            <p class="mt-1 text-sm text-slate-600">
                                Votre espace regroupe les achats, les ventes et les activites recentes.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @role('buyer')
                                <span class="dash-pill">Client actif</span>
                            @endrole
                            @role('seller')
                                <span class="dash-pill">Vendeur</span>
                            @endrole
                            @role('moderator')
                                <span class="dash-pill">Moderateur</span>
                            @endrole
                        </div>
                    </div>
                    <div class="mt-5 dash-divider"></div>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Commandes recentes</p>
                            <p class="text-lg font-semibold text-slate-800">12</p>
                        </div>
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Articles en panier</p>
                            <p class="text-lg font-semibold text-slate-800">3</p>
                        </div>
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Avis recueillis</p>
                            <p class="text-lg font-semibold text-slate-800">24</p>
                        </div>
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Nouveaux messages</p>
                            <p class="text-lg font-semibold text-slate-800">2</p>
                        </div>
                    </div>
                </section>

                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="space-y-8 lg:col-span-2">
                        <div id="stock-alerts" class="sr-only"></div>
                        <div id="order-details" class="sr-only"></div>
                        <div id="reviews" class="sr-only"></div>
                        <div id="analytics" class="sr-only"></div>
                        @role('buyer')
                            <section id="marketplace" class="space-y-6">
                                <x-buyer.marketplace />
                                <div id="orders"></div>
                                <x-buyer.liked-products />
                                <x-buyer.reviews />
                                <x-buyer.notifications />
                            </section>
                        @endrole

                        @role('seller')
                            <section class="space-y-6">
                                <x-seller.marketplace-quick />
                                <x-seller.liked-products-quick />
                            </section>
                        @endrole

                        @role('seller')
                            <section class="space-y-6">
                                <x-seller.products-module />
                            </section>
                        @endrole
                    </div>

                    <aside class="space-y-6">
                        <div class="dash-card p-4">
                            <h4 class="dash-title text-base text-slate-800">Actions rapides</h4>
                            <p class="mt-1 text-sm text-slate-500">Accedez vite aux pages cle.</p>
                            <div class="mt-3 flex flex-wrap gap-2 text-sm">
                                <a class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50" href="{{ route('profile.edit') }}">Profil</a>
                                <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50">Commandes</button>
                                <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50">Support</button>
                            </div>
                        </div>

                        <div class="dash-card p-4">
                            <h4 class="dash-title text-base text-slate-800">A propos de votre compte</h4>
                            <div class="mt-3 space-y-3 text-sm text-slate-600">
                                <div class="flex items-center justify-between">
                                    <span>Derniere connexion</span>
                                    <span class="font-medium text-slate-700">Aujourd'hui</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Statut du compte</span>
                                    <span class="font-medium text-emerald-700">Actif</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Notifications</span>
                                    <span class="font-medium text-slate-700">Activees</span>
                                </div>
                            </div>
                        </div>

                        <div class="dash-card p-4">
                            <h4 class="dash-title text-base text-slate-800">Conseils</h4>
                            <ul class="mt-3 space-y-2 text-sm text-slate-600">
                                <li>Ajoutez 3 nouveaux produits cette semaine.</li>
                                <li>Repondez aux avis pour gagner en confiance.</li>
                                <li>Verifiez votre stock avant le weekend.</li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Access Denied</h1>
            <p class="text-gray-600 mb-4">You must be logged in to access the dashboard.</p>
            <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</a>
        </div>
    </div>
    @endauth
</body>
</html>
