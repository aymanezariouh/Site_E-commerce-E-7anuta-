<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Commandes</h2>
                <p class="text-sm text-slate-600 mt-1">Suivez vos achats et leurs détails.</p>
            </section>

            <x-buyer.orders-table :orders="$orders" />
        </div>
    </div>
</x-app-layout>
