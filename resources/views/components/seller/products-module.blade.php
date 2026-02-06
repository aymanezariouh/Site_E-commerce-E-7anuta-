@php
    $products = $products ?? collect();
    $categories = $categories ?? collect();
    $hasPaginator = $products instanceof \Illuminate\Contracts\Pagination\Paginator
        || $products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    $items = $hasPaginator ? $products : collect($products);
@endphp

<div class="dash-card overflow-hidden">
    <div class="flex items-center justify-between border-b border-slate-200 px-4 py-3">
        <div>
            <h5 class="dash-title text-base text-slate-800">Gestion produits</h5>
            <p class="text-xs text-slate-500">Catalogue, stock et statut.</p>
        </div>
        <span class="dash-pill">Boutique</span>
    </div>
    <div class="px-4 py-3 text-sm text-slate-600">
        <form method="GET" action="{{ route('seller.stock') }}" class="mb-4 grid gap-2 md:grid-cols-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom ou SKU" class="rounded border border-slate-200 px-2 py-1 text-xs">
            <select name="category_id" class="rounded border border-slate-200 px-2 py-1 text-xs">
                <option value="">Catégorie</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="status" class="rounded border border-slate-200 px-2 py-1 text-xs">
                <option value="">Statut</option>
                <option value="draft" @selected(request('status') === 'draft')>Brouillon</option>
                <option value="published" @selected(request('status') === 'published')>Publié</option>
                <option value="archived" @selected(request('status') === 'archived')>Archivé</option>
            </select>
            <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="Prix min" class="rounded border border-slate-200 px-2 py-1 text-xs" step="0.01" min="0">
            <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="Prix max" class="rounded border border-slate-200 px-2 py-1 text-xs" step="0.01" min="0">
            <label class="flex items-center gap-2 text-xs text-slate-600">
                <input type="checkbox" name="low_stock" value="1" class="rounded border-slate-300" @checked(request('low_stock'))>
                Stock bas
            </label>
            <input type="date" name="created_from" value="{{ request('created_from') }}" class="rounded border border-slate-200 px-2 py-1 text-xs">
            <input type="date" name="created_to" value="{{ request('created_to') }}" class="rounded border border-slate-200 px-2 py-1 text-xs">
            <div class="md:col-span-2 flex gap-2">
                <button class="rounded bg-teal-600 px-2 py-1 text-xs text-white hover:bg-teal-700" type="submit">Filtrer</button>
                <a class="rounded border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50" href="{{ route('seller.stock') }}">Réinitialiser</a>
            </div>
        </form>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-3 py-2 font-semibold">Image</th>
                        <th class="text-left px-3 py-2 font-semibold">Nom</th>
                        <th class="text-left px-3 py-2 font-semibold">Catégorie</th>
                        <th class="text-left px-3 py-2 font-semibold">Prix</th>
                        <th class="text-left px-3 py-2 font-semibold">Stock</th>
                        <th class="text-left px-3 py-2 font-semibold">Statut</th>
                        <th class="text-left px-3 py-2 font-semibold">Créé</th>
                        <th class="text-left px-3 py-2 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @forelse ($items as $product)
                        <tr class="border-t border-slate-200">
                            <td class="px-3 py-3">
                                @php
                                    $image = is_array($product->images) && count($product->images) ? $product->images[0] : null;
                                @endphp
                                @if ($image)
                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ $image }}" alt="{{ $product->name }}">
                                @else
                                    <div class="h-10 w-10 rounded-md bg-slate-100"></div>
                                @endif
                            </td>
                            <td class="px-3 py-3 font-medium text-slate-800">{{ $product->name }}</td>
                            <td class="px-3 py-3">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-3 py-3">
                                <div class="flex flex-col">
                                    <span>{{ number_format($product->price, 2) }} €</span>
                                    @if($product->compare_at_price)
                                        <span class="text-xs line-through text-slate-400">{{ number_format($product->compare_at_price, 2) }} €</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <div class="flex flex-col gap-1">
                                    <span class="{{ $product->stock_quantity <= 5 ? 'text-rose-600 font-semibold' : '' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    <form method="POST" action="{{ route('seller.products.adjustStock', $product) }}" class="flex items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="delta" class="w-16 rounded border border-slate-200 px-1 py-0.5 text-xs" placeholder="+/-" required>
                                        <input type="text" name="reason" class="w-28 rounded border border-slate-200 px-1 py-0.5 text-xs" placeholder="Raison">
                                        <button class="rounded bg-slate-800 px-2 py-0.5 text-xs text-white" type="submit">OK</button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                @php
                                    $statusColors = [
                                        'draft' => 'bg-slate-100 text-slate-600',
                                        'published' => 'bg-emerald-100 text-emerald-700',
                                        'archived' => 'bg-amber-100 text-amber-700',
                                    ];
                                    $statusLabels = [
                                        'draft' => 'Brouillon',
                                        'published' => 'Publié',
                                        'archived' => 'Archivé',
                                    ];
                                @endphp
                                <span class="rounded-full px-2 py-1 text-xs {{ $statusColors[$product->status] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $statusLabels[$product->status] ?? $product->status }}
                                </span>
                            </td>
                            <td class="px-3 py-3">{{ $product->created_at?->format('d/m/Y') }}</td>
                            <td class="px-3 py-3">
                                <div class="flex flex-wrap gap-2">
                                    <a class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50" href="{{ route('seller.products.edit', $product) }}">Modifier</a>
                                    <form method="POST" action="{{ route('seller.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ce produit ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-xs text-slate-600 hover:bg-slate-50" type="submit">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-t border-slate-200">
                            <td class="px-3 py-3" colspan="8">Aucun produit pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($hasPaginator && $products->hasPages())
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
        <div class="mt-3 flex flex-wrap gap-2">
            <a class="rounded-lg bg-teal-600 px-3 py-1.5 text-sm text-white hover:bg-teal-700" href="{{ route('seller.products.create') }}">Créer</a>
            <a class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-50" href="{{ route('seller.categories.index') }}">Gérer catégories</a>
        </div>
    </div>
</div>
