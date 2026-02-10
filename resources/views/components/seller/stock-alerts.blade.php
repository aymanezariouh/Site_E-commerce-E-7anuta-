<div class="bg-gradient-to-br from-white to-red-50/30 rounded-3xl shadow-soft border border-shop-gray-100 p-6 relative overflow-hidden">
    <!-- Decorative -->
    <div class="absolute top-0 right-0 w-24 h-24 bg-red-100 rounded-full -mr-8 -mt-8 opacity-50 blur-xl"></div>
    
    <div class="flex items-center justify-between mb-6 relative z-10">
        <div>
            <h5 class="text-lg font-bold text-shop-gray-900 font-display flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Alertes Stock
            </h5>
            <p class="text-xs text-shop-gray-500 mt-1">Nécessite votre attention immédiate</p>
        </div>
        <div class="w-10 h-10 rounded-xl bg-white border border-red-100 flex items-center justify-center text-red-500 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
    </div>
    
    <div class="flex items-end gap-3 mb-6 relative z-10">
        <span class="text-4xl font-bold text-shop-gray-900 tracking-tight">{{ $lowStockCount ?? 0 }}</span>
        <span class="text-sm font-medium text-shop-gray-500 mb-1.5">Produits en<br>faible quantité</span>
    </div>

    <div class="space-y-3 relative z-10">
        <a href="{{ route('seller.stock', ['low_stock' => 1]) }}" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-red-500/20 hover:-translate-y-0.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            Voir les produits
        </a>
         <button class="w-full px-4 py-3 bg-white border border-shop-gray-200 hover:bg-shop-gray-50 text-shop-gray-700 text-sm font-bold rounded-xl transition-colors shadow-sm">
            Configurer Seuils
        </button>
    </div>
</div>
