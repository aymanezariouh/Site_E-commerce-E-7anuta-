<div class="rounded-lg border-2 border-slate-200 bg-white p-4 shadow-sm">
    <div class="flex items-start justify-between">
        <div>
            <h5 class="text-lg font-bold text-slate-800">Espace client</h5>
            <p class="text-sm text-slate-500">Votre compte et vos commandes.</p>
        </div>
        <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">Client</span>
    </div>

    <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-3">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-500">Membre depuis</p>
                <p class="text-sm font-semibold text-slate-700">2024</p>
            </div>
        </div>
        <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
            <div class="rounded-md bg-white p-2 text-slate-700">
                <p class="text-[11px] text-slate-500">Commandes</p>
                <p class="text-base font-semibold">12</p>
            </div>
            <div class="rounded-md bg-white p-2 text-slate-700">
                <p class="text-[11px] text-slate-500">Articles likes</p>
                <p class="text-base font-semibold">5</p>
            </div>
        </div>
    </div>

    <div class="mt-4 space-y-3 text-sm">
        <div class="rounded-lg border border-slate-200 p-3">
            <div class="flex items-center justify-between">
                <h6 class="font-semibold text-slate-800">Panier</h6>
                <button class="text-xs font-medium text-emerald-700 hover:text-emerald-800">Voir panier</button>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-2 text-xs">
                <div class="rounded-md bg-slate-50 p-2 text-slate-700">
                    <p class="text-[11px] text-slate-500">Articles</p>
                    <p class="text-base font-semibold">3</p>
                </div>
                <div class="rounded-md bg-slate-50 p-2 text-slate-700">
                    <p class="text-[11px] text-slate-500">Total</p>
                    <p class="text-base font-semibold">$86.00</p>
                </div>
            </div>
            <button class="mt-2 w-full rounded-lg bg-emerald-600 px-3 py-1.5 text-xs text-white hover:bg-emerald-700">Passer commande</button>
        </div>

        @role('seller')
            <div class="rounded-lg border border-amber-200 bg-amber-50 p-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h6 class="font-semibold text-amber-800">Profil vendeur</h6>
                        <p class="text-xs text-amber-700">Boutique active et performance recente.</p>
                    </div>
                    <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">Boutique</span>
                </div>
                <div class="mt-3 grid grid-cols-2 gap-2 text-xs">
                    <div class="rounded-md bg-white p-2 text-amber-800">
                        <p class="text-[11px] text-amber-600">Produits en ligne</p>
                        <p class="text-base font-semibold">18</p>
                    </div>
                    <div class="rounded-md bg-white p-2 text-amber-800">
                        <p class="text-[11px] text-amber-600">Ventes totales</p>
                        <p class="text-base font-semibold">74</p>
                    </div>
                    <div class="rounded-md bg-white p-2 text-amber-800">
                        <p class="text-[11px] text-amber-600">CA 30j</p>
                        <p class="text-base font-semibold">$1.2k</p>
                    </div>
                    <div class="rounded-md bg-white p-2 text-amber-800">
                        <p class="text-[11px] text-amber-600">Note moyenne</p>
                        <p class="text-base font-semibold">4.7</p>
                    </div>
                </div>
                <div class="mt-3 rounded-md border border-amber-200 bg-white p-2 text-xs text-amber-800">
                    <div class="flex items-center justify-between">
                        <span>Commandes en cours</span>
                        <span class="font-semibold">6</span>
                    </div>
                    <div class="mt-1 flex items-center justify-between">
                        <span>Retours a traiter</span>
                        <span class="font-semibold">1</span>
                    </div>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    <button class="rounded-lg border border-amber-300 bg-amber-100 px-3 py-1 text-xs text-amber-800 hover:bg-amber-200">Mes produits</button>
                    <button class="rounded-lg border border-amber-300 bg-amber-100 px-3 py-1 text-xs text-amber-800 hover:bg-amber-200">Commandes</button>
                    <button class="rounded-lg border border-amber-300 bg-amber-100 px-3 py-1 text-xs text-amber-800 hover:bg-amber-200">Payouts</button>
                    <button class="rounded-lg bg-amber-600 px-3 py-1 text-xs text-white hover:bg-amber-700">Tableau vendeur</button>
                </div>
            </div>
        @endrole

        <div class="rounded-lg border border-slate-200 p-3">
            <div class="flex items-center justify-between">
                <h6 class="font-semibold text-slate-800">Dernieres commandes</h6>
                <button class="text-xs font-medium text-emerald-700 hover:text-emerald-800">Voir tout</button>
            </div>
            <div class="mt-2 space-y-2 text-xs text-slate-600">
                <div class="flex items-center justify-between rounded-md bg-slate-50 p-2">
                    <span>#CMD-4021</span>
                    <span class="font-semibold text-emerald-700">$86.00</span>
                </div>
                <div class="flex items-center justify-between rounded-md bg-slate-50 p-2">
                    <span>#CMD-4018</span>
                    <span class="font-semibold text-emerald-700">$42.00</span>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 p-3">
            <h6 class="font-semibold text-slate-800">Actions rapides</h6>
            <div class="mt-2 flex flex-wrap gap-2">
                <a class="rounded-lg border border-slate-300 bg-slate-100 px-3 py-1 text-xs text-slate-700 hover:bg-slate-200" href="{{ route('profile.edit') }}">Modifier profil</a>
                <button class="rounded-lg border border-slate-300 bg-slate-100 px-3 py-1 text-xs text-slate-700 hover:bg-slate-200">Mes adresses</button>
                <button class="rounded-lg border border-slate-300 bg-slate-100 px-3 py-1 text-xs text-slate-700 hover:bg-slate-200">Moyens de paiement</button>
                <button class="rounded-lg bg-emerald-600 px-3 py-1 text-xs text-white hover:bg-emerald-700">Support</button>
            </div>
        </div>
    </div>
</div>
