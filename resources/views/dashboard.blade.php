<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-8">
                <section class="dash-card px-6 py-5 sm:px-8">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-sm text-slate-500">Bienvenue,</p>
                            <h3 class="dash-title text-2xl text-slate-800">{{ Auth::user()->name }}</h3>
                            <p class="mt-1 text-sm text-slate-600">
                                Votre espace regroupe les achats, les ventes et les activites recentes.
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @role('buyer')
                                <span class="dash-pill">Client actif</span>
                            @endrole
                            @role('seller')
                                <span class="dash-pill">Vendeur</span>
                            @endrole
                            @role('moderator')
                                <span class="dash-pill">Moderateur</span>
                            @endrole
                        </div>
                    </div>
                    <div class="mt-5 dash-divider"></div>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Commandes recentes</p>
                            <p class="text-lg font-semibold text-slate-800">12</p>
                        </div>
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Articles en panier</p>
                            <p class="text-lg font-semibold text-slate-800">3</p>
                        </div>
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Avis recueillis</p>
                            <p class="text-lg font-semibold text-slate-800">24</p>
                        </div>
                        <div class="dash-card-soft p-3">
                            <p class="text-xs text-slate-500">Nouveaux messages</p>
                            <p class="text-lg font-semibold text-slate-800">2</p>
                        </div>
                    </div>
                </section>

                <div class="grid gap-8 lg:grid-cols-3">
                    <div class="space-y-8 lg:col-span-2">
                        @role('buyer')
                            <section class="space-y-6">
                                <x-buyer.marketplace />
                                <x-buyer.orders-table />
                                <x-buyer.order-details />
                                <x-buyer.cart />
                                <x-buyer.liked-products />
                                <x-buyer.reviews />
                                <x-buyer.notifications />
                            </section>
                        @endrole

                        @role('seller')
                            <section class="space-y-6">
                                <x-seller.marketplace-quick />
                                <x-seller.cart-quick />
                                <x-seller.liked-products-quick />
                            </section>
                        @endrole

                        @role('seller')
                            <section class="space-y-6">
                                <x-seller.summary-cards />
                                <x-seller.products-module />
                                <x-seller.stock-alerts />
                                <x-seller.orders-module />
                                <x-seller.order-details />
                                <x-seller.reviews />
                                <x-seller.notifications />
                                <x-seller.analytics />
                            </section>
                        @endrole
                    </div>

                    <aside class="space-y-6">
                        <div class="dash-card p-4">
                            <h4 class="dash-title text-base text-slate-800">Actions rapides</h4>
                            <p class="mt-1 text-sm text-slate-500">Accedez vite aux pages cle.</p>
                            <div class="mt-3 flex flex-wrap gap-2 text-sm">
                                <a class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50" href="{{ route('profile.edit') }}">Profil</a>
                                <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50">Commandes</button>
                                <button class="rounded-full border border-slate-200 bg-white px-3 py-1 text-slate-700 hover:bg-slate-50">Support</button>
                            </div>
                        </div>

                        <div class="dash-card p-4">
                            <h4 class="dash-title text-base text-slate-800">A propos de votre compte</h4>
                            <div class="mt-3 space-y-3 text-sm text-slate-600">
                                <div class="flex items-center justify-between">
                                    <span>Derniere connexion</span>
                                    <span class="font-medium text-slate-700">Aujourd'hui</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Statut du compte</span>
                                    <span class="font-medium text-emerald-700">Actif</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Notifications</span>
                                    <span class="font-medium text-slate-700">Activees</span>
                                </div>
                            </div>
                        </div>

                        <div class="dash-card p-4">
                            <h4 class="dash-title text-base text-slate-800">Conseils</h4>
                            <ul class="mt-3 space-y-2 text-sm text-slate-600">
                                <li>Ajoutez 3 nouveaux produits cette semaine.</li>
                                <li>Repondez aux avis pour gagner en confiance.</li>
                                <li>Verifiez votre stock avant le weekend.</li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
