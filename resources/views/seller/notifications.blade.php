<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Notifications</h2>
                    <p class="mt-1 text-shop-gray-500">Restez informé de l'activité de votre boutique.</p>
                </div>
                @if ($unreadCount > 0)
                    <form method="POST" action="{{ route('seller.notifications.markAllAsRead') }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-sm font-medium text-brand-600 hover:text-brand-700 hover:underline">
                            Tout marquer comme lu ({{ $unreadCount }})
                        </button>
                    </form>
                @endif
            </div>

            @if (session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden">
                <div class="divide-y divide-shop-gray-100">
                    @forelse ($notifications as $notification)
                        <div class="group p-6 {{ $notification->read_at ? 'bg-white' : 'bg-brand-50/30' }} hover:bg-shop-gray-50/80 transition-colors">
                            <div class="flex items-start gap-4">
                                <!-- Icon -->
                                <div class="flex-shrink-0 mt-1">
                                    @if (($notification->data['type'] ?? '') === 'new_order')
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center ring-4 ring-white">
                                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    @elseif (($notification->data['type'] ?? '') === 'new_review')
                                        <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center ring-4 ring-white">
                                            <svg class="h-5 w-5 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                            </svg>
                                        </div>
                                    @elseif (($notification->data['type'] ?? '') === 'stock_alert')
                                        <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center ring-4 ring-white">
                                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-shop-gray-100 flex items-center justify-center ring-4 ring-white">
                                            <svg class="h-5 w-5 text-shop-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <p class="text-sm font-semibold text-shop-gray-900 group-hover:text-brand-700 transition-colors">
                                            {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                                        </p>
                                        <span class="text-xs text-shop-gray-400 whitespace-nowrap ml-2">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    @if (($notification->data['type'] ?? '') === 'new_order' && isset($notification->data['order_id']))
                                        <a href="{{ route('seller.orders.show', $notification->data['order_id']) }}" 
                                           class="inline-flex items-center mt-2 text-xs font-medium text-brand-600 hover:text-brand-800 transition-colors">
                                            Voir la commande
                                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @elseif (($notification->data['type'] ?? '') === 'new_review')
                                        <a href="{{ route('seller.reviews') }}" 
                                           class="inline-flex items-center mt-2 text-xs font-medium text-brand-600 hover:text-brand-800 transition-colors">
                                            Voir les avis
                                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @elseif (($notification->data['type'] ?? '') === 'stock_alert')
                                         <a href="{{ route('seller.stock') }}" 
                                           class="inline-flex items-center mt-2 text-xs font-medium text-brand-600 hover:text-brand-800 transition-colors">
                                            Gérer le stock
                                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center self-center ml-2">
                                    @if (!$notification->read_at)
                                        <form method="POST" action="{{ route('seller.notifications.markAsRead', $notification->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="p-2 text-shop-gray-400 hover:text-brand-600 rounded-full hover:bg-brand-50 transition-colors chat-bubble" title="Marquer comme lu">
                                                <div class="w-2.5 h-2.5 bg-brand-500 rounded-full"></div>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-shop-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <h3 class="text-sm font-medium text-shop-gray-900">Tout est calme</h3>
                            <p class="mt-1 text-sm text-shop-gray-500">Vous n'avez aucune nouvelle notification.</p>
                        </div>
                    @endforelse
                </div>

                @if ($notifications->hasPages())
                    <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/50">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
