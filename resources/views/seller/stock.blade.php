<x-app-layout>
    <div class="py-8 bg-shop-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-fade-in-up">
                <div>
                    <h2 class="text-3xl font-bold font-display text-shop-gray-900 tracking-tight">Catalogue & Stock</h2>
                    <p class="mt-1 text-shop-gray-500 text-lg">Gérez votre inventaire avec précision.</p>
                </div>
                <a href="{{ route('seller.products.create') }}" class="px-5 py-3 bg-brand-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl hover:bg-brand-700 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Nouveau Produit
                </a>
            </div>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                     class="rounded-xl bg-emerald-50 border border-emerald-100 p-4 flex items-center gap-3 animate-fade-in-up">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-emerald-800 text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up" style="animation-delay: 100ms;">
                <!-- Left Column: Alerts & Categories -->
                <div class="space-y-8 lg:col-span-1">
                    <x-seller.stock-alerts :low-stock-count="$lowStockCount" />
                    <x-seller.categories-module :categories="$categories" />
                </div>
                
                <!-- Right Column: Products List -->
                <div class="lg:col-span-2">
                     <x-seller.products-module :products="$products" :categories="$categories" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
