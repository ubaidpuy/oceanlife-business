@props(['label', 'value', 'icon' => '', 'color' => 'primary'])

@php
    $styles = match($color) {
        'secondary', 'ocean-secondary' => ['bg' => 'bg-ocean-secondary/10', 'text' => 'text-ocean-secondary'],
        'yellow', 'yellow-500' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600'],
        'dark', 'ocean-dark' => ['bg' => 'bg-ocean-dark/10', 'text' => 'text-ocean-dark'],
        default => ['bg' => 'bg-ocean-primary/10', 'text' => 'text-ocean-primary'],
    };
@endphp

<div class="card p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="mt-1 text-3xl font-bold text-gray-900">{{ $value }}</p>
        </div>
        @if($icon)
            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $styles['bg'] }}">
                <svg class="h-6 w-6 {{ $styles['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                </svg>
            </div>
        @else
            <div class="flex h-12 w-12 items-center justify-center rounded-xl {{ $styles['bg'] }}">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>
