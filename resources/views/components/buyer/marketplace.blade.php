<section class="dash-card p-5">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h5 class="dash-title text-lg text-slate-800">Marketplace</h5>
            <p class="text-sm text-slate-500">Decouvrez des produits tendances et utiles.</p>
        </div>
        <div class="flex flex-wrap gap-2 text-xs">
            <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-600 hover:bg-slate-50">Tout</button>
            <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-600 hover:bg-slate-50">Nouveautes</button>
            <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-600 hover:bg-slate-50">Top ventes</button>
            <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-600 hover:bg-slate-50">Promos</button>
        </div>
    </div>

    @php
        $defaultProducts = [
            ['name' => 'Casque Bluetooth', 'category' => 'Audio', 'price' => '49.00', 'badge' => 'Nouveau', 'summary' => 'Autonomie 30h, charge rapide.'],
            ['name' => 'Sac a dos urbain', 'category' => 'Mode', 'price' => '35.00', 'badge' => 'Top vente', 'summary' => 'Compartiment PC 15".'],
            ['name' => 'Montre connectee', 'category' => 'Tech', 'price' => '59.00', 'badge' => 'Promo', 'summary' => 'Suivi cardio, notifications.'],
        ];
        $list = $products ?? collect($defaultProducts);
    @endphp

    <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($list as $item)
            <article class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <h6 class="font-semibold text-slate-800">{{ $item['name'] }}</h6>
                        <p class="text-xs text-slate-500">{{ $item['category'] }}</p>
                    </div>
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">{{ $item['badge'] }}</span>
                </div>
                <div class="mt-3 h-32 rounded-lg bg-slate-100"></div>
                <p class="mt-3 text-sm text-slate-600">{{ $item['summary'] }}</p>
                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <p class="text-base font-bold text-slate-800">${{ $item['price'] }}</p>
                        <p class="text-xs text-slate-500">Livraison 24/48h</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="rounded-lg bg-teal-600 px-3 py-1 text-xs text-white hover:bg-teal-700">Ajouter</button>
                        <button class="rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs text-slate-600 hover:bg-slate-50">Voir</button>
                    </div>
                </div>
            </article>
        @endforeach
    </div>

    @if (method_exists($list, 'links'))
        <div class="mt-6">
            {{ $list->links() }}
        </div>
    @endif

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm">
        <p class="text-slate-500">Besoin de plus de choix ?</p>
        <div class="flex gap-2">
            <button class="rounded-lg border border-slate-200 bg-white px-3 py-1 text-slate-600 hover:bg-slate-50">Voir tous</button>
            <button class="rounded-lg bg-teal-600 px-3 py-1 text-white hover:bg-teal-700">Filtrer</button>
        </div>
    </div>
</section>
