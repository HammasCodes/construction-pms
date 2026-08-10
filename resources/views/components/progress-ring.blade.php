@props([
    'value' => 0,
    'size' => 92,
    'stroke' => 9,
    'from' => '#aeff00',
    'to' => '#aeff00',
    'track' => '#ececec',
    'label' => null,
    'textClass' => 'text-black',
])

@php
    $pct = max(0, min(100, (float) $value));
    $r = ($size - $stroke) / 2;
    $c = 2 * M_PI * $r;
    $offset = $c * (1 - $pct / 100);
    $gid = 'ring-'.uniqid();
@endphp

<div class="relative inline-flex items-center justify-center" style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}" class="-rotate-90">
        <defs>
            <linearGradient id="{{ $gid }}" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="{{ $from }}"/>
                <stop offset="100%" stop-color="{{ $to }}"/>
            </linearGradient>
        </defs>
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $r }}" fill="none" stroke="{{ $track }}" stroke-width="{{ $stroke }}"/>
        <circle cx="{{ $size / 2 }}" cy="{{ $size / 2 }}" r="{{ $r }}" fill="none"
                stroke="url(#{{ $gid }})" stroke-width="{{ $stroke }}" stroke-linecap="round"
                stroke-dasharray="{{ $c }}" stroke-dashoffset="{{ $c }}"
                x-data
                x-init="$nextTick(() => { $el.style.transition = 'stroke-dashoffset 1.3s cubic-bezier(0.22,1,0.36,1)'; requestAnimationFrame(() => $el.style.strokeDashoffset = '{{ $offset }}'); })"/>
    </svg>
    <div class="absolute inset-0 flex flex-col items-center justify-center">
        <span class="text-lg font-extrabold {{ $textClass }}">{{ round($pct) }}%</span>
        @if ($label)
            <span class="mt-0.5 text-[10px] font-medium uppercase tracking-wide {{ $textClass }} opacity-60">{{ $label }}</span>
        @endif
    </div>
</div>
