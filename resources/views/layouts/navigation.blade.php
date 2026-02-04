<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
<<<<<<< HEAD
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    
                    @role('buyer')
                        <x-nav-link :href="route('buyer.produits')" :active="request()->routeIs('buyer.produits')">
                            Products
                        </x-nav-link>
                        <x-nav-link :href="route('buyer.cart')" :active="request()->routeIs('buyer.cart')">
                            Cart
                        </x-nav-link>
                        <x-nav-link :href="route('buyer.orders')" :active="request()->routeIs('buyer.orders')">
                            My Orders
                        </x-nav-link>
=======
            <div class="flex items-center gap-6">
                <div class="hidden items-center gap-6 sm:flex">
                    <a class="text-sm font-medium text-slate-600 hover:text-slate-800" href="{{ route('marketplace') }}">Marketplace</a>
                    <a class="text-sm font-medium text-slate-600 hover:text-slate-800" href="{{ route('orders') }}">Orders</a>
                    @role('seller')
                        <a class="text-sm font-medium text-slate-600 hover:text-slate-800" href="{{ route('seller.stock') }}">Stock</a>
                        <a class="text-sm font-medium text-slate-600 hover:text-slate-800" href="{{ route('seller.order-details') }}">Order details</a>
                        <a class="text-sm font-medium text-slate-600 hover:text-slate-800" href="{{ route('seller.reviews') }}">Reviews</a>
                        <a class="text-sm font-medium text-slate-600 hover:text-slate-800" href="{{ route('seller.analytics') }}">Analytics</a>
>>>>>>> b294a07 (ajout de navbar sans avec les page du seller)
                    @endrole
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @role('seller')
                    <a
                        class="mr-2 inline-flex items-center justify-center rounded-full border border-slate-200 bg-white p-2 text-slate-600 hover:bg-slate-50"
                        href="{{ route('seller.notifications') }}"
                        aria-label="Notifications"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 8a6 6 0 10-12 0c0 7-3 7-3 7h18s-3 0-3-7"/>
                            <path d="M13.73 21a2 2 0 01-3.46 0"/>
                        </svg>
                    </a>
                @endrole
                <button
                    class="mr-3 inline-flex items-center justify-center rounded-full border border-slate-200 bg-white p-2 text-slate-600 hover:bg-slate-50"
                    @click="cartOpen = true"
                    type="button"
                    aria-label="Panier"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 6h15l-1.5 9h-12z"/>
                        <circle cx="9" cy="20" r="1.5"/>
                        <circle cx="18" cy="20" r="1.5"/>
                        <path d="M6 6L5 3H2"/>
                    </svg>
                </button>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link href="#" @click.prevent="profileOpen = true">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('marketplace')">
                Marketplace
            </x-responsive-nav-link>
<<<<<<< HEAD
            
            @role('buyer')
                <x-responsive-nav-link :href="route('buyer.produits')" :active="request()->routeIs('buyer.produits')">
                    Products
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('buyer.cart')" :active="request()->routeIs('buyer.cart')">
                    Cart
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('buyer.orders')" :active="request()->routeIs('buyer.orders')">
                    My Orders
=======
            <x-responsive-nav-link :href="route('orders')">
                Orders
            </x-responsive-nav-link>
            @role('seller')
                <x-responsive-nav-link :href="route('seller.stock')">
                    Stock
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.order-details')">
                    Order details
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.reviews')">
                    Reviews
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.analytics')">
                    Analytics
>>>>>>> b294a07 (ajout de navbar sans avec les page du seller)
                </x-responsive-nav-link>
            @endrole
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link href="#" @click.prevent="profileOpen = true; open = false">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
