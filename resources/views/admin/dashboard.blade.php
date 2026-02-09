<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-7anuta</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    {{-- Sidebar --}}
    <x-admin.sidebar />
    
    {{-- Navbar --}}
    <x-admin.navbar title="Tableau de bord" />
    
    {{-- Main Content --}}
    <main class="ml-64 pt-16 min-h-screen">
        <div class="p-6">
            {{-- Welcome Section --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Bonjour, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-gray-600">
                    Voici un aperçu de votre plateforme e-commerce aujourd'hui.
                </p>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <x-admin.stat-card
                    title="Utilisateurs"
                    :value="$stats['users']"
                    type="users"
                    :change="$stats['users_change']"
                />
                <x-admin.stat-card
                    title="Commandes"
                    :value="$stats['orders']"
                    type="orders"
                    :change="$stats['orders_change']"
                />
                <x-admin.stat-card
                    title="Produits"
                    :value="$stats['products']"
                    type="products"
                    :change="$stats['products_change']"
                />
                <x-admin.stat-card
                    title="Revenus"
                    :value="number_format($stats['revenue'], 0, ',', ' ') . ' €'"
                    type="revenue"
                    :change="$stats['revenue_change']"
                />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                {{-- Recent Activity --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Activité récente</h3>
                            <x-admin.action-button href="{{ route('admin.orders') }}" color="gray-ghost" size="sm">
                                Voir tout
                            </x-admin.action-button>
                        </div>
                        
                        <div class="space-y-4">
                            {{-- Activity items --}}
                            <div class="flex items-start space-x-3 p-3 rounded-lg bg-blue-50">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium">Nouvelle commande</span> de Marie Dubois
                                    </p>
                                    <p class="text-sm text-gray-500">Commande #12345 - 127,50 €</p>
                                    <p class="text-xs text-gray-400">Il y a 5 minutes</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-lg bg-green-50">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium">Nouveau utilisateur</span> inscrit
                                    </p>
                                    <p class="text-sm text-gray-500">Paul Martin s'est inscrit comme vendeur</p>
                                    <p class="text-xs text-gray-400">Il y a 15 minutes</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-lg bg-yellow-50">
                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium">Produit en attente</span> de modération
                                    </p>
                                    <p class="text-sm text-gray-500">iPhone 15 Pro soumis par TechStore</p>
                                    <p class="text-xs text-gray-400">Il y a 1 heure</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-lg bg-red-50">
                                <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">
                                        <span class="font-medium">Signalement</span> d'un avis
                                    </p>
                                    <p class="text-sm text-gray-500">Avis signalé pour contenu inapproprié</p>
                                    <p class="text-xs text-gray-400">Il y a 2 heures</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="space-y-6">
                    {{-- Actions rapides --}}
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h3>
                        <div class="space-y-3">
                            <x-admin.action-button href="{{ route('admin.users') }}" color="blue" size="sm" class="w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Gérer les utilisateurs
                            </x-admin.action-button>
                            
                            <x-admin.action-button href="{{ route('admin.products') }}" color="green" size="sm" class="w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Modérer les produits
                            </x-admin.action-button>
                            
                            <x-admin.action-button href="{{ route('admin.orders') }}" color="yellow" size="sm" class="w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                Voir les commandes
                            </x-admin.action-button>
                            
                            <x-admin.action-button href="{{ route('admin.reviews') }}" color="red" size="sm" class="w-full justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Modérer les avis
                            </x-admin.action-button>
                        </div>
                    </div>

                    {{-- System Status --}}
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">État du système</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Serveur</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    En ligne
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Base de données</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Connecté
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Cache</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Optimisable
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Files d'attente</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Actives
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts/Analytics Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Sales Chart Placeholder --}}
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Ventes des 30 derniers jours</h3>
                        <x-admin.action-button color="gray-ghost" size="sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Exporter
                        </x-admin.action-button>
                    </div>
                    <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">Graphique des ventes</p>
                        </div>
                    </div>
                </div>

                {{-- Top Products --}}
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Produits populaires</h3>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <span class="text-blue-600 font-semibold text-sm">1</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">iPhone 15 Pro</p>
                                <p class="text-xs text-gray-500">156 ventes ce mois</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">18,720 €</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <span class="text-green-600 font-semibold text-sm">2</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">MacBook Air M3</p>
                                <p class="text-xs text-gray-500">89 ventes ce mois</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">12,340 €</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <span class="text-yellow-600 font-semibold text-sm">3</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">AirPods Pro</p>
                                <p class="text-xs text-gray-500">67 ventes ce mois</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">8,950 €</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
