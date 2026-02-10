@props(['title', 'value', 'icon' => null, 'type' => null, 'color' => 'brand', 'change' => null, 'trend' => null, 'url' => null])

@php
    $colorClasses = [
        'brand' => ['bg' => 'bg-brand-50', 'text' => 'text-brand-600', 'ring' => 'ring-brand-100'],
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'ring' => 'ring-blue-100'],
        'green' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'ring' => 'ring-green-100'],
        'yellow' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'ring' => 'ring-amber-100'],
        'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600', 'ring' => 'ring-purple-100'],
        'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'ring' => 'ring-red-100'],
        'gray' => ['bg' => 'bg-shop-gray-50', 'text' => 'text-shop-gray-600', 'ring' => 'ring-shop-gray-100'],
    ];
    
    $currentColor = $colorClasses[$color] ?? $colorClasses['brand'];
    $bgClass = $currentColor['bg'];
    $textClass = $currentColor['text'];
    $ringClass = $currentColor['ring'];
    
    $icons = [
        'users' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
        'products' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
        'orders' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
        'revenue' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        'reviews' => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z',
        'default' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'
    ];
    
    // Use type if provided, otherwise fall back to icon
    $iconKey = $type ?? $icon ?? 'default';
    $iconPath = $icons[$iconKey] ?? $icons['default'];
    
    // Handle both array format and simple numeric format for change
    if ($change !== null) {
        if (is_array($change)) {
            $changeData = $change;
        } else {
            $changeData = [
                'type' => $trend === 'down' || (float)$change < 0 ? 'decrease' : 'increase',
                'percentage' => abs((float)$change),
                'period' => 'ce mois'
            ];
        }
    }
@endphp

{{-- Admin Statistics Card Component --}}
<div class="bg-white rounded-2xl shadow-soft border border-shop-gray-100 p-6 {{ $url ? 'hover:shadow-card hover:-translate-y-1 transition-all duration-300 cursor-pointer' : '' }}"
     @if($url) onclick="window.location.href='{{ $url }}'" @endif>
    <div class="flex items-start justify-between">
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold text-shop-gray-500 uppercase tracking-wider mb-2 font-display">{{ $title }}</p>
            <p class="text-3xl font-bold text-shop-gray-900 leading-tight">{{ $value }}</p>
            
            @if($change)
                <div class="flex items-center mt-2.5">
                    <span class="inline-flex items-center text-xs font-bold px-2 py-0.5 rounded-full {{ $changeData['type'] === 'increase' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        @if($changeData['type'] === 'increase')
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        @else
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg>
                        @endif
                        {{ $changeData['percentage'] }}%
                    </span>
                    <span class="text-xs text-shop-gray-400 ml-2">depuis {{ $changeData['period'] }}</span>
                </div>
            @endif
        </div>

        <div class="flex-shrink-0 ml-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center {{ $bgClass }} ring-4 {{ $ringClass }} shadow-inner transition-colors duration-300 group-hover:scale-110">
                <svg class="w-7 h-7 {{ $textClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}" />
                </svg>
            </div>
        </div>
    </div>
</div>