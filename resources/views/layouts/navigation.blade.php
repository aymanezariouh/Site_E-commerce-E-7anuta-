@php
    $canShop = Auth::check() && Auth::user()->hasAnyRole(['buyer', 'seller', 'moderator']);
    $cartCount = 0;

    if ($canShop) {
        $activeCart = \App\Models\Cart::with('items:id,cart_id,quantity')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->latest('id')
            ->first();

        $cartCount = $activeCart ? (int) $activeCart->items->sum('quantity') : 0;
    }
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800">
                    E-7anuta
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-nav-link>
                @role('buyer')
                    <x-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')">
                        Marketplace
                    </x-nav-link>
                    <x-nav-link :href="route('buyer.orders')" :active="request()->routeIs('buyer.orders') || request()->routeIs('buyer.orderDetails')">
                        Orders
                    </x-nav-link>
                @endrole
                @role('seller')
                    <x-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')">
                        Marketplace
                    </x-nav-link>
                    <div class="inline-flex items-center">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    <span>Seller</span>
                                    <svg class="ms-1 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('seller.products.index')">
                                    Products
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.products.create')">
                                    Add Product
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.categories.index')">
                                    Categories
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.orders')">
                                    Orders
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.stock')">
                                    Stock
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.reviews')">
                                    Reviews
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.analytics')">
                                    Analytics
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.notifications')">
                                    Notifications
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endrole
                @role('moderator')
                    <x-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')">
                        Marketplace
                    </x-nav-link>
                    <x-nav-link :href="route('moderator.reviews')" :active="request()->routeIs('moderator.reviews*')">
                        Reviews
                    </x-nav-link>
                    <x-nav-link :href="route('moderator.users')" :active="request()->routeIs('moderator.users*')">
                        Users
                    </x-nav-link>
                    <x-nav-link :href="route('moderator.products')" :active="request()->routeIs('moderator.products*')">
                        Products
                    </x-nav-link>
                @endrole
                @role('admin')
                    <a class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out" href="{{ route('admin.orders') }}">Manage Orders</a>
                @endrole
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-3">
                @if($canShop)
                    <a
                        href="{{ route('buyer.cart') }}"
                        class="relative inline-flex items-center justify-center rounded-full border border-slate-200 p-2 text-gray-500 hover:bg-slate-50 hover:text-gray-700 transition"
                        title="Cart"
                        aria-label="Cart"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m1.6 8L5.4 5m1.6 8L9 19h6m-6 0a1 1 0 102 0m4 0a1 1 0 102 0"></path>
                        </svg>
                        @if ($cartCount > 0)
                            <span class="absolute -top-1 -right-1 rounded-full bg-emerald-600 px-1.5 py-0.5 text-[10px] font-semibold leading-none text-white">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif
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
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            >
                                {{ __('Log Out') }}
                            </button>
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
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            @role('buyer')
                <x-responsive-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')">
                    Marketplace
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('buyer.cart')" :active="request()->routeIs('buyer.cart')">
                    Cart
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('buyer.orders')" :active="request()->routeIs('buyer.orders') || request()->routeIs('buyer.orderDetails')">
                    Orders
                </x-responsive-nav-link>
            @endrole
            @role('seller')
                <x-responsive-nav-link :href="route('marketplace')">
                    Marketplace
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('buyer.cart')" :active="request()->routeIs('buyer.cart')">
                    Cart
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.products.index')">
                    Products
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.products.create')">
                    Add Product
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.categories.index')">
                    Categories
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.orders')">
                    Orders
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.stock')">
                    Stock
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.reviews')">
                    Reviews
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.analytics')">
                    Analytics
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('seller.notifications')">
                    Notifications
                </x-responsive-nav-link>
            @endrole
            @role('moderator')
                <x-responsive-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')">
                    Marketplace
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('buyer.cart')" :active="request()->routeIs('buyer.cart')">
                    Cart
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('moderator.reviews')" :active="request()->routeIs('moderator.reviews*')">
                    Reviews
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('moderator.users')" :active="request()->routeIs('moderator.users*')">
                    Users
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('moderator.products')" :active="request()->routeIs('moderator.products*')">
                    Products
                </x-responsive-nav-link>
            @endrole
            @role('admin')
                <x-responsive-nav-link :href="route('admin.orders')">
                    Manage Orders
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
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out"
                    >
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
