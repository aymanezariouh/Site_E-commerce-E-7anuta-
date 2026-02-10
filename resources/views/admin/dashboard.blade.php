<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-7anuta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-shop-gray-50 font-sans antialiased text-shop-gray-900">
    {{-- Sidebar --}}
    <x-admin.sidebar />
    
    {{-- Navbar --}}
    <x-admin.navbar title="Tableau de Bord" :notificationCount="5" />
    
    {{-- Main Content --}}
    <main class="lg:ml-64 min-h-screen transition-all duration-300">
        <div class="p-6 lg:p-8 max-w-7xl mx-auto">
            <!-- Welcome Section -->
            <div class="mb-8 animate-fade-in-up">
                <h1 class="text-3xl font-bold text-shop-gray-900 mb-2 font-display tracking-tight">
                    Bonjour, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-shop-gray-500 text-lg">
                    Voici un aperçu de votre plateforme e-commerce aujourd'hui.
                </p>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up" style="animation-delay: 100ms;">
                <x-admin.stat-card
                    title="Utilisateurs"
                    :value="$stats['users']"
                    type="users"
                    color="brand"
                    :change="$stats['users_change']"
                />
                
                <x-admin.stat-card
                    title="Commandes"
                    :value="$stats['orders']"
                    type="orders"
                    color="blue"
                    :change="$stats['orders_change']"
                />

                <x-admin.stat-card
                    title="Revenus"
                    :value="number_format($stats['revenue'], 2) . ' €'"
                    type="revenue"
                    color="green"
                    :change="$stats['revenue_change']"
                />

                <x-admin.stat-card
                    title="Produits"
                    :value="$stats['products']"
                    type="products"
                    color="purple"
                    :change="$stats['products_change']"
                />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 animate-fade-in-up" style="animation-delay: 200ms;">
                {{-- Recent Activity --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-shop-gray-900 font-display">Activité Récente</h2>
                        <a href="#" class="text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors">Voir tout</a>
                    </div>
                    
                    <div class="space-y-4 flex-grow overflow-y-auto custom-scrollbar max-h-[400px] pr-2">
                        @forelse($recentActivity as $activity)
                            <div class="flex items-start p-4 rounded-xl hover:bg-shop-gray-50 transition-colors duration-200 border border-transparent hover:border-shop-gray-100 group">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-sm
                                        {{ $activity->type === 'order' ? 'bg-blue-50 text-blue-600' : 
                                          ($activity->type === 'user' ? 'bg-green-50 text-green-600' : 
                                          ($activity->type === 'product' ? 'bg-purple-50 text-purple-600' : 'bg-shop-gray-100 text-shop-gray-600')) }}">
                                        @if($activity->type === 'order')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        @elseif($activity->type === 'user')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                        @elseif($activity->type === 'product')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="text-sm font-medium text-shop-gray-900 group-hover:text-brand-700 transition-colors">{{ $activity->description }}</p>
                                    <div class="flex items-center mt-1">
                                        <svg class="w-3 h-3 text-shop-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-xs text-shop-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 text-shop-gray-500 bg-shop-gray-50/50 rounded-xl">
                                <svg class="w-12 h-12 mx-auto text-shop-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-lg font-medium text-shop-gray-900">Aucune activité récente</p>
                                <p class="text-sm">Les actions de vos utilisateurs apparaîtront ici.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-8 flex flex-col h-full">
                    {{-- Quick Actions --}}
                    <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 flex-1">
                        <h2 class="text-xl font-bold text-shop-gray-900 font-display mb-6">Actions Rapides</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                            <x-admin.action-button 
                                href="{{ route('admin.products') }}" 
                                color="brand-ghost" 
                                class="w-full justify-start h-auto py-4 px-5 bg-brand-50/30 hover:bg-brand-50 border border-brand-100 hover:border-brand-200 shadow-sm"
                            >
                                <div class="flex items-center w-full">
                                    <span class="bg-brand-100 text-brand-600 p-2 rounded-xl mr-4 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </span>
                                    <div class="text-left">
                                        <span class="block font-bold text-brand-900 text-sm">Nouveau Produit</span>
                                        <span class="block text-brand-600/70 text-xs">Ajouter au catalogue</span>
                                    </div>
                                </div>
                            </x-admin.action-button>

                            <x-admin.action-button 
                                href="{{ route('admin.users') }}" 
                                color="blue-ghost" 
                                class="w-full justify-start h-auto py-4 px-5 bg-blue-50/30 hover:bg-blue-50 border border-blue-100 hover:border-blue-200 shadow-sm"
                            >
                                <div class="flex items-center w-full">
                                    <span class="bg-blue-100 text-blue-600 p-2 rounded-xl mr-4 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    </span>
                                    <div class="text-left">
                                        <span class="block font-bold text-blue-900 text-sm">Gérer Utilisateurs</span>
                                        <span class="block text-blue-600/70 text-xs">Modérer les comptes</span>
                                    </div>
                                </div>
                            </x-admin.action-button>
                        </div>
                    </div>

                    {{-- System Status --}}
                    <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6">
                        <h2 class="text-xl font-bold text-shop-gray-900 font-display mb-6">État du Système</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                <div class="flex items-center">
                                    <span class="relative flex h-3 w-3 mr-3">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                    </span>
                                    <span class="text-sm font-bold text-emerald-900">Base de données</span>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full uppercase tracking-wide">En ligne</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                <div class="flex items-center">
                                    <span class="relative flex h-3 w-3 mr-3">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                    </span>
                                    <span class="text-sm font-bold text-emerald-900">Serveur Web</span>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2.5 py-1 rounded-full uppercase tracking-wide">En ligne</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Section Mockup --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-fade-in-up" style="animation-delay: 300ms;">
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 hover:shadow-card transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-shop-gray-900 font-display mb-6 flex items-center">
                        <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        </span>
                        Aperçu des Ventes
                    </h3>
                    <div class="h-64 flex items-center justify-center bg-shop-gray-50 rounded-2xl border-dashed border-2 border-shop-gray-200 group-hover:border-shop-gray-300 transition-colors">
                        <div class="text-center">
                             <svg class="w-12 h-12 text-shop-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            <p class="text-shop-gray-400 font-medium text-sm">Graphique des ventes (Chart.js)</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 hover:shadow-card transition-shadow duration-300">
                    <h3 class="text-lg font-bold text-shop-gray-900 font-display mb-6 flex items-center">
                         <span class="bg-purple-100 text-purple-600 p-1.5 rounded-lg mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </span>
                        Top Produits
                    </h3>
                    <div class="h-64 flex items-center justify-center bg-shop-gray-50 rounded-2xl border-dashed border-2 border-shop-gray-200 group-hover:border-shop-gray-300 transition-colors">
                        <div class="text-center">
                            <svg class="w-12 h-12 text-shop-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            <p class="text-shop-gray-400 font-medium text-sm">Graphique des produits (Chart.js)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-6 right-6 bg-emerald-600 text-white px-6 py-4 rounded-2xl shadow-xl flex items-center z-50">
            <svg class="w-6 h-6 mr-3 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="font-bold tracking-wide">{{ session('success') }}</span>
        </div>
    @endif
</body>
</html>
