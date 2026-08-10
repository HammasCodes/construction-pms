@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-black/15 focus:border-black focus:ring-brand-500 rounded-xl shadow-sm']) }}>
