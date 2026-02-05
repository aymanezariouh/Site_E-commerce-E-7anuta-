@php
    $products = $products ?? collect();
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
        <div class="mb-3 flex flex-wrap gap-2 text-xs">
            <span class="rounded-full border border-slate-200 bg-white px-2 py-1">Categorie</span>
            <span class="rounded-full border border-slate-200 bg-white px-2 py-1">Stock bas</span>
            <span class="rounded-full border border-slate-200 bg-white px-2 py-1">Prix</span>
            <span class="rounded-full border border-slate-200 bg-white px-2 py-1">Statut</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-3 py-2 font-semibold">Image</th>
                        <th class="text-left px-3 py-2 font-semibold">Nom</th>
                        <th class="text-left px-3 py-2 font-semibold">Categorie</th>
                        <th class="text-left px-3 py-2 font-semibold">Prix</th>
                        <th class="text-left px-3 py-2 font-semibold">Stock</th>
                        <th class="text-left px-3 py-2 font-semibold">Statut</th>
                        <th class="text-left px-3 py-2 font-semibold">Cree</th>
                        <th class="text-left px-3 py-2 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    @forelse ($products as $product)
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
                            <td class="px-3 py-3">{{ number_format($product->price, 2) }} €</td>
                            <td class="px-3 py-3">
                                <span class="{{ $product->stock_quantity <= 5 ? 'text-rose-600 font-semibold' : '' }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td class="px-3 py-3">
                                <span class="rounded-full px-2 py-1 text-xs {{ $product->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $product->is_active ? 'Actif' : 'Inactif' }}
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
        <div class="mt-3 flex flex-wrap gap-2">
            <a class="rounded-lg bg-teal-600 px-3 py-1.5 text-sm text-white hover:bg-teal-700" href="{{ route('seller.products.create') }}">Creer</a>
            <a class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-50" href="{{ route('seller.categories.index') }}">Gerer categories</a>
        </div>
    </div>
</div>
