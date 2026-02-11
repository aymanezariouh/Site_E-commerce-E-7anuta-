@props(['type' => 'button', 'color' => 'blue', 'size' => 'md', 'href' => null, 'icon' => null, 'confirm' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1 transform active:scale-95';
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
        default => 'px-4 py-2 text-sm'
    };
    $colorMap = [
        'blue' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30',
        'brand' => 'bg-brand-600 hover:bg-brand-700 text-white focus:ring-brand-500 shadow-md shadow-brand-500/20 hover:shadow-lg hover:shadow-brand-500/30',
        'green' => 'bg-emerald-600 hover:bg-emerald-700 text-white focus:ring-emerald-500 shadow-md shadow-emerald-500/20 hover:shadow-lg hover:shadow-emerald-500/30',
        'red' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500 shadow-md shadow-red-500/20 hover:shadow-lg hover:shadow-red-500/30',
        'yellow' => 'bg-amber-500 hover:bg-amber-600 text-white focus:ring-amber-500 shadow-md shadow-amber-500/20 hover:shadow-lg hover:shadow-amber-500/30',
        'gray' => 'bg-shop-gray-600 hover:bg-shop-gray-700 text-white focus:ring-shop-gray-500 shadow-md shadow-shop-gray-500/20 hover:shadow-lg hover:shadow-shop-gray-500/30',
        'indigo' => 'bg-indigo-600 hover:bg-indigo-700 text-white focus:ring-indigo-500 shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30',

        'blue-outline' => 'border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
        'brand-outline' => 'border border-brand-600 text-brand-600 hover:bg-brand-50 focus:ring-brand-500',
        'green-outline' => 'border border-emerald-600 text-emerald-600 hover:bg-emerald-50 focus:ring-emerald-500',
        'red-outline' => 'border border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
        'gray-outline' => 'border border-shop-gray-300 text-shop-gray-700 hover:bg-shop-gray-50 focus:ring-shop-gray-500',

        'blue-ghost' => 'text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
        'brand-ghost' => 'text-brand-600 hover:bg-brand-50 focus:ring-brand-500',
        'green-ghost' => 'text-emerald-600 hover:bg-emerald-50 focus:ring-emerald-500',
        'red-ghost' => 'text-red-600 hover:bg-red-50 focus:ring-red-500',
        'gray-ghost' => 'text-shop-gray-600 hover:bg-shop-gray-100 focus:ring-shop-gray-500',
    ];
    $colorClasses = $colorMap[$color] ?? $colorMap['blue'];
    $iconPaths = [
        'edit' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
        'delete' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
        'view' => ['M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
        'plus' => 'M12 4v16m8-8H4',
        'download' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4',
        'check' => 'M5 13l4 4L19 7',
        'x' => 'M6 18L18 6M6 6l12 12'
    ];

    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . $colorClasses;
@endphp

@php
    $renderIcon = function($iconName, $iconPaths, $hasContent = false) {
        if (!$iconName || !isset($iconPaths[$iconName])) return '';

        $paths = is_array($iconPaths[$iconName]) ? $iconPaths[$iconName] : [$iconPaths[$iconName]];
        $pathElements = '';
        foreach ($paths as $path) {
            $pathElements .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="' . $path . '" />';
        }

        return '<svg class="w-4 h-4 ' . ($hasContent ? 'mr-2' : '') . '" fill="none" stroke="currentColor" viewBox="0 0 24 24">' . $pathElements . '</svg>';
    };
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}" {{ $attributes }}>
        @if($icon)
            {!! $renderIcon($icon, $iconPaths, !$slot->isEmpty()) !!}
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        class="{{ $classes }}"
        @if($confirm) onclick="return confirm('{{ $confirm }}')" @endif
        {{ $attributes }}>
        @if($icon)
            {!! $renderIcon($icon, $iconPaths, !$slot->isEmpty()) !!}
        @endif
        {{ $slot }}
    </button>
@endif