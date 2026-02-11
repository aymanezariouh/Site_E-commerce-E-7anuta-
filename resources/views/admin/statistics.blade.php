<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - E-7anuta Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-shop-gray-50 font-sans antialiased text-shop-gray-900">
    {{-- Sidebar --}}
    <x-admin.sidebar />
    
    {{-- Navbar --}}
    <x-admin.navbar title="Statistiques" />
    
    {{-- Main Content --}}
    <main class="lg:ml-64 pt-20 min-h-screen transition-all duration-300">
        <div class="p-6 lg:p-8 max-w-7xl mx-auto">
            {{-- Header --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 animate-fade-in-up">
                <div>
                    <h1 class="text-3xl font-bold text-shop-gray-900 mb-2 font-display tracking-tight">Vue d'ensemble</h1>
                    <p class="text-shop-gray-500 text-lg">Analysez les performances de votre boutique en temps réel.</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-shop-gray-200 p-1 flex items-center">
                    <button class="px-4 py-2 text-sm font-bold text-brand-600 bg-brand-50 rounded-lg transition-colors">7 derniers jours</button>
                    <button class="px-4 py-2 text-sm font-medium text-shop-gray-600 hover:text-shop-gray-900 hover:bg-shop-gray-50 rounded-lg transition-colors">30 jours</button>
                    <button class="px-4 py-2 text-sm font-medium text-shop-gray-600 hover:text-shop-gray-900 hover:bg-shop-gray-50 rounded-lg transition-colors">Ce mois</button>
                    <button class="px-4 py-2 text-sm font-medium text-shop-gray-600 hover:text-shop-gray-900 hover:bg-shop-gray-50 rounded-lg transition-colors">Cette année</button>
                </div>
            </div>

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-fade-in-up" style="animation-delay: 100ms;">
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 flex flex-col justify-between h-full">
                     <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-brand-50 rounded-2xl">
                             <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                            +12.5%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-shop-gray-500 uppercase tracking-wide">Chiffre d'affaires</p>
                        <p class="text-3xl font-bold text-shop-gray-900 mt-1 font-display">{{ number_format($kpis['revenue'], 2) }} €</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 flex flex-col justify-between h-full">
                     <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-blue-50 rounded-2xl">
                             <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                            +5.2%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-shop-gray-500 uppercase tracking-wide">Commandes</p>
                        <p class="text-3xl font-bold text-shop-gray-900 mt-1 font-display">{{ $kpis['orders_count'] }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 flex flex-col justify-between h-full">
                     <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-purple-50 rounded-2xl">
                             <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                             +8.1%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-shop-gray-500 uppercase tracking-wide">Nouveaux Clients</p>
                        <p class="text-3xl font-bold text-shop-gray-900 mt-1 font-display">{{ $kpis['new_customers'] }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 flex flex-col justify-between h-full">
                     <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-amber-50 rounded-2xl">
                             <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                            -1.2%
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-shop-gray-500 uppercase tracking-wide">Taux de Conversion</p>
                        <p class="text-3xl font-bold text-shop-gray-900 mt-1 font-display">{{ $kpis['conversion_rate'] }}%</p>
                    </div>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 animate-fade-in-up" style="animation-delay: 200ms;">
                {{-- Sales Chart --}}
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                         <h3 class="text-lg font-bold text-shop-gray-900 font-display">Évolution des Ventes</h3>
                         <button class="p-2 text-shop-gray-400 hover:text-shop-gray-600 rounded-lg hover:bg-shop-gray-50 transition-colors">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                         </button>
                    </div>
                    <div class="h-80 w-full relative">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                {{-- Orders Status Chart --}}
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6">
                     <div class="flex items-center justify-between mb-6">
                         <h3 class="text-lg font-bold text-shop-gray-900 font-display">État des Commandes</h3>
                          <button class="p-2 text-shop-gray-400 hover:text-shop-gray-600 rounded-lg hover:bg-shop-gray-50 transition-colors">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                         </button>
                    </div>
                    <div class="h-80 w-full relative flex items-center justify-center">
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Top Products Table --}}
            <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 animate-fade-in-up" style="animation-delay: 300ms;">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-shop-gray-900 font-display">Produits les plus vendus</h3>
                    <a href="{{ route('admin.products') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors">Voir le catalogue</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-shop-gray-100">
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Produit</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Catégorie</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Ventes</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Revenus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-shop-gray-100">
                            @forelse($topProducts as $product)
                            <tr class="hover:bg-shop-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-lg bg-shop-gray-100 flex items-center justify-center overflow-hidden border border-shop-gray-200">
                                            @if($product->primary_image)
                                                <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                            @else
                                                <svg class="h-5 w-5 text-shop-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-shop-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-shop-gray-500">SKU: {{ $product->sku }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-600">
                                    {{ $product->category->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ $product->orders_count }} ventes
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-shop-gray-900">
                                    {{ number_format($product->total_revenue, 2) }} €
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-shop-gray-500">
                                    Aucune donnée disponible
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart.js Configuration
            Chart.defaults.font.family = "'Figtree', sans-serif";
            Chart.defaults.color = '#64748b';
            
            // Sales Chart
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($charts['sales']['labels']) !!},
                    datasets: [{
                        label: 'Ventes',
                        data: {!! json_encode($charts['sales']['data']) !!},
                        borderColor: '#2dd4bf', // brand-400
                        backgroundColor: 'rgba(45, 212, 191, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#2dd4bf',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1E293B',
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
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                             ticks: { padding: 10 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { padding: 10 }
                        }
                    }
                }
            });

            // Orders Status Chart
            const ordersCtx = document.getElementById('ordersChart').getContext('2d');
            new Chart(ordersCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($charts['orders']['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($charts['orders']['data']) !!},
                        backgroundColor: [
                            '#fbbf24', // amber-400 (pending)
                            '#2dd4bf', // brand-400 (completed)
                            '#ef4444', // red-500 (cancelled)
                            '#60a5fa'  // blue-400 (processing)
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: { size: 12, weight: '500' }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>
