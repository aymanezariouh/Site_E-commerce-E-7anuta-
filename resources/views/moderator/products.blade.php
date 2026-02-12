<x-app-layout>
    <div class="py-12 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900">Moderation Produits</h2>
                    <p class="mt-1 text-shop-gray-500">Gerez et moderez le catalogue.</p>
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
                        <h5 class="text-lg font-bold text-shop-gray-900 font-display">Tous les Produits</h5>
                        <p class="text-sm text-shop-gray-500">{{ $products->total() }} produits enregistrés</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-shop-gray-100">
                        <thead class="bg-shop-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Produit</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Categorie</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Prix</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Stock</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-shop-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-shop-gray-100">
                            @forelse ($products as $product)
                                <tr class="hover:bg-shop-gray-50/50 transition-colors {{ !$product->is_active ? 'bg-red-50/30' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($product->primary_image)
                                                <img src="{{ $product->primary_image }}" alt="" class="h-10 w-10 rounded-lg object-cover mr-3 border border-shop-gray-200">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-shop-gray-100 mr-3 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-shop-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-medium text-shop-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-shop-gray-500 max-w-xs truncate">{{ \Illuminate\Support\Str::limit($product->description ?? '', 40) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-600">
                                        {{ $product->category->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-brand-600">
                                        {{ number_format($product->price, 2) }} MAD
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-shop-gray-600">
                                        {{ $product->stock_quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($product->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Suspendu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('marketplace.show', $product->id) }}" class="text-brand-600 hover:text-brand-800">Voir</a>
                                            @if($product->is_active)
                                                <form action="{{ route('moderator.products.suspend', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Suspendre ce produit ?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 ml-2">Suspendre</button>
                                                </form>
                                            @else
                                                <form action="{{ route('moderator.products.unsuspend', $product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-800 ml-2">Activer</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-shop-gray-500">
                                        Aucun produit trouvé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($products->hasPages())
                    <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/50">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
