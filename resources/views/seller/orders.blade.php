<x-app-layout>
    <div class="py-8 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header with Actions -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in-up">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900 tracking-tight">Commandes</h2>
                    <p class="mt-1 text-shop-gray-500 text-lg">Gérez et traitez les commandes de vos clients.</p>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative group">
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                             <svg class="w-5 h-5 text-shop-gray-400 group-focus-within:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                         </div>
                         <input type="text" placeholder="Rechercher commande..." 
                               class="pl-10 pr-4 py-2.5 rounded-xl border-shop-gray-200 focus:border-brand-500 focus:ring-brand-500 w-full sm:w-64 text-sm shadow-sm transition-all">
                    </div>
                    
                    <button class="flex items-center space-x-2 px-4 py-2.5 bg-white border border-shop-gray-200 rounded-xl text-shop-gray-700 hover:bg-shop-gray-50 font-bold shadow-sm transition-all text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span>Filtrer</span>
                    </button>
                    
                    <button class="flex items-center space-x-2 px-4 py-2.5 bg-brand-600 text-white rounded-xl hover:bg-brand-700 font-bold shadow-lg shadow-brand-500/30 transition-all text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span>Exporter</span>
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                     class="rounded-xl bg-emerald-50 border border-emerald-100 p-4 flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-emerald-800 text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Orders Table Card -->
            <div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 100ms;">
                <!-- Table Header -->
                <div class="px-6 py-5 border-b border-shop-gray-100 bg-shop-gray-50/30 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-shop-gray-900 font-display">Toutes les commandes</h3>
                        <p class="text-sm text-shop-gray-500">{{ $orders->total() }} résultats trouvés</p>
                    </div>
                    <div class="flex gap-2">
                        <!-- Pagination Summary -->
                        <span class="text-sm text-shop-gray-500">Page {{ $orders->currentPage() }} sur {{ $orders->lastPage() }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-shop-gray-100">
                        <thead class="bg-shop-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Commande</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Client</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Détails</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Statut</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Date</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-shop-gray-100">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-shop-gray-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-10 w-10 rounded-xl bg-brand-50 flex items-center justify-center text-brand-700 font-bold text-xs border border-brand-100 group-hover:scale-110 transition-transform">
                                                #{{ substr($order->order_number, -4) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-shop-gray-900">{{ $order->order_number }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-r from-shop-gray-200 to-shop-gray-300 flex items-center justify-center text-shop-gray-600 font-bold text-xs">
                                                {{ strtoupper(substr($order->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-shop-gray-900">{{ $order->user->name ?? 'Invité' }}</div>
                                                <div class="text-xs text-shop-gray-500">{{ $order->user->email ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-shop-gray-600">
                                            <span class="font-bold text-shop-gray-900">{{ $order->seller_items_count }}</span> article(s)
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-lg inline-block">
                                            {{ number_format($order->seller_total, 2) }} MAD
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'En attente', 'dot' => 'bg-amber-500'],
                                                'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Traitement', 'dot' => 'bg-blue-500'],
                                                'shipped' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-700', 'label' => 'Expédiée', 'dot' => 'bg-purple-500'],
                                                'delivered' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Livrée', 'dot' => 'bg-emerald-500'],
                                                'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Annulée', 'dot' => 'bg-red-500'],
                                                'refunded' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Remboursée', 'dot' => 'bg-gray-500'],
                                            ];
                                            $status = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $status['bg'] }} {{ $status['text'] }} border border-transparent">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }} mr-1.5 animate-pulse"></span>
                                            {{ $status['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-500">
                                        {{ $order->created_at->format('d/m/Y') }}
                                        <span class="text-xs text-shop-gray-400 block">{{ $order->created_at->format('H:i') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('seller.orders.show', $order) }}" class="p-2 text-shop-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Voir les détails">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>

                                            @if ($order->status === 'pending')
                                                <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="accepted">
                                                    <button type="submit" class="p-2 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all" title="Accepter la commande">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                </form>
                                            @elseif ($order->status === 'processing')
                                                 <form method="POST" action="{{ route('seller.orders.updateStatus', $order) }}">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="shipped">
                                                    <button type="submit" class="p-2 text-purple-500 hover:text-purple-700 hover:bg-purple-50 rounded-lg transition-all" title="Marquer comme expédié">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-shop-gray-500 bg-shop-gray-50/20">
                                         <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-shop-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            </div>
                                            <p class="text-lg font-bold text-shop-gray-900">Aucune commande trouvée</p>
                                            <p class="text-sm text-shop-gray-500 mt-1">Vos futures commandes apparaîtront ici.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/30">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
