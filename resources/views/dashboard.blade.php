<x-app-layout>
    <div class="py-8 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Section with Glassmorphism & Gradient -->
            <section class="relative rounded-3xl overflow-hidden shadow-2xl animate-fade-in-up">
                <!-- Background Gradient -->
                <div class="absolute inset-0 bg-gradient-to-r from-brand-600 to-brand-800"></div>
                <!-- Abstract Shapes -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-brand-400 opacity-20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 p-8 sm:p-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div class="text-white">
                        <div class="flex items-center gap-3 mb-2 opacity-90">
                            <span class="text-sm font-bold uppercase tracking-widest">Tableau de bord</span>
                            <span class="w-1 h-1 rounded-full bg-white"></span>
                            <span class="text-xs font-medium bg-white/20 px-2 py-0.5 rounded-full backdrop-blur-sm border border-white/10">
                                {{ now()->format('d M Y') }}
                            </span>
                        </div>
                        <h1 class="text-4xl font-bold font-display leading-tight mb-2">
                            Bonjour, {{ Auth::user()->name }} 👋
                        </h1>
                        <p class="text-brand-100 text-lg max-w-xl">
                            Voici un aperçu de vos performances aujourd'hui. Vous avez <span class="font-bold text-white">3 nouvelles commandes</span> à traiter.
                        </p>
                    </div>
                    
                    <div class="flex gap-3">
                        @role('seller')
                             <a href="{{ route('seller.products.create') }}" class="px-5 py-3 bg-white text-brand-700 rounded-xl font-bold shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Ajouter Produit
                            </a>
                        @endrole
                    </div>
                </div>
            </section>

            <!-- Quick Stats Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white p-5 rounded-2xl shadow-soft border border-shop-gray-100 hover:shadow-lg transition-all duration-300 group animate-fade-in-up" style="animation-delay: 100ms;">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg border border-green-100">+12%</span>
                    </div>
                    <p class="text-shop-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Commandes</p>
                    <h3 class="text-2xl font-bold text-shop-gray-900 font-display">1,245</h3>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white p-5 rounded-2xl shadow-soft border border-shop-gray-100 hover:shadow-lg transition-all duration-300 group animate-fade-in-up" style="animation-delay: 150ms;">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg border border-green-100">+5%</span>
                    </div>
                    <p class="text-shop-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Revenus</p>
                    <h3 class="text-2xl font-bold text-shop-gray-900 font-display">45.2k MAD</h3>
                </div>

                 <!-- Stat Card 3 -->
                <div class="bg-white p-5 rounded-2xl shadow-soft border border-shop-gray-100 hover:shadow-lg transition-all duration-300 group animate-fade-in-up" style="animation-delay: 200ms;">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                         <span class="text-xs font-bold text-shop-gray-500 bg-shop-gray-50 px-2 py-1 rounded-lg border border-shop-gray-100">--</span>
                    </div>
                    <p class="text-shop-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Vues Boutique</p>
                    <h3 class="text-2xl font-bold text-shop-gray-900 font-display">8.5k</h3>
                </div>

                 <!-- Stat Card 4 -->
                <div class="bg-white p-5 rounded-2xl shadow-soft border border-shop-gray-100 hover:shadow-lg transition-all duration-300 group animate-fade-in-up" style="animation-delay: 250ms;">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg border border-green-100">+0.2</span>
                    </div>
                    <p class="text-shop-gray-500 text-xs font-bold uppercase tracking-wider mb-1">Note Moyenne</p>
                    <h3 class="text-2xl font-bold text-shop-gray-900 font-display">4.8 <span class="text-sm font-medium text-shop-gray-400">/ 5.0</span></h3>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-3">
                <!-- Main Content Column -->
                <div class="space-y-8 lg:col-span-2 animate-fade-in-up" style="animation-delay: 300ms;">
                    @role('seller')
                        <!-- Seller Quick Links with Glass/Hover Effects -->
                        <section class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-shop-gray-100 flex items-center justify-between">
                                <h4 class="text-xl font-bold text-shop-gray-900 font-display flex items-center gap-2">
                                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Espace Vendeur
                                </h4>
                                <a href="{{ route('seller.analytics') }}" class="text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">
                                    Voir Statistiques &rarr;
                                </a>
                            </div>
                            
                            <div class="p-6 bg-shop-gray-50/30">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Card 1 -->
                                    <a href="{{ route('seller.products.create') }}" class="group relative flex flex-col items-center justify-center p-6 bg-white rounded-2xl border border-shop-gray-200 hover:border-brand-300 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                                        <div class="absolute inset-0 bg-brand-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative z-10 w-14 h-14 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-sm">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </div>
                                        <span class="relative z-10 font-bold text-shop-gray-900 group-hover:text-brand-700 transition-colors">Créer un produit</span>
                                        <span class="relative z-10 text-xs text-shop-gray-500 mt-1">Ajouter au catalogue</span>
                                    </a>

                                    <!-- Card 2 -->
                                    <a href="{{ route('seller.products.index') }}" class="group relative flex flex-col items-center justify-center p-6 bg-white rounded-2xl border border-shop-gray-200 hover:border-blue-300 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                                        <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative z-10 w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-sm">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                        <span class="relative z-10 font-bold text-shop-gray-900 group-hover:text-blue-700 transition-colors">Mes Produits</span>
                                        <span class="relative z-10 text-xs text-shop-gray-500 mt-1">Gérer l'inventaire</span>
                                    </a>

                                    <!-- Card 3 -->
                                    <a href="{{ route('seller.orders') }}" class="group relative flex flex-col items-center justify-center p-6 bg-white rounded-2xl border border-shop-gray-200 hover:border-purple-300 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                                        <div class="absolute inset-0 bg-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="relative z-10 w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-sm">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        </div>
                                        <span class="relative z-10 font-bold text-shop-gray-900 group-hover:text-purple-700 transition-colors">Commandes</span>
                                        <span class="relative z-10 text-xs text-shop-gray-500 mt-1">Suivre les ventes</span>
                                    </a>
                                </div>
                            </div>
                        </section>
                    @endrole

                    @role('buyer')
                        <div class="space-y-6">
                            <x-buyer.marketplace />
                            <div id="orders"></div>
                            <x-buyer.liked-products />
                            <x-buyer.reviews />
                            <x-buyer.notifications />
                        </div>
                    @endrole
                </div>

                <!-- Sidebar -->
                <aside class="space-y-6 animate-fade-in-up" style="animation-delay: 400ms;">
                     <!-- Quick Actions Menu -->
                    <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 p-6">
                        <h4 class="text-lg font-bold text-shop-gray-900 font-display mb-4 flex items-center gap-2">
                             <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Raccourcis
                        </h4>
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('profile.edit') }}" class="flex items-center justify-between p-3 rounded-2xl hover:bg-shop-gray-50 group transition-all duration-200 border border-transparent hover:border-shop-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-shop-gray-50 flex items-center justify-center text-shop-gray-500 group-hover:bg-white group-hover:shadow-sm group-hover:text-shop-gray-900 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <span class="font-bold text-shop-gray-700 group-hover:text-shop-gray-900 text-sm">Mon Profil</span>
                                </div>
                                <svg class="w-5 h-5 text-shop-gray-300 group-hover:translate-x-1 group-hover:text-brand-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                            
                            <a href="#" class="flex items-center justify-between p-3 rounded-2xl hover:bg-shop-gray-50 group transition-all duration-200 border border-transparent hover:border-shop-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-shop-gray-50 flex items-center justify-center text-shop-gray-500 group-hover:bg-white group-hover:shadow-sm group-hover:text-shop-gray-900 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <span class="font-bold text-shop-gray-700 group-hover:text-shop-gray-900 text-sm">Support Client</span>
                                </div>
                                <svg class="w-5 h-5 text-shop-gray-300 group-hover:translate-x-1 group-hover:text-brand-500 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="bg-gradient-to-br from-shop-gray-900 to-shop-gray-800 rounded-3xl shadow-xl p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                        <h4 class="text-lg font-bold font-display mb-4 relative z-10">Statut du Compte</h4>
                        <div class="space-y-3 relative z-10">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-400">Type</span>
                                <span class="font-bold bg-white/20 px-2 py-0.5 rounded text-xs border border-white/10">Vendeur Pro</span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-400">Statut</span>
                                <span class="flex items-center gap-1.5 text-emerald-400 font-bold">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Actif
                                </span>
                            </div>
                             <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-400">Abonnement</span>
                                <span class="text-gray-200 text-xs">Renouvellement dans 12j</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
