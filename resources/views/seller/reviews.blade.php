<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Avis Clients</h2>
                    <p class="mt-1 text-shop-gray-500">Ecoutez ce que vos clients disent de vous.</p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-brand-50 flex items-center justify-center text-brand-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        </div>
                        <div>
                             <p class="text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Total Avis</p>
                             <p class="text-2xl font-bold text-shop-gray-900 mt-0.5">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                             <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                        </div>
                        <div>
                             <p class="text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Note Moyenne</p>
                             <p class="text-2xl font-bold text-shop-gray-900 mt-0.5">{{ number_format($stats['average_rating'], 1) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                             <p class="text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Approuvés</p>
                             <p class="text-2xl font-bold text-shop-gray-900 mt-0.5">{{ $stats['approved'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                             <p class="text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">En Attente</p>
                             <p class="text-2xl font-bold text-shop-gray-900 mt-0.5">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 overflow-hidden">
                <div class="flex items-center justify-between border-b border-shop-gray-100 px-6 py-4 bg-shop-gray-50/50">
                    <div>
                        <h5 class="text-lg font-bold text-shop-gray-900 font-display">Derniers Avis</h5>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-shop-gray-100">
                        <thead class="bg-shop-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Produit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Note</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Commentaire</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-shop-gray-100">
                            @forelse ($reviews as $review)
                                <tr class="hover:bg-shop-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($review->product && $review->product->primary_image)
                                                <img src="{{ $review->product->primary_image }}" alt="" class="h-8 w-8 rounded-lg object-cover mr-3 border border-shop-gray-200">
                                            @else
                                                <div class="h-8 w-8 rounded-lg bg-shop-gray-100 mr-3 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <span class="text-sm font-medium text-shop-gray-900 truncate max-w-[150px]" title="{{ $review->product->name ?? 'Produit supprimé' }}">
                                                {{ $review->product->name ?? 'Produit supprimé' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-600">
                                        {{ $review->user->name ?? 'Anonyme' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                             <div class="flex text-amber-400 text-sm">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <span>★</span>
                                                    @else
                                                        <span class="text-shop-gray-200">★</span>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="ml-2 text-xs text-shop-gray-500 font-medium">{{ $review->rating }}.0</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-shop-gray-600 max-w-xs truncate" title="{{ $review->comment }}">
                                        {{ $review->comment ?: 'Aucun commentaire' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-500">
                                        {{ $review->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($review->moderation_status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Approuvé
                                            </span>
                                        @elseif ($review->moderation_status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                En attente
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Rejeté
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-shop-gray-500">
                                        Aucun avis trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($reviews->hasPages())
                    <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/50">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
