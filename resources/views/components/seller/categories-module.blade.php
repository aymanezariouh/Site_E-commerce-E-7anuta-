@php
    $categories = $categories ?? collect();
@endphp

<div class="bg-gradient-to-br from-white to-shop-gray-50/50 rounded-3xl shadow-soft border border-shop-gray-100 overflow-hidden flex flex-col h-full">
    <div class="p-6 border-b border-shop-gray-100 flex items-center justify-between">
        <div>
            <h5 class="text-lg font-bold text-shop-gray-900 font-display">Catégories</h5>
            <p class="text-sm text-shop-gray-500">Structure de la boutique</p>
        </div>
        <a href="{{ route('seller.categories.create') }}" class="p-2 bg-white text-brand-600 hover:bg-brand-600 hover:text-white border border-shop-gray-200 hover:border-brand-600 rounded-xl transition-all shadow-sm hover:shadow-md" title="Nouvelle Catégorie">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </a>
    </div>
    
    <div class="flex-1 overflow-y-auto custom-scrollbar p-2">
        @if($categories->count() > 0)
            <div class="space-y-2">
                @foreach ($categories as $category)
                    <div class="group flex items-center justify-between p-3 rounded-xl hover:bg-white border border-transparent hover:border-shop-gray-100 hover:shadow-sm transition-all duration-200">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <div class="w-8 h-8 rounded-lg bg-shop-gray-100 flex items-center justify-center text-shop-gray-400 font-bold text-xs group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                                {{ strtoupper(substr($category->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-shop-gray-700 group-hover:text-shop-gray-900 truncate transition-colors">{{ $category->name }}</p>
                                <p class="text-xs text-shop-gray-400 group-hover:text-shop-gray-500">
                                    {{ $category->products_count ?? 0 }} produits
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('seller.categories.edit', $category) }}" class="p-1.5 text-shop-gray-400 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-40 text-center">
                <div class="w-12 h-12 bg-shop-gray-50 rounded-full flex items-center justify-center text-shop-gray-300 mb-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <p class="text-sm font-medium text-shop-gray-400">Aucune catégorie</p>
            </div>
        @endif
    </div>
    
    @if($categories->count() > 5)
        <div class="p-3 bg-shop-gray-50/50 border-t border-shop-gray-100 text-center">
            <a href="{{ route('seller.categories.index') }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 transition-colors uppercase tracking-wide">
                Voir toutes
            </a>
        </div>
    @endif
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #e2e8f0;
        border-radius: 20px;
    }
</style>
