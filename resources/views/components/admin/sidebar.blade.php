{{-- Admin Sidebar Component --}}
<aside class="w-64 min-h-screen bg-gray-800 text-white fixed left-0 top-0 z-40 transform lg:translate-x-0 transition-transform duration-300 ease-in-out"
       x-data="{ open: false }" 
       x-on:toggle-sidebar.window="open = !open"
       :class="open ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
    
    {{-- Overlay for mobile --}}
    <div x-show="open" 
         @click="open = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-600 bg-opacity-75 lg:hidden z-30"></div>
    
    <div class="flex flex-col h-full">
        {{-- Header --}}
        <div class="p-4 border-b border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold">Admin Panel</h2>
                <button @click="open = false" 
                        class="lg:hidden p-1 rounded-md hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            @php
            $navItems = [
                [
                    'route' => 'admin.dashboard',
                    'routePattern' => 'admin.dashboard',
                    'label' => 'Dashboard',
                    'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z'
                ],
                [
                    'route' => 'admin.users',
                    'routePattern' => 'admin.users*',
                    'label' => 'Utilisateurs',
                    'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'
                ],
                [
                    'route' => 'admin.products',
                    'routePattern' => 'admin.products*',
                    'label' => 'Produits',
                    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'
                ],
                [
                    'route' => 'admin.orders',
                    'routePattern' => 'admin.orders*',
                    'label' => 'Commandes',
                    'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'
                ],
                [
                    'route' => 'admin.reviews',
                    'routePattern' => 'admin.reviews*',
                    'label' => 'Avis',
                    'icon' => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z',
                    'badge' => true
                ],
                [
                    'route' => 'admin.statistics',
                    'routePattern' => 'admin.statistics',
                    'label' => 'Statistiques',
                    'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
                ]
            ];
            @endphp

            @foreach($navItems as $item)
                <a href="{{ route($item['route']) }}" 
                   @click="$dispatch('close-mobile-menu')"
                   class="flex items-center px-3 py-3 rounded-lg hover:bg-gray-700 transition-all duration-200
                          {{ request()->routeIs($item['routePattern']) ? 'bg-gray-700 border-r-2 border-blue-400' : '' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="font-medium">{{ $item['label'] }}</span>
                    @if(isset($item['badge']) && $item['badge'] && isset($pendingReviews) && $pendingReviews > 0)
                        <span class="ml-auto bg-red-500 text-xs px-2 py-1 rounded-full min-w-5 h-5 flex items-center justify-center font-semibold">
                            {{ $pendingReviews > 99 ? '99+' : $pendingReviews }}
                        </span>
                    @endif
                </a>
            @endforeach
        </nav>
        
        {{-- Footer Section --}}
        <div class="px-4 py-4 border-t border-gray-700 mt-auto">
            <div class="space-y-2">
                {{-- Settings --}}
                <a href="{{ route('profile.edit') }}" 
                   @click="$dispatch('close-mobile-menu')"
                   class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium">Paramètres</span>
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-3 py-2 rounded-lg hover:bg-gray-700 transition-colors text-red-400 hover:text-red-300">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>