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

<nav x-data="{ open: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 20)"
     :class="{ 'bg-white/80 backdrop-blur-md shadow-soft': scrolled, 'bg-white border-b border-shop-gray-200': !scrolled }"
     class="sticky top-0 z-50 transition-all duration-300 ease-in-out">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> <!-- Increased height for better presence -->
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                    <div class="bg-brand-600 text-white p-1.5 rounded-lg group-hover:bg-brand-700 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold font-display text-shop-gray-900 tracking-tight">E-7anuta</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-base font-medium text-shop-gray-600 hover:text-brand-600 transition-colors">
                    Dashboard
                </x-nav-link>
                @role('buyer')
                    <x-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')" class="text-base font-medium text-shop-gray-600 hover:text-brand-600 transition-colors">
                        Marketplace
                    </x-nav-link>
                    <x-nav-link :href="route('buyer.orders')" :active="request()->routeIs('buyer.orders') || request()->routeIs('buyer.orderDetails')" class="text-base font-medium text-shop-gray-600 hover:text-brand-600 transition-colors">
                        Orders
                    </x-nav-link>
                @endrole
                @role('seller')
                    <x-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')" class="text-base font-medium text-shop-gray-600 hover:text-brand-600 transition-colors">
                        Marketplace
                    </x-nav-link>
                    <div class="relative group h-full flex items-center">
                         <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 text-base font-medium text-shop-gray-600 hover:text-brand-600 focus:outline-none transition duration-150 ease-in-out">
                                    <span>Seller Hub</span>
                                    <svg class="ms-1 h-4 w-4 fill-current opacity-75" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('seller.products.index')">Products</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.products.create')">Add Product</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.categories.index')">Categories</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.orders')">Orders</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.stock')">Stock</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.reviews')">Reviews</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.analytics')">Analytics</x-dropdown-link>
                                <x-dropdown-link :href="route('seller.notifications')">Notifications</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endrole
                @role('moderator')
                    <x-nav-link :href="route('marketplace')" :active="request()->routeIs('marketplace*')" class="text-base font-medium text-shop-gray-600 hover:text-brand-600 transition-colors">
                        Marketplace
                    </x-nav-link>
                     <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 text-base font-medium text-shop-gray-600 hover:text-brand-600 focus:outline-none transition duration-150 ease-in-out">
                                    <span>Moderation</span>
                                    <svg class="ms-1 h-4 w-4 fill-current opacity-75" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('moderator.reviews')">Reviews</x-dropdown-link>
                                <x-dropdown-link :href="route('moderator.users')">Users</x-dropdown-link>
                                <x-dropdown-link :href="route('moderator.products')">Products</x-dropdown-link>
                            </x-slot>
                    </x-dropdown>
                @endrole
                @role('admin')
                    <a class="inline-flex items-center px-1 pt-1 text-base font-medium text-shop-gray-600 hover:text-brand-600 transition duration-150 ease-in-out" href="{{ route('admin.orders') }}">Manage Orders</a>
                @endrole
            </div>

            <!-- Settings Dropdown & Cart -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:gap-4">
                @if($canShop)
                    <a
                        href="{{ route('buyer.cart') }}"
                        class="relative inline-flex items-center justify-center rounded-full p-2 text-shop-gray-500 hover:bg-shop-gray-100 hover:text-brand-600 transition duration-200"
                        title="Cart"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @if ($cartCount > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-brand-600 text-[10px] font-bold text-white shadow-sm ring-2 ring-white">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <div class="h-8 w-px bg-shop-gray-200 mx-1"></div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-shop-gray-700 bg-shop-gray-50 hover:bg-shop-gray-100 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-4 w-4 text-shop-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-shop-gray-400 hover:text-shop-gray-500 hover:bg-shop-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-shop-gray-100 shadow-lg">
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
        <div class="pt-4 pb-1 border-t border-shop-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-shop-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-shop-gray-500">{{ Auth::user()->email }}</div>
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
