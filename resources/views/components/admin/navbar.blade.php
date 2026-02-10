{{-- Admin Navbar Component --}}
<nav class="bg-white shadow-sm border-b fixed top-0 left-0 right-0 z-50 lg:left-64">
    <div class="px-4 lg:px-6 py-4">
        <div class="flex items-center justify-between">
            {{-- Left side - Page title --}}
            <div class="flex items-center">
                <button class="lg:hidden p-2 rounded-md hover:bg-gray-100 mr-3 transition-colors" 
                        x-data x-on:click="$dispatch('toggle-sidebar')">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                @if(isset($title))
                    <h1 class="text-xl lg:text-2xl font-semibold text-gray-900">{{ $title }}</h1>
                @endif
            </div>

            {{-- Right side - User menu --}}
            <div class="flex items-center space-x-4">
                {{-- Notifications --}}
                <div class="relative">
                    <button class="p-2 rounded-full hover:bg-gray-100 relative transition-colors group" 
                            title="Notifications">
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if(isset($notificationCount) && $notificationCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-xs rounded-full min-w-5 h-5 px-1 flex items-center justify-center font-medium shadow-sm">{{ $notificationCount > 99 ? '99+' : $notificationCount }}</span>
                        @endif
                    </button>
                </div>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        {{-- User Avatar --}}
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                            <span class="text-white text-sm font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        
                        {{-- User Info --}}
                        <div class="text-left hidden sm:block">
                            <p class="text-sm font-medium text-gray-700 truncate max-w-32">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-gray-500 capitalize">
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
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                             :class="open ? 'rotate-180' : ''" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown menu --}}
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-lg shadow-xl py-1 z-50 border border-gray-200 ring-1 ring-black ring-opacity-5">
                        
                        @php
                        $menuItems = [
                            [
                                'type' => 'link',
                                'route' => 'profile.edit',
                                'label' => 'Profil',
                                'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                'classes' => 'text-gray-700 hover:bg-gray-100'
                            ],
                            [
                                'type' => 'link',
                                'route' => 'admin.dashboard',
                                'label' => 'Dashboard utilisateur',
                                'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z',
                                'classes' => 'text-gray-700 hover:bg-gray-100'
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
                                'classes' => 'text-red-700 hover:bg-red-50'
                            ]
                        ];
                        @endphp

                        @foreach($menuItems as $item)
                            @if($item['type'] === 'divider')
                                <hr class="my-2 border-gray-100">
                            @elseif($item['type'] === 'link')
                                <a href="{{ route($item['route']) }}" 
                                   class="flex items-center px-4 py-3 text-sm {{ $item['classes'] }} transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                                    </svg>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @elseif($item['type'] === 'form')
                                <form method="{{ $item['method'] }}" action="{{ route($item['action']) }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left flex items-center px-4 py-3 text-sm {{ $item['classes'] }} transition-colors duration-150">
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
<div class="h-16 lg:ml-64"></div>