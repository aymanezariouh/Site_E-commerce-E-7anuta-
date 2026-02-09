@props(['title', 'value', 'icon' => null, 'type' => null, 'color' => 'blue', 'change' => null, 'trend' => null, 'url' => null])

@php
    $colorClasses = [
        'blue' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
        'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
        'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
        'purple' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-600'],
        'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-600'],
        'gray' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600'],
    ];
    
    $currentColor = $colorClasses[$color] ?? $colorClasses['blue'];
    $bgClass = $currentColor['bg'];
    $textClass = $currentColor['text'];
    
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
            // Array format: ['type' => 'increase', 'percentage' => 5.2, 'period' => 'ce mois']
            $changeData = $change;
        } else {
            // Simple numeric format: 5.2 or -2.1
            $changeData = [
                'type' => $trend === 'down' || (float)$change < 0 ? 'decrease' : 'increase',
                'percentage' => abs((float)$change),
                'period' => 'ce mois'
            ];
        }
    }
@endphp

{{-- Admin Statistics Card Component --}}
<div class="bg-white rounded-lg shadow-sm p-6 border {{ $url ? 'hover:shadow-md transition-shadow cursor-pointer' : '' }}"
     @if($url) onclick="window.location.href='{{ $url }}'" @endif>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-500 mb-1">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900">{{ $value }}</p>
            
            @if($change)
                <p class="text-xs mt-1 {{ $changeData['type'] === 'increase' ? 'text-green-600' : 'text-red-600' }}">
                    @if($changeData['type'] === 'increase')
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7" />
                        </svg>
                    @else
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10" />
                        </svg>
                    @endif
                    {{ $changeData['percentage'] }}% depuis {{ $changeData['period'] }}
                </p>
            @endif
        </div>

        <div class="flex-shrink-0 ml-4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $bgClass }}">
                <svg class="w-6 h-6 {{ $textClass }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}" />
                </svg>
            </div>
        </div>
    </div>
</div>