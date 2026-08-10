@props([
    'segments' => [],   // [ ['value' => int, 'color' => '#hex', 'label' => 'x'], ... ]
    'size' => 190,
    'stroke' => 24,
    'centerValue' => null,
    'centerLabel' => null,
])

@php
    $r = ($size - $stroke) / 2;
    $c = 2 * M_PI * $r;
    $cx = $size / 2;
    $total = 0;
    foreach ($segments as $s) { $total += (float) ($s['value'] ?? 0); }
    $total = max($total, 0.00001);
    $accFrac = 0;
@endphp

<div class="relative inline-flex items-center justify-center animate-scale-in" style="width: {{ $size }}px; height: {{ $size }}px;">
    <svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 {{ $size }} {{ $size }}">
        <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r }}" fill="none" stroke="#eef2f7" stroke-width="{{ $stroke }}"/>
        @foreach ($segments as $seg)
            @php
                $val = (float) ($seg['value'] ?? 0);
                if ($val <= 0) { continue; }
                $frac = $val / $total;
                $len = $c * $frac;
                $rotate = -90 + 360 * $accFrac;
                $accFrac += $frac;
            @endphp
            <circle cx="{{ $cx }}" cy="{{ $cx }}" r="{{ $r }}" fill="none"
                    stroke="{{ $seg['color'] }}" stroke-width="{{ $stroke }}" stroke-linecap="round"
                    transform="rotate({{ $rotate }} {{ $cx }} {{ $cx }})"
                    stroke-dasharray="0 {{ $c }}"
                    x-data
                    x-init="$nextTick(() => { $el.style.transition = 'stroke-dasharray 1.1s cubic-bezier(0.22,1,0.36,1) {{ $loop->index * 0.12 }}s'; requestAnimationFrame(() => $el.setAttribute('stroke-dasharray', '{{ $len }} {{ $c - $len }}')); })"/>
        @endforeach
    </svg>
    <div class="absolute inset-0 flex flex-col items-center justify-center">
        @if (! is_null($centerValue))
            <span class="text-3xl font-extrabold tracking-tight text-black">{{ $centerValue }}</span>
        @endif
        @if ($centerLabel)
            <span class="text-xs font-medium uppercase tracking-wide text-gray-400">{{ $centerLabel }}</span>
        @endif
    </div>
</div>
