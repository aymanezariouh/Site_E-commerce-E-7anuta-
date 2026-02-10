<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-800">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">Dashboard</a>
                <a href="{{ route('moderator.reviews') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('moderator.reviews*') ? 'font-semibold' : '' }}">Reviews</a>
                <a href="{{ route('moderator.users') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('moderator.users*') ? 'font-semibold' : '' }}">Users</a>
                <a href="{{ route('moderator.products') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('moderator.products*') ? 'font-semibold' : '' }}">Products</a>
                <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-gray-900 {{ request()->routeIs('profile.edit') ? 'font-semibold' : '' }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-700 hover:text-gray-900">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
