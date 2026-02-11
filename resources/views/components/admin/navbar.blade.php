{{-- Admin Navbar Component --}}
<nav class="bg-white/80 backdrop-blur-md shadow-soft border-b border-shop-gray-200 fixed top-0 left-0 right-0 z-50 lg:left-64 h-20 transition-all duration-300">
    <div class="px-4 lg:px-8 py-0 h-full">
        <div class="flex items-center justify-between h-full">
            {{-- Left side - Page title --}}
            <div class="flex items-center">
                <button class="lg:hidden p-2 rounded-xl text-shop-gray-500 hover:bg-shop-gray-100 hover:text-shop-gray-900 mr-4 transition-all" 
                        x-data x-on:click="$dispatch('toggle-sidebar')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                @if(isset($title))
                    <h1 class="text-xl lg:text-2xl font-bold text-shop-gray-900 font-display tracking-tight">{{ $title }}</h1>
                @endif
            </div>

            {{-- Right side - User menu --}}
            <div class="flex items-center space-x-3 sm:space-x-6">
                {{-- Notifications --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 relative transition-colors group" 
                            title="Notifications">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(isset($notificationCount) && $notificationCount > 0)
                            <span class="absolute top-1.5 right-1.5 bg-red-500 text-white text-[10px] rounded-full w-4 h-4 flex items-center justify-center font-bold border-2 border-white">{{ $notificationCount > 9 ? '9+' : $notificationCount }}</span>
                        @endif
                    </button>
                    <div x-show="open" 
                         @click.outside="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-80 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-200 ring-1 ring-black ring-opacity-5"
                         style="display: none;">
                        <div class="px-4 pb-2 text-sm font-semibold text-gray-700">Notifications</div>
                        <div class="max-h-80 overflow-auto">
                            @if(isset($adminNotifications) && $adminNotifications->count() > 0)
                                @foreach($adminNotifications as $notification)
                                    @php
                                        $data = $notification->data ?? [];
                                        $message = $data['message'] ?? 'Nouvelle notification';
                                        $url = $data['url'] ?? null;
                                    @endphp
                                    @if($url)
                                        <a href="{{ $url }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                            <div class="flex items-start gap-2">
                                                <span class="mt-1 h-2 w-2 rounded-full {{ $notification->read_at ? 'bg-gray-300' : 'bg-blue-500' }}"></span>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $message }}</div>
                                                    <div class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <div class="px-4 py-3 text-sm text-gray-700">
                                            <div class="flex items-start gap-2">
                                                <span class="mt-1 h-2 w-2 rounded-full {{ $notification->read_at ? 'bg-gray-300' : 'bg-blue-500' }}"></span>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $message }}</div>
                                                    <div class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="px-4 py-6 text-sm text-gray-500 text-center">Aucune notification</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 p-1.5 pr-3 rounded-full hover:bg-shop-gray-50 border border-transparent hover:border-shop-gray-200 transition-all duration-200 focus:outline-none">
                        {{-- User Avatar --}}
                        <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-700 rounded-full flex items-center justify-center shadow-md ring-2 ring-white">
                            <span class="text-white text-sm font-bold font-display">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        
                        {{-- User Info --}}
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-bold text-shop-gray-900 leading-none">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-[10px] font-semibold text-shop-gray-500 uppercase tracking-wider mt-0.5">
                                @if(Auth::user()->hasRole('admin'))
                                    Administrateur
                                @elseif(Auth::user()->hasRole('moderator')) 
                                    Modérateur
                                @elseif(Auth::user()->hasRole('seller'))
                                    Vendeur
                                @else
                                    Utilisateur
                                @endif
                            </p>
                        </div>
                        
                        {{-- Dropdown Arrow --}}
                        <svg class="w-4 h-4 text-shop-gray-400 transition-transform duration-200 hidden sm:block" 
                             :class="open ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown menu --}}
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translateY-2"
                         x-transition:enter-end="opacity-100 translateY-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translateY-0"
                         x-transition:leave-end="opacity-0 translateY-2"
                         class="absolute right-0 mt-3 w-60 bg-white rounded-2xl shadow-xl py-2 z-50 border border-shop-gray-100 ring-1 ring-black ring-opacity-5"
                         style="display: none;">
                        
                        <div class="px-4 py-3 border-b border-shop-gray-100 mb-1">
                            <p class="text-sm text-shop-gray-500">Connecté en tant que</p>
                            <p class="text-sm font-bold text-shop-gray-900 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        @php
                        $menuItems = [
                            [
                                'type' => 'link',
                                'route' => 'profile.edit',
                                'label' => 'Mon Profil',
                                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                'classes' => 'text-shop-gray-700 hover:bg-shop-gray-50 hover:text-brand-600'
                            ],
                            [
                                'type' => 'link',
                                'route' => 'admin.dashboard',
                                'label' => 'Tableau de bord',
                                'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z',
                                'classes' => 'text-shop-gray-700 hover:bg-shop-gray-50 hover:text-brand-600'
                            ],
                            [
                                'type' => 'divider'
                            ],
                            [
                                'type' => 'form',
                                'action' => 'logout',
                                'method' => 'POST',
                                'label' => 'Déconnexion',
                                'icon' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
                                'classes' => 'text-red-600 hover:bg-red-50'
                            ]
                        ];
                        @endphp

                        @foreach($menuItems as $item)
                            @if($item['type'] === 'divider')
                                <hr class="my-1 border-shop-gray-100">
                            @elseif($item['type'] === 'link')
                                <a href="{{ route($item['route']) }}" 
                                   class="flex items-center px-4 py-2.5 text-sm font-medium {{ $item['classes'] }} transition-colors duration-150 mx-1 rounded-xl">
                                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                    </svg>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @elseif($item['type'] === 'form')
                                <form method="{{ $item['method'] }}" action="{{ route($item['action']) }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left flex items-center px-4 py-2.5 text-sm font-medium {{ $item['classes'] }} transition-colors duration-150 mx-1 rounded-xl">
                                        <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                        </svg>
                                        <span>{{ $item['label'] }}</span>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- Spacer for fixed navbar --}}
<div class="h-20 lg:ml-64"></div>