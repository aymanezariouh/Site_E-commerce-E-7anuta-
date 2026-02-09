<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Analytics</h2>
                <p class="text-sm text-slate-600 mt-1">Suivez vos performances de vente.</p>
            </section>

            <!-- Main Stats Cards -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="dash-card p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Ventes totales</p>
                            <p class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($totalSales, 2) }} €</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="dash-card p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Commandes</p>
                            <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalOrders }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="dash-card p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Produits</p>
                            <p class="text-2xl font-bold text-purple-600 mt-1">{{ $totalProducts }}</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="dash-card p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Note moyenne</p>
                            <p class="text-2xl font-bold text-amber-500 mt-1">{{ number_format($averageRating, 1) }} ★</p>
                            <p class="text-xs text-slate-500">{{ $totalReviews }} avis</p>
                        </div>
                        <div class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center">
                            <svg class="h-6 w-6 text-amber-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Orders by Status -->
                <div class="dash-card p-4">
                    <h5 class="dash-title text-base text-slate-800 mb-4">Commandes par statut</h5>
                    <div class="space-y-3">
                        @php
                            $statusLabels = [
                                'pending' => ['label' => 'En attente', 'color' => 'bg-amber-500'],
                                'processing' => ['label' => 'En cours', 'color' => 'bg-indigo-500'],
                                'shipped' => ['label' => 'Expédiées', 'color' => 'bg-purple-500'],
                                'delivered' => ['label' => 'Livrées', 'color' => 'bg-emerald-500'],
                                'cancelled' => ['label' => 'Annulées', 'color' => 'bg-rose-500'],
                                'refunded' => ['label' => 'Remboursées', 'color' => 'bg-slate-400'],
                            ];
                        @endphp
                        @foreach ($statusLabels as $status => $info)
                            @php
                                $count = $ordersByStatus[$status] ?? 0;
                                $percentage = $totalOrders > 0 ? ($count / $totalOrders) * 100 : 0;
                            @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-slate-600">{{ $info['label'] }}</span>
                                    <span class="font-semibold text-slate-800">{{ $count }}</span>
                                </div>
                                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="{{ $info['color'] }} h-full rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Top Products -->
                <div class="dash-card p-4">
                    <h5 class="dash-title text-base text-slate-800 mb-4">Produits les plus vendus</h5>
                    @if ($topProducts->count() > 0)
                        <div class="space-y-3">
                            @foreach ($topProducts as $index => $product)
                                <div class="flex items-center gap-3">
                                    <span class="flex-shrink-0 h-8 w-8 rounded-full bg-slate-100 flex items-center justify-center text-sm font-semibold text-slate-600">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-800 truncate">{{ $product->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $product->sold_quantity ?? 0 }} vendus</p>
                                    </div>
                                    <span class="text-sm font-semibold text-emerald-600">
                                        {{ number_format($product->revenue ?? 0, 2) }} €
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500">Aucune vente pour le moment.</p>
                    @endif
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Stock Alerts -->
                <div class="dash-card p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="dash-title text-base text-slate-800">Alertes stock</h5>
                        <span class="rounded-full px-2 py-1 text-xs {{ $lowStockCount > 0 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ $lowStockCount }} produit(s)
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Produits en rupture/stock bas</span>
                            <span class="font-semibold text-slate-800">{{ $lowStockCount }} / {{ $totalProducts }}</span>
                        </div>
                        <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="{{ $stockAlertRate > 20 ? 'bg-rose-500' : ($stockAlertRate > 10 ? 'bg-amber-500' : 'bg-emerald-500') }} h-full rounded-full" 
                                 style="width: {{ $stockAlertRate }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500">{{ $stockAlertRate }}% de vos produits ont un stock ≤ 5</p>
                    </div>
                    @if ($lowStockCount > 0)
                        <a href="{{ route('seller.stock') }}" class="mt-4 inline-block text-sm text-teal-600 hover:text-teal-700">
                            Voir le stock →
                        </a>
                    @endif
                </div>

                <!-- Monthly Sales -->
                <div class="dash-card p-4">
                    <h5 class="dash-title text-base text-slate-800 mb-4">Ventes des 6 derniers mois</h5>
                    @if ($monthlySales->count() > 0)
                        <div class="space-y-2">
                            @foreach ($monthlySales as $month)
                                @php
                                    $monthNames = ['', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
                                    $maxSale = $monthlySales->max('total') ?: 1;
                                    $percentage = ($month->total / $maxSale) * 100;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-slate-600">{{ $monthNames[$month->month] }} {{ $month->year }}</span>
                                        <span class="font-semibold text-slate-800">{{ number_format($month->total, 2) }} €</span>
                                    </div>
                                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="bg-teal-500 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-500">Aucune donnée de ventes.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
