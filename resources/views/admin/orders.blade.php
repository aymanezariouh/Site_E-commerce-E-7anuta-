<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes - E-7anuta Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-shop-gray-50 font-sans antialiased text-shop-gray-900">

    <x-admin.sidebar />

    <x-admin.navbar title="Gestion des Commandes" />

    <main class="lg:ml-64 pt-20 min-h-screen transition-all duration-300">
        <div class="p-6 lg:p-8 max-w-7xl mx-auto">

            <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4 animate-fade-in-up">
                <div>
                    <h1 class="text-3xl font-bold text-shop-gray-900 mb-2 font-display tracking-tight">Commandes</h1>
                    <p class="text-shop-gray-500 text-lg">Suivez et gérez les commandes des clients.</p>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="relative">
                         <input type="text" placeholder="Rechercher une commande..."
                               class="pl-10 pr-4 py-2.5 rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 w-full sm:w-64 text-sm shadow-sm transition-all">
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                             <svg class="w-5 h-5 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                         </div>
                    </div>

                    <button class="flex items-center space-x-2 px-4 py-2.5 bg-white border border-shop-gray-200 rounded-xl text-shop-gray-700 hover:bg-shop-gray-50 font-medium shadow-sm transition-all text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span>Filtrer</span>
                    </button>

                    <button class="flex items-center space-x-2 px-4 py-2.5 bg-white border border-shop-gray-200 rounded-xl text-shop-gray-700 hover:bg-shop-gray-50 font-medium shadow-sm transition-all text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Exporter</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 animate-fade-in-up" style="animation-delay: 100ms;">
                <div class="bg-white rounded-xl shadow-sm border border-shop-gray-100 p-4 flex items-center">
                    <div class="p-3 bg-blue-50 rounded-lg text-blue-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-shop-gray-500 uppercase tracking-wide">Total</p>
                        <p class="text-xl font-bold text-shop-gray-900">{{ $orders->total() }}</p>
                    </div>
                </div>

                 <div class="bg-white rounded-xl shadow-sm border border-shop-gray-100 p-4 flex items-center">
                    <div class="p-3 bg-amber-50 rounded-lg text-amber-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-shop-gray-500 uppercase tracking-wide">En Attente</p>
                        <p class="text-xl font-bold text-shop-gray-900">{{ $orders->where('status', 'pending')->count() }}</p>
                    </div>
                </div>

                 <div class="bg-white rounded-xl shadow-sm border border-shop-gray-100 p-4 flex items-center">
                    <div class="p-3 bg-green-50 rounded-lg text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-shop-gray-500 uppercase tracking-wide">Livrées</p>
                        <p class="text-xl font-bold text-shop-gray-900">{{ $orders->where('status', 'delivered')->count() }}</p>
                    </div>
                </div>

                 <div class="bg-white rounded-xl shadow-sm border border-shop-gray-100 p-4 flex items-center">
                    <div class="p-3 bg-red-50 rounded-lg text-red-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-shop-gray-500 uppercase tracking-wide">Annulées</p>
                        <p class="text-xl font-bold text-shop-gray-900">{{ $orders->where('status', 'cancelled')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-soft rounded-2xl border border-shop-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 200ms;">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-shop-gray-100">
                        <thead class="bg-shop-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Commande #</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Client</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Montant</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Statut</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-shop-gray-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-shop-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-brand-50 rounded-lg flex items-center justify-center text-brand-600 font-bold text-xs border border-brand-100">
                                                #{{ substr($order->order_number, -4) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-shop-gray-900">{{ $order->order_number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-shop-gray-400 to-shop-gray-600 flex items-center justify-center text-white text-xs font-bold">
                                                {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-shop-gray-900">{{ $order->user->name }}</div>
                                                <div class="text-xs text-shop-gray-500">{{ $order->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-shop-gray-900">{{ $order->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-shop-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-shop-gray-900">{{ number_format($order->total_amount, 2) }} €</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                'delivered' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                            ];

                                            $statusLabels = [
                                                'pending' => 'En attente',
                                                'processing' => 'En cours',
                                                'shipped' => 'Expédiée',
                                                'delivered' => 'Livrée',
                                                'cancelled' => 'Annulée',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            @if($order->status === 'delivered')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @elseif($order->status === 'pending')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            @endif
                                            {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2" x-data="{ open: false }">

                                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="mr-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()"
                                                        class="text-xs rounded-lg border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 py-1.5 pl-2 pr-8 bg-shop-gray-50 hover:bg-white transition-colors cursor-pointer select-arrow-padding">
                                                    @foreach($statusLabels as $value => $label)
                                                        <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>

                                            <button @click="open = !open" class="text-shop-gray-400 hover:text-shop-gray-600 p-1.5 rounded-lg hover:bg-shop-gray-100 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                            </button>

                                            <div x-show="open" @click.outside="open = false"
                                                 class="absolute right-12 z-10 w-48 bg-white rounded-xl shadow-xl border border-shop-gray-100 py-1"
                                                 style="display: none;"
                                                 x-transition:enter="transition ease-out duration-100"
                                                 x-transition:enter-start="transform opacity-0 scale-95"
                                                 x-transition:enter-end="transform opacity-100 scale-100">
                                                <a href="#" class="block px-4 py-2 text-sm text-shop-gray-700 hover:bg-shop-gray-50 hover:text-brand-600 transition-colors">Voir détails</a>
                                                <a href="#" class="block px-4 py-2 text-sm text-shop-gray-700 hover:bg-shop-gray-50 hover:text-brand-600 transition-colors">Télécharger facture</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-shop-gray-500 bg-shop-gray-50/30">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-shop-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <span class="text-lg font-medium text-shop-gray-900 mb-1">Aucune commande trouvée</span>
                                            <p class="text-sm">Les nouvelles commandes apparaîtront ici.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/30">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>