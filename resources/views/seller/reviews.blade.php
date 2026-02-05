<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Avis clients</h2>
                <p class="text-sm text-slate-600 mt-1">Consultez les avis sur vos produits.</p>
            </section>

            <!-- Stats Cards -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="dash-card p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Total avis</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="dash-card p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Note moyenne</p>
                    <p class="text-2xl font-bold text-amber-500 mt-1">
                        {{ number_format($stats['average_rating'], 1) }} ★
                    </p>
                </div>
                <div class="dash-card p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Approuvés</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $stats['approved'] }}</p>
                </div>
                <div class="dash-card p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wide">En attente</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['pending'] }}</p>
                </div>
            </div>

            <!-- Reviews Table -->
            <div class="dash-card overflow-hidden">
                <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
                    <div>
                        <h5 class="dash-title text-base text-slate-800">Avis sur vos produits</h5>
                        <p class="text-xs text-slate-500">Retours clients et réputation.</p>
                    </div>
                    <span class="dash-pill">{{ $reviews->total() }} avis</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="text-left px-4 py-2 font-semibold">Produit</th>
                                <th class="text-left px-4 py-2 font-semibold">Client</th>
                                <th class="text-left px-4 py-2 font-semibold">Note</th>
                                <th class="text-left px-4 py-2 font-semibold">Commentaire</th>
                                <th class="text-left px-4 py-2 font-semibold">Date</th>
                                <th class="text-left px-4 py-2 font-semibold">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-600">
                            @forelse ($reviews as $review)
                                <tr class="border-t border-slate-200">
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-slate-800">{{ $review->product->name ?? 'Produit supprimé' }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $review->user->name ?? 'Anonyme' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="text-amber-500">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    ★
                                                @else
                                                    ☆
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="text-slate-500 text-xs ml-1">({{ $review->rating }}/5)</span>
                                    </td>
                                    <td class="px-4 py-3 max-w-xs truncate">
                                        {{ $review->comment ?: '—' }}
                                    </td>
                                    <td class="px-4 py-3">{{ $review->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">
                                        @if ($review->is_approved)
                                            <span class="rounded-full px-2 py-1 text-xs bg-emerald-100 text-emerald-700">Approuvé</span>
                                        @else
                                            <span class="rounded-full px-2 py-1 text-xs bg-amber-100 text-amber-700">En attente</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-slate-200">
                                    <td class="px-4 py-3" colspan="6">Aucun avis pour le moment.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($reviews->hasPages())
                    <div class="px-4 py-3 border-t border-slate-200">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
