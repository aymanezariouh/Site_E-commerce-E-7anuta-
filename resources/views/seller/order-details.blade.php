<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Details commande</h2>
                <p class="text-sm text-slate-600 mt-1">Cliquez sur une commande pour afficher ses details.</p>
            </section>

            <div class="dash-card p-4">
                <h3 class="dash-title text-base text-slate-800">Liste rapide</h3>
                <div class="mt-3 space-y-2 text-sm text-slate-600">
                    <button class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-left hover:bg-slate-50">CMD-4021 · Client Marie · $86.00</button>
                    <button class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-left hover:bg-slate-50">CMD-4018 · Client Omar · $42.00</button>
                </div>
            </div>

            <x-seller.order-details />
        </div>
    </div>
</x-app-layout>
