@php
    $products = $products ?? collect();
    $categories = $categories ?? collect();
    $hasPaginator = $products instanceof \Illuminate\Contracts\Pagination\Paginator
        || $products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    $items = $hasPaginator ? $products : collect($products);
@endphp

<div class="bg-white rounded-3xl shadow-soft border border-shop-gray-100 overflow-hidden">
    <!-- Header & Filters -->
    <div class="p-6 border-b border-shop-gray-100 bg-shop-gray-50/30">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h5 class="text-xl font-bold text-shop-gray-900 font-display">Gestion Produits</h5>
                <p class="text-sm text-shop-gray-500">Gérez votre catalogue et vos stocks.</p>
            </div>
            <div class="flex gap-2">
                <button class="p-2 text-shop-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-colors" title="Actualiser">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </button>
            </div>
        </div>
        
        <form method="GET" action="{{ route('seller.stock') }}" class="grid gap-4 grid-cols-1 md:grid-cols-4 lg:grid-cols-12 items-end">
            <!-- Search -->
            <div class="md:col-span-2 lg:col-span-4">
                <label class="block text-xs font-bold text-shop-gray-500 mb-1 ml-1">RECHERCHE</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, SKU..." 
                           class="w-full rounded-xl border-shop-gray-200 bg-white text-sm focus:border-brand-500 focus:ring-brand-500 pl-10 shadow-sm py-2.5">
                    <svg class="w-5 h-5 text-shop-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            
            <!-- Category Filter -->
            <div class="lg:col-span-3">
                 <label class="block text-xs font-bold text-shop-gray-500 mb-1 ml-1">CATÉGORIE</label>
                <div class="relative">
                    <select name="category_id" class="w-full rounded-xl border-shop-gray-200 bg-white text-sm focus:border-brand-500 focus:ring-brand-500 py-2.5 appearance-none pl-3 pr-10 shadow-sm">
                        <option value="">Toutes les catégories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                     <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-shop-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="lg:col-span-2">
                 <label class="block text-xs font-bold text-shop-gray-500 mb-1 ml-1">STATUT</label>
                <div class="relative">
                    <select name="status" class="w-full rounded-xl border-shop-gray-200 bg-white text-sm focus:border-brand-500 focus:ring-brand-500 py-2.5 appearance-none pl-3 pr-10 shadow-sm">
                        <option value="">Tous</option>
                        <option value="draft" @selected(request('status') === 'draft')>Brouillon</option>
                        <option value="published" @selected(request('status') === 'published')>Publié</option>
                        <option value="archived" @selected(request('status') === 'archived')>Archivé</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-shop-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </div>
                </div>
            </div>
            
            <!-- Toggle & Button -->
            <div class="lg:col-span-3 flex items-center gap-3">
                 <label class="inline-flex items-center cursor-pointer h-full bg-white px-3 py-2.5 rounded-xl border border-shop-gray-200 shadow-sm hover:bg-shop-gray-50 transition-colors w-full justify-center">
                    <input type="checkbox" name="low_stock" value="1" class="sr-only peer" @checked(request('low_stock'))>
                    <div class="relative w-9 h-5 bg-shop-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-brand-600"></div>
                    <span class="ms-2 text-sm font-medium text-shop-gray-700">Stock Bas</span>
                </label>
                
                <button class="bg-brand-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-brand-700 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 rounded-xl flex-shrink-0" type="submit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-shop-gray-100">
            <thead class="bg-shop-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Produit</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Prix</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Stock</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Statut</th>
                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-shop-gray-500 uppercase tracking-wider font-display">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-shop-gray-100">
                @forelse ($items as $product)
                    <tr class="hover:bg-shop-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    @php
                                        $image = $product->primary_image;
                                    @endphp
                                    @if ($image)
                                        <img class="h-10 w-10 rounded-lg object-cover border border-shop-gray-200 shadow-sm group-hover:scale-110 transition-transform duration-300" src="{{ $image }}" alt="{{ $product->name }}">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-shop-gray-100 flex items-center justify-center text-shop-gray-400 border border-shop-gray-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-shop-gray-900 group-hover:text-brand-600 transition-colors">{{ $product->name }}</div>
                                    <div class="text-xs text-shop-gray-500">{{ $product->category?->name ?? 'Non classé' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-shop-gray-900">{{ number_format($product->price, 2) }} MAD</div>
                            @if($product->compare_at_price)
                                <div class="text-xs text-shop-gray-400 line-through">{{ number_format($product->compare_at_price, 2) }} MAD</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('seller.products.adjustStock', $product) }}" class="flex items-center gap-2 group/stock">
                                @csrf
                                @method('PATCH')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold {{ $product->stock_quantity <= 5 ? 'bg-red-100 text-red-800 animate-pulse' : 'bg-green-100 text-green-800' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                                <div class="flex items-center opacity-0 group-hover/stock:opacity-100 transition-opacity bg-white border border-shop-gray-200 rounded p-0.5 shadow-sm">
                                    <input type="number" name="delta" class="w-10 h-6 px-1 text-xs border-0 focus:ring-0 p-0 text-center" placeholder="+/-">
                                    <button type="submit" class="w-6 h-6 flex items-center justify-center text-brand-600 hover:bg-brand-50 rounded">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'draft' => 'bg-gray-100 text-gray-700 border-gray-200',
                                    'published' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                    'archived' => 'bg-amber-100 text-amber-700 border-amber-200',
                                ];
                                $statusLabels = [
                                    'draft' => 'Brouillon',
                                    'published' => 'Publié',
                                    'archived' => 'Archivé',
                                ];
                                $dots = [
                                    'draft' => 'bg-gray-500',
                                    'published' => 'bg-emerald-500',
                                    'archived' => 'bg-amber-500',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusClasses[$product->status] ?? 'bg-gray-100 text-gray-800' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dots[$product->status] ?? 'bg-gray-500' }} mr-1.5"></span>
                                {{ $statusLabels[$product->status] ?? ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('seller.products.edit', $product) }}" class="p-2 text-shop-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-all" title="Modifier">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form method="POST" action="{{ route('seller.products.destroy', $product) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-shop-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-shop-gray-500 bg-shop-gray-50/20">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-shop-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-shop-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <h3 class="text-lg font-bold text-shop-gray-900 mb-1">Aucun produit trouvé</h3>
                                <p class="text-sm text-shop-gray-500 mb-6 max-w-xs">Essayez de modifier vos filtres ou ajoutez votre premier produit pour commencer.</p>
                                <a href="{{ route('seller.products.create') }}" class="px-6 py-3 bg-brand-600 text-white rounded-xl font-bold hover:bg-brand-700 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                                    Ajouter un produit
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if ($hasPaginator && $products->hasPages())
        <div class="px-6 py-4 border-t border-shop-gray-100 bg-shop-gray-50/30">
            {{ $products->links() }}
        </div>
    @endif
</div>
