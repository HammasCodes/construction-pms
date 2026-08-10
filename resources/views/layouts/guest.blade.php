<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-black antialiased">
        <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-black px-4 py-10">
            {{-- lime glow + grid backdrop --}}
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute inset-0 bg-grid-lime bg-[length:28px_28px] opacity-30"></div>
                <div class="absolute -top-24 right-0 h-72 w-72 rounded-full bg-brand-500/20 blur-3xl"></div>
                <div class="absolute -bottom-24 left-0 h-72 w-72 rounded-full bg-brand-500/10 blur-3xl"></div>
            </div>

            <div class="relative mb-6 flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-500 text-lg font-black text-black shadow-glow">C</div>
                <div class="leading-tight">
                    <p class="text-lg font-bold text-white">ConstructPMS</p>
                    <p class="text-xs text-brand-500">Project Control Suite</p>
                </div>
            </div>

            <div class="relative w-full overflow-hidden rounded-2xl border border-white/10 bg-white px-6 py-6 shadow-lift sm:max-w-md">
                <div class="absolute inset-x-0 top-0 h-1 bg-brand-500"></div>
                {{ $slot }}
            </div>

            <p class="relative mt-6 text-xs text-white/40">© {{ date('Y') }} ConstructPMS</p>
        </div>
    </body>
</html>
