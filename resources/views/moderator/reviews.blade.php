<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Moderation Avis</h2>
                    <p class="mt-1 text-shop-gray-500">Gerez les avis de la communauté.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="rounded-xl bg-green-50 border border-green-200 p-4 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden">
                <div class="flex items-center justify-between border-b border-shop-gray-100 px-6 py-4 bg-shop-gray-50/50">
                    <div>
                        <h5 class="text-lg font-bold text-shop-gray-900 font-display">Tous les Avis</h5>
                        <p class="text-sm text-shop-gray-500">{{ $reviews->total() }} avis enregistrés</p>
                    </div>
                </div>

                <div class="p-6 grid gap-6">
                    @forelse($reviews as $review)
                        <div class="group rounded-xl border border-shop-gray-200 p-6 hover:shadow-md hover:border-brand-200 transition-all {{ !$review->is_approved ? 'bg-red-50/30' : 'bg-white' }}">
                            <div class="flex flex-col md:flex-row gap-4 justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="h-8 w-8 rounded-full bg-shop-gray-100 flex items-center justify-center text-xs font-bold text-shop-gray-500">
                                            {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="font-semibold text-shop-gray-900">{{ $review->user->name ?? 'Utilisateur supprimé' }}</span>
                                        <span class="text-shop-gray-300">•</span>
                                        <span class="text-sm text-shop-gray-500">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                                        @if(!$review->is_approved)
                                            <span class="ml-2 px-2 py-0.5 bg-red-100 text-red-800 text-xs rounded-full font-medium">Masqué</span>
                                        @else
                                            <span class="ml-2 px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full font-medium">Visible</span>
                                        @endif
                                    </div>

                                    <div class="flex items-center mb-3">
                                        <div class="flex text-amber-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-shop-gray-500 font-medium">({{ $review->rating }}/5)</span>
                                    </div>

                                    @if($review->comment)
                                        <p class="text-shop-gray-700 mb-3 leading-relaxed">{{ $review->comment }}</p>
                                    @endif

                                    <div class="flex items-center gap-2 text-sm text-shop-gray-500 mt-4 pt-4 border-t border-shop-gray-100">
                                        <svg class="w-4 h-4 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                        <span class="font-medium text-shop-gray-700">Produit:</span>
                                        @if($review->product)
                                            <a href="{{ route('marketplace.show', $review->product_id) }}" class="text-brand-600 hover:text-brand-800 hover:underline transition-colors">
                                                {{ $review->product->name }}
                                            </a>
                                        @else
                                            <span class="text-shop-gray-400">Produit supprimé</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex md:flex-col gap-2 md:border-l md:border-shop-gray-100 md:pl-4 md:ml-4">
                                    @if($review->is_approved)
                                        <form action="{{ route('moderator.reviews.hide', $review->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full px-3 py-1.5 bg-amber-50 text-amber-600 text-sm font-medium rounded-lg hover:bg-amber-100 transition-colors border border-amber-200">
                                                Masquer
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('moderator.reviews.show', $review->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="w-full px-3 py-1.5 bg-green-50 text-green-600 text-sm font-medium rounded-lg hover:bg-green-100 transition-colors border border-green-200">
                                                Afficher
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('moderator.reviews.delete', $review->id) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full px-3 py-1.5 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition-colors border border-red-200">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-shop-gray-500">
                             <div class="w-16 h-16 bg-shop-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-shop-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </div>
                            <p class="text-base">Aucun avis à modérer.</p>
                        </div>
                    @endforelse
                </div>

                @if($reviews->hasPages())
                    <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/50">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
