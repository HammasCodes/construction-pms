@props([
    'label' => '',
    'value' => 0,
    'prefix' => '',
    'suffix' => '',
    'sublabel' => null,
    'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
    'tone' => 'dark',          // 'dark' = black tile + lime icon, 'lime' = lime tile + black icon
    'valueClass' => 'text-black',
    'decimals' => 0,
])

@php
    $tile = $tone === 'lime' ? 'bg-brand-500 text-black' : 'bg-black text-brand-500';
@endphp

<div class="card card-hover group relative overflow-hidden p-5">
    <div class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full bg-brand-500 opacity-10 blur-2xl transition duration-500 group-hover:scale-125 group-hover:opacity-20"></div>
    <div class="flex items-start justify-between gap-3">
        <div class="min-w-0">
            <p class="truncate text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="mt-2 text-2xl font-extrabold tracking-tight {{ $valueClass }}">
                {{ $prefix }}<span x-data="counter({{ (float) $value }}, {{ (int) $decimals }})" x-text="display">{{ number_format((float) $value, (int) $decimals) }}</span>{{ $suffix }}
            </p>
            @if ($sublabel)
                <p class="mt-1.5 text-xs text-gray-400">{{ $sublabel }}</p>
            @endif
        </div>
        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $tile }} shadow-lg transition duration-300 group-hover:scale-110 group-hover:-rotate-3">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
        </div>
    </div>
    <div class="mt-4 h-1 w-full overflow-hidden rounded-full bg-black/5">
        <div class="h-full w-1/3 rounded-full bg-brand-500"></div>
    </div>
</div>
