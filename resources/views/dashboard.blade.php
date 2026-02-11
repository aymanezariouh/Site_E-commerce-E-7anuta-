<x-app-layout>
    <div class="py-8 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            @role('seller')
                <!-- Welcome Section (Seller Only) -->
                <section class="relative overflow-hidden rounded-3xl border border-shop-gray-200 bg-white shadow-soft animate-fade-in-up">
                    <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-600 via-brand-500 to-brand-700"></div>
                    <div class="absolute -right-24 top-1/2 h-72 w-72 -translate-y-1/2 rounded-full bg-brand-100/80 blur-3xl"></div>
                    <div class="absolute right-0 top-0 h-full w-1/3 bg-gradient-to-l from-brand-50/70 to-transparent"></div>

                    <div class="relative z-10 p-8 sm:p-10 lg:p-12">
                        <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                            <div class="max-w-2xl">
                                <div class="mb-4 flex flex-wrap items-center gap-3 text-xs uppercase tracking-widest text-shop-gray-500">
                                    <span class="font-semibold">Tableau de bord Vendeur</span>
                                    <span class="h-1 w-1 rounded-full bg-shop-gray-300"></span>
                                    <span class="inline-flex items-center rounded-full border border-shop-gray-200 bg-shop-gray-50 px-3 py-1 text-xs font-semibold normal-case tracking-normal text-shop-gray-600">
                                        {{ now()->format('d M Y') }}
                                    </span>
                                </div>

                                <h1 class="text-4xl font-display font-bold leading-tight text-shop-gray-900 sm:text-5xl">
                                    Bonjour, {{ Auth::user()->name }}
                                </h1>

                                <p class="mt-3 text-base text-shop-gray-600 sm:text-lg">
                                    Vous avez <span class="font-bold text-shop-gray-900">{{ $sellerPendingOrdersCount }}</span> commande(s) en attente.
                                    Priorisez celles d'aujourd'hui.
                                </p>

                                <div class="mt-6 grid max-w-xl grid-cols-1 gap-3 sm:grid-cols-2 sm:gap-4">
                                    <div class="rounded-2xl border border-shop-gray-200 bg-shop-gray-50/80 px-4 py-3">
                                        <p class="text-xs font-semibold uppercase tracking-widest text-shop-gray-500">Commandes en attente</p>
                                        <p class="mt-1 text-2xl font-bold text-shop-gray-900">{{ $sellerPendingOrdersCount }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-shop-gray-200 bg-shop-gray-50/80 px-4 py-3">
                                        <p class="text-xs font-semibold uppercase tracking-widest text-shop-gray-500">Produits actifs</p>
                                        <p class="mt-1 text-2xl font-bold text-shop-gray-900">{{ $sellerActiveProductsCount }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-md transition-all duration-300 hover:-translate-y-0.5 hover:bg-brand-700 hover:shadow-lg">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Ajouter produit
                                </a>
                                <a href="{{ route('seller.orders') }}" class="inline-flex items-center gap-2 rounded-xl border border-shop-gray-300 bg-white px-5 py-3 text-sm font-bold text-shop-gray-700 transition-colors hover:bg-shop-gray-50 hover:text-shop-gray-900">
                                    Voir commandes
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Seller Quick Links -->
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
                 <!-- Buyer Dashboard -->
                 <div class="grid gap-8 lg:grid-cols-3">
                    <div class="space-y-8 lg:col-span-2">
                        <!-- Recent Orders -->
                        <section class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 overflow-hidden animate-fade-in-up">
                            <div class="p-6 border-b border-shop-gray-100 flex items-center justify-between">
                                <h4 class="text-xl font-bold text-shop-gray-900 font-display flex items-center gap-2">
                                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    Commandes Récentes
                                </h4>
                                <a href="{{ route('buyer.orders') }}" class="text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">
                                    Voir tout &rarr;
                                </a>
                            </div>
                            <div class="p-6">
                                @if($buyerRecentOrders->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($buyerRecentOrders as $order)
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-shop-gray-100 hover:bg-shop-gray-50 transition-colors">
                                                <div class="flex items-center gap-4">
                                                    <div class="h-12 w-12 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center font-bold">
                                                        #{{ substr($order->order_number, -4) }}
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-shop-gray-900">Commande {{ $order->order_number }}</p>
                                                        <p class="text-xs text-shop-gray-500">{{ $order->created_at->format('d M Y, H:i') }} • {{ $order->items->count() }} articles</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3 mt-3 sm:mt-0">
                                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                                        @if($order->status == 'completed') bg-green-100 text-green-800
                                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                    <span class="font-bold text-shop-gray-900 ml-2 mr-2">{{ number_format($order->total_amount, 2) }} MAD</span>
                                                    <a href="{{ route('buyer.orderDetails', $order->id) }}" class="text-brand-600 hover:text-brand-800">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <p class="text-shop-gray-500">Aucune commande récente.</p>
                                        <a href="{{ route('marketplace') }}" class="mt-2 inline-block text-brand-600 font-bold hover:underline">Commencer mes achats</a>
                                    </div>
                                @endif
                            </div>
                        </section>

                        <!-- Wishlist -->
                        <section class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 100ms;">
                            <div class="p-6 border-b border-shop-gray-100 flex items-center justify-between">
                                <h4 class="text-xl font-bold text-shop-gray-900 font-display flex items-center gap-2">
                                     <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    Ma Liste de Souhaits
                                </h4>
                                <span class="text-sm font-bold text-shop-gray-400">
                                    {{ $buyerWishlistCount }} produits
                                </span>
                            </div>
                            <div class="p-6">
                                @if($buyerWishlist->count() > 0)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        @foreach($buyerWishlist as $like)
                                            <div class="flex items-center gap-4 p-3 rounded-xl border border-shop-gray-100 hover:shadow-md transition-shadow bg-white">
                                                <div class="h-16 w-16 rounded-lg bg-shop-gray-100 overflow-hidden flex-shrink-0">
                                                     @if($like->product->primary_image)
                                                        <img src="{{ $like->product->primary_image }}" alt="{{ $like->product->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-shop-gray-400">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h5 class="font-bold text-shop-gray-900 truncate">{{ $like->product->name }}</h5>
                                                    <p class="text-brand-600 font-bold text-sm">{{ number_format($like->product->price, 2) }} MAD</p>
                                                </div>
                                                <a href="{{ route('marketplace.show', $like->product->id) }}" class="p-2 text-shop-gray-400 hover:text-brand-600 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-shop-gray-500 text-sm">Votre liste de souhaits est vide.</p>
                                @endif
                            </div>
                        </section>
                    </div>

                    <!-- Sidebar (Profile & Account Status) -->
                     <aside class="space-y-6 animate-fade-in-up" style="animation-delay: 200ms;">
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
                        <div class="bg-gradient-to-br from-brand-900 to-brand-800 rounded-3xl shadow-xl p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                            <h4 class="text-lg font-bold font-display mb-4 relative z-10">Statut du Compte</h4>
                            <div class="space-y-3 relative z-10">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-white/70">Type</span>
                                    <span class="font-bold bg-white/20 px-2 py-0.5 rounded text-xs border border-white/10">Acheteur</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-white/70">Statut</span>
                                    <span class="flex items-center gap-1.5 text-emerald-400 font-bold">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                        Actif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            @endrole
        </div>
    </div>
</x-app-layout>

