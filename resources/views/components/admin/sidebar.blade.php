{{-- Admin Sidebar Component --}}
<aside class="w-64 min-h-screen bg-shop-gray-900 text-white fixed left-0 top-0 z-40 transform lg:translate-x-0 transition-transform duration-300 ease-in-out border-r border-shop-gray-800"
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
         class="fixed inset-0 bg-shop-gray-900/80 backdrop-blur-sm lg:hidden z-30"></div>
    
    <div class="flex flex-col h-full">
        {{-- Header --}}
        <div class="h-20 flex items-center px-6 border-b border-shop-gray-800 bg-shop-gray-900">
            <div class="flex items-center justify-between w-full">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                    <div class="bg-brand-600 text-white p-1.5 rounded-lg group-hover:bg-brand-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold font-display text-white tracking-tight">E-7anuta</span>
                </a>
                <button @click="open = false" 
                        class="lg:hidden p-1 rounded-md text-shop-gray-400 hover:text-white hover:bg-shop-gray-800 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        
        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
            @php
            $navItems = [
                [
                    'route' => 'admin.dashboard',
                    'routePattern' => 'admin.dashboard',
                    'label' => 'Tableau de bord',
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
                @php
                    $isActive = request()->routeIs($item['routePattern']);
                @endphp
                <a href="{{ route($item['route']) }}" 
                   @click="$dispatch('close-mobile-menu')"
                   class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group
                          {{ $isActive 
                             ? 'bg-brand-600/10 text-brand-400 font-semibold shadow-inner-light' 
                             : 'text-shop-gray-400 hover:bg-shop-gray-800 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 transition-colors {{ $isActive ? 'text-brand-400' : 'text-shop-gray-500 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                    </svg>
                    <span>{{ $item['label'] }}</span>
                    @if(isset($item['badge']) && $item['badge'] && isset($pendingReviews) && $pendingReviews > 0)
                        <span class="ml-auto bg-red-500 text-white text-[10px] px-2 py-0.5 rounded-full min-w-[1.25rem] h-5 flex items-center justify-center font-bold shadow-sm">
                            {{ $pendingReviews > 99 ? '99+' : $pendingReviews }}
                        </span>
                    @endif
                    @if($isActive)
                        <div class="ml-auto w-1.5 h-1.5 rounded-full bg-brand-400 shadow-[0_0_8px_rgba(45,212,191,0.6)]"></div>
                    @endif
                </a>
            @endforeach
        </nav>
        
        {{-- Footer Section --}}
        <div class="px-4 py-4 border-t border-shop-gray-800 mt-auto bg-shop-gray-900">
            <div class="bg-shop-gray-800/50 rounded-xl p-3 space-y-1">
                {{-- Settings --}}
                <a href="{{ route('profile.edit') }}" 
                   @click="$dispatch('close-mobile-menu')"
                   class="flex items-center px-3 py-2 rounded-lg text-shop-gray-400 hover:bg-shop-gray-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-sm">Paramètres</span>
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center px-3 py-2 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-medium text-sm">Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>