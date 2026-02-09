<div class="dash-card p-4">
    <div class="flex items-center justify-between">
        <div>
            <h5 class="dash-title text-base text-slate-800">Stock et alertes</h5>
            <p class="text-xs text-slate-500">Surveillez les ruptures.</p>
        </div>
        <span class="dash-pill">Stock</span>
    </div>
    <div class="mt-4 text-sm text-slate-600">
        <p>Produits stock faible: <span class="font-semibold text-slate-800">{{ $lowStockCount ?? 0 }}</span></p>
        <p class="text-xs text-slate-500 mt-1">Seuil configurable par catégorie.</p>
    </div>
    <div class="mt-4 flex flex-wrap gap-2">
        <a class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-600 hover:bg-slate-50" href="{{ route('seller.products.index') }}">Voir produits</a>
        <a class="rounded-lg bg-teal-600 px-3 py-1.5 text-sm text-white hover:bg-teal-700" href="{{ route('seller.products.create') }}">Ajouter produit</a>
    </div>
</div>
