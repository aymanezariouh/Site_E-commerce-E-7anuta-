<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div class="hidden sm:flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">Dashboard</a>
                <a href="{{ route('marketplace') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('marketplace*') ? 'font-semibold' : '' }}">Marketplace</a>
                <a href="{{ route('orders') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('orders') ? 'font-semibold' : '' }}">Orders</a>
                @role('buyer')
                    <a href="{{ route('buyer.cart') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('buyer.cart') ? 'font-semibold' : '' }}">Cart</a>
                @endrole
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-gray-900 focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
