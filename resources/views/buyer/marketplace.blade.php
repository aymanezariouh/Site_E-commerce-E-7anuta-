<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Marketplace</h2>
                <p class="text-sm text-slate-600 mt-1">Parcourez les produits et ajoutez au panier.</p>
            </section>

            @if (session('success'))
                <div class="dash-card bg-emerald-50 border-emerald-200 px-4 py-3">
                    <p class="text-emerald-700 text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="dash-card bg-rose-50 border-rose-200 px-4 py-3">
                    <p class="text-rose-700 text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <x-buyer.marketplace :products="$products" :categories="$categories ?? collect()" />
        </div>
    </div>
</x-app-layout>
