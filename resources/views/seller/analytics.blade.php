<x-app-layout>
    <!-- Chart.js CDN (Load specific version for stability) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <div class="py-8 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in-up">
                <div>
                     <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-brand-600 bg-brand-50 px-2.5 py-0.5 rounded-full">Pro Data</span>
                    </div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900 tracking-tight">Analytics & Ventes</h2>
                    <p class="mt-1 text-shop-gray-500 text-lg">Analysez la performance détaillée de votre boutique.</p>
                </div>
                <!-- Date Range Picker Mockup -->
                <div class="flex items-center gap-2 bg-white p-1 rounded-xl shadow-sm border border-shop-gray-200">
                    <button class="px-4 py-2 text-sm font-bold bg-brand-50 text-brand-700 rounded-lg shadow-sm">30 Derniers jours</button>
                    <button class="px-4 py-2 text-sm font-medium text-shop-gray-600 hover:bg-shop-gray-50 rounded-lg transition-colors">Cette année</button>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 animate-fade-in-up" style="animation-delay: 100ms;">
                <!-- Revenue -->
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-5 group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-white shadow-md">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-green-50 text-green-700">
                            +12.5%
                        </span>
                    </div>
                    <p class="text-sm font-medium text-shop-gray-500">Revenus Totaux</p>
                    <p class="text-2xl font-bold text-shop-gray-900 mt-1 font-display">{{ number_format($totalSales, 2) }} <span class="text-sm text-shop-gray-400 font-normal">MAD</span></p>
                </div>

                <!-- Orders -->
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-5 group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white shadow-md">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-blue-50 text-blue-700">
                            +5.2%
                        </span>
                    </div>
                    <p class="text-sm font-medium text-shop-gray-500">Commandes</p>
                    <p class="text-2xl font-bold text-shop-gray-900 mt-1 font-display">{{ $totalOrders }}</p>
                </div>

                <!-- Products -->
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-5 group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-purple-400 to-fuchsia-600 flex items-center justify-center text-white shadow-md">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                         <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-purple-50 text-purple-700">
                            Actifs
                        </span>
                    </div>
                    <p class="text-sm font-medium text-shop-gray-500">Catalogue</p>
                    <p class="text-2xl font-bold text-shop-gray-900 mt-1 font-display">{{ $totalProducts }} <span class="text-sm text-shop-gray-400 font-normal">produits</span></p>
                </div>

                <!-- Rating -->
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-5 group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white shadow-md">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        </div>
                         <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-700">
                            {{ $totalReviews }} avis
                        </span>
                    </div>
                    <p class="text-sm font-medium text-shop-gray-500">Note Moyenne</p>
                    <p class="text-2xl font-bold text-shop-gray-900 mt-1 font-display">{{ number_format($averageRating, 1) }} <span class="text-sm text-shop-gray-400 font-normal">/ 5.0</span></p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid gap-6 lg:grid-cols-3 animate-fade-in-up" style="animation-delay: 200ms;">
                
                <!-- Main Sales Chart (Col Span 2) -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-soft border border-shop-gray-100 p-6 flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-shop-gray-900 font-display">Évolution des Ventes</h3>
                        <button class="p-2 text-shop-gray-400 hover:text-shop-gray-600 hover:bg-shop-gray-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                        </button>
                    </div>
                    <!-- Chart Canvas -->
                    <div class="flex-grow w-full h-[300px] relative">
                         @if($monthlySales->count() > 0)
                             <canvas id="salesChart"></canvas>
                         @else
                            <div class="flex items-center justify-center h-full text-shop-gray-400">
                                Pas de données suffisantes pour le graphique
                            </div>
                         @endif
                    </div>
                </div>

                <!-- Orders Status Doughnut (Col Span 1) -->
                <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 p-6 flex flex-col">
                    <h3 class="text-lg font-bold text-shop-gray-900 font-display mb-6">État des Commandes</h3>
                    <div class="flex-grow w-full h-[250px] relative flex items-center justify-center">
                         <canvas id="ordersChart"></canvas>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <!-- Legend is handled by Chart.js usually, but we can do custom pills if we want -->
                    </div>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="grid gap-6 lg:grid-cols-2 animate-fade-in-up" style="animation-delay: 300ms;">
                
                <!-- Top Products Table -->
                <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 p-6">
                    <h3 class="text-lg font-bold text-shop-gray-900 font-display mb-6">Top Produits</h3>
                    <div class="space-y-4">
                        @forelse ($topProducts as $index => $product)
                            <div class="flex items-center gap-4 p-4 rounded-2xl hover:bg-shop-gray-50 transition-colors border border-transparent hover:border-shop-gray-100 group">
                                <div class="flex-shrink-0 h-10 w-10 text-xl font-bold text-shop-gray-300 flex items-center justify-center">
                                    #{{ $index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-shop-gray-900 truncate group-hover:text-brand-600 transition-colors">{{ $product->name }}</p>
                                    <p class="text-xs text-shop-gray-500">{{ $product->sold_quantity ?? 0 }} ventes</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-shop-gray-900">{{ number_format($product->revenue ?? 0, 2) }} MAD</p>
                                     <span class="inline-block w-full h-1 bg-shop-gray-100 rounded-full mt-1 overflow-hidden">
                                        <span class="block h-full bg-brand-500 rounded-full" style="width: {{ $topProducts->max('revenue') > 0 ? ($product->revenue / $topProducts->max('revenue')) * 100 : 0 }}%"></span>
                                     </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-shop-gray-500 text-sm">
                                Aucune vente enregistrée pour le moment.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Stock Health Circular Progress -->
                <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 p-6 flex flex-col items-center justify-center text-center">
                    <h3 class="text-lg font-bold text-shop-gray-900 font-display mb-2">Santé du Stock</h3>
                    <p class="text-sm text-shop-gray-500 mb-8 max-w-xs">Pourcentage de produits avec un niveau de stock suffisant.</p>
                    
                    <div class="relative w-48 h-48 mb-8">
                         <!-- Standard SVG Circle Progress -->
                         <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                             <circle cx="50" cy="50" r="40" fill="transparent" stroke="#f1f5f9" stroke-width="8" />
                             <!-- Dasharray: 2 * PI * R approx 251 -->
                             <circle cx="50" cy="50" r="40" fill="transparent" stroke="{{ $stockAlertRate > 20 ? '#ef4444' : '#10b981' }}" stroke-width="8" stroke-linecap="round" stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 * (1 - ((100 - $stockAlertRate) / 100)) }}" />
                         </svg>
                         <div class="absolute inset-0 flex flex-col items-center justify-center">
                             <span class="text-4xl font-bold font-display text-shop-gray-900">{{ 100 - $stockAlertRate }}%</span>
                             <span class="text-xs font-bold text-shop-gray-400 uppercase tracking-widest mt-1">Sain</span>
                         </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 w-full max-w-xs">
                        <div class="bg-red-50 p-3 rounded-xl border border-red-100">
                            <p class="text-xs font-bold text-red-600 uppercase mb-1">Critique</p>
                            <p class="text-xl font-bold text-red-900">{{ $lowStockCount }}</p>
                        </div>
                        <div class="bg-green-50 p-3 rounded-xl border border-green-100">
                             <p class="text-xs font-bold text-green-600 uppercase mb-1">Total</p>
                            <p class="text-xl font-bold text-green-900">{{ $totalProducts }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Chart Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Figtree', sans-serif";
            Chart.defaults.color = '#64748b';

            // Data passed from backend
            const monthlySalesData = {!! json_encode($monthlySales) !!};
            const ordersByStatus = {!! json_encode($ordersByStatus) !!};

            // Process Monthly Sales
            const labels = [];
            const data = [];
            const monthNames = ['', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
            
            monthlySalesData.forEach(item => {
                labels.push(monthNames[item.month]);
                data.push(item.total);
            });

            // 1. Sales Chart
            const salesCtx = document.getElementById('salesChart');
            if (salesCtx) {
                new Chart(salesCtx.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels.length ? labels : ['Jan', 'Fev'], // Fallback
                        datasets: [{
                            label: 'Ventes (MAD)',
                            data: data.length ? data : [0, 0], // Fallback
                            borderColor: '#0d9488', // brand-600
                            backgroundColor: (context) => {
                                const ctx = context.chart.ctx;
                                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                gradient.addColorStop(0, 'rgba(13, 148, 136, 0.2)');
                                gradient.addColorStop(1, 'rgba(13, 148, 136, 0)');
                                return gradient;
                            },
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#0d9488',
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1e293b',
                                padding: 12,
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: '#f1f5f9', borderDash: [5, 5] },
                                ticks: { padding: 10 }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { padding: 10 }
                            }
                        }
                    }
                });
            }

            // 2. Orders Doughnut
            const ordersCtx = document.getElementById('ordersChart');
            if (ordersCtx) {
                const statusData = [
                    ordersByStatus.pending || 0,
                    ordersByStatus.processing || 0,
                    ordersByStatus.shipped || 0,
                    ordersByStatus.delivered || 0,
                    ordersByStatus.cancelled || 0
                ];
                
                new Chart(ordersCtx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['En attente', 'Traitement', 'Expédé', 'Livré', 'Annulé'],
                        datasets: [{
                            data: statusData,
                            backgroundColor: [
                                '#f59e0b', // amber
                                '#3b82f6', // blue
                                '#a855f7', // purple
                                '#10b981', // emerald
                                '#ef4444'  // red
                            ],
                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { usePointStyle: true, padding: 20, font: {size: 11} }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
