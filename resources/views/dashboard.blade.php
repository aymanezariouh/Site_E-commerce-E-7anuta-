<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-10">
                    <div>
                        <h3 class="text-lg font-semibold">Welcome</h3>
                        <p class="text-sm text-gray-600">
                            This dashboard is shared by buyers, sellers, and moderators. Buyer features are the base.
                        </p>
                    </div>

                    @role('buyer')
                        <section class="space-y-6">
                            <h4 class="text-base font-semibold">Buyer Dashboard</h4>
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

                    <div class="text-sm text-gray-600">
                        Moderator modules will be added on top of this base.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
