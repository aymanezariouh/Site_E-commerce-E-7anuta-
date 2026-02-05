<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="dash-title text-2xl text-slate-800">Notifications</h2>
                        <p class="text-sm text-slate-600 mt-1">Toutes vos alertes vendeur.</p>
                    </div>
                    @if ($unreadCount > 0)
                        <form method="POST" action="{{ route('seller.notifications.markAllAsRead') }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-lg bg-teal-600 px-3 py-1.5 text-sm text-white hover:bg-teal-700">
                                Tout marquer comme lu ({{ $unreadCount }})
                            </button>
                        </form>
                    @endif
                </div>
            </section>

            @if (session('success'))
                <div class="dash-card bg-emerald-50 border-emerald-200 px-4 py-3">
                    <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="dash-card overflow-hidden">
                <div class="divide-y divide-slate-200">
                    @forelse ($notifications as $notification)
                        <div class="px-4 py-4 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                            <div class="flex items-start gap-4">
                                <!-- Icon -->
                                <div class="flex-shrink-0">
                                    @if (($notification->data['type'] ?? '') === 'new_order')
                                        <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    @elseif (($notification->data['type'] ?? '') === 'new_review')
                                        <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-slate-800">
                                        {{ $notification->data['message'] ?? 'Nouvelle notification' }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                    
                                    @if (($notification->data['type'] ?? '') === 'new_order' && isset($notification->data['order_id']))
                                        <a href="{{ route('seller.orders.show', $notification->data['order_id']) }}" 
                                           class="inline-block mt-2 text-xs text-teal-600 hover:text-teal-700">
                                            Voir la commande →
                                        </a>
                                    @elseif (($notification->data['type'] ?? '') === 'new_review')
                                        <a href="{{ route('seller.reviews') }}" 
                                           class="inline-block mt-2 text-xs text-teal-600 hover:text-teal-700">
                                            Voir les avis →
                                        </a>
                                    @endif
                                </div>

                                <!-- Actions -->
                                @if (!$notification->read_at)
                                    <form method="POST" action="{{ route('seller.notifications.markAsRead', $notification->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50">
                                            Marquer lu
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">Lu</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <p class="mt-2 text-sm text-slate-500">Aucune notification.</p>
                        </div>
                    @endforelse
                </div>

                @if ($notifications->hasPages())
                    <div class="px-4 py-3 border-t border-slate-200">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
