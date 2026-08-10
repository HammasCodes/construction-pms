<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &middot; ConstructPMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-black">
<div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">

    {{-- Sidebar --}}
    <aside
        class="fixed inset-y-0 left-0 z-40 flex w-72 transform flex-col bg-black text-gray-300 transition-transform duration-300 ease-out lg:static lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >
        {{-- lime glow accents --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-10 top-24 h-40 w-40 rounded-full bg-brand-500/15 blur-3xl"></div>
            <div class="absolute -right-10 bottom-24 h-40 w-40 rounded-full bg-brand-500/10 blur-3xl"></div>
        </div>

        <div class="relative flex h-16 items-center gap-3 px-6">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-500 font-black text-black shadow-glow">C</div>
            <div class="leading-tight">
                <p class="text-sm font-bold text-white">ConstructPMS</p>
                <p class="text-[11px] text-brand-500">Project Control Suite</p>
            </div>
        </div>

        <nav class="relative mt-3 flex-1 space-y-1 px-4">
            <p class="px-3 pb-2 pt-3 text-[10px] font-semibold uppercase tracking-widest text-gray-500">Menu</p>
            @php
                $nav = [
                    ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => request()->routeIs('dashboard'), 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['label' => 'Projects', 'route' => 'projects.index', 'active' => request()->routeIs('projects.*'), 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['label' => 'Reports', 'route' => 'reports.index', 'active' => request()->routeIs('reports.*'), 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ];
            @endphp

            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   class="group relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition duration-200
                          {{ $item['active'] ? 'bg-brand-500 text-black shadow-glow' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0 transition group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach

            <a href="{{ route('projects.create') }}"
               class="mt-4 flex items-center justify-center gap-2 rounded-xl border border-dashed border-brand-500/40 px-3 py-2.5 text-sm font-semibold text-brand-500 transition hover:border-brand-500 hover:bg-brand-500/10">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Project
            </a>
        </nav>

        <div class="relative border-t border-white/10 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-white/5 p-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-500 text-sm font-bold text-black">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1 leading-tight">
                    <p class="truncate text-sm font-semibold text-white">{{ auth()->user()?->name }}</p>
                    <p class="truncate text-[11px] text-gray-400">{{ auth()->user()?->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Log out" class="rounded-lg p-1.5 text-gray-400 transition hover:bg-white/10 hover:text-brand-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak x-transition.opacity @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm lg:hidden"></div>

    {{-- Main --}}
    <div class="flex min-h-screen flex-1 flex-col">
        <header class="glass sticky top-0 z-20 flex h-16 items-center justify-between border-b border-black/10 px-4 lg:px-8">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="rounded-lg p-1.5 text-gray-600 transition hover:bg-black/5 lg:hidden">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-base font-bold text-black sm:text-lg">@yield('title', 'Dashboard')</h1>
                    @hasSection('subtitle')
                        <p class="text-xs text-gray-500">@yield('subtitle')</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-3">
                @yield('header-actions')
                <div class="hidden items-center gap-2 rounded-full bg-black px-3 py-1.5 text-xs font-medium text-white sm:flex">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-500 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-brand-500"></span>
                    </span>
                    Live
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-black text-sm font-bold text-brand-500 ring-1 ring-black/10">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 lg:p-8">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                     class="mb-6 flex items-center justify-between gap-3 rounded-2xl border border-brand-500 bg-brand-50 px-4 py-3 text-sm font-medium text-black shadow-soft">
                    <span class="flex items-center gap-2">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-500 text-black">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        {{ session('success') }}
                    </span>
                    <button @click="show = false" class="text-black/50 hover:text-black">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border-2 border-black bg-white px-4 py-3 text-sm text-black shadow-soft">
                    <p class="flex items-center gap-2 font-bold">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Please fix the following:
                    </p>
                    <ul class="mt-1 list-inside list-disc pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="animate-fade-in-up">
                @yield('content')
            </div>
        </main>
    </div>
</div>
</body>
</html>
