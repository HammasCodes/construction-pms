@extends('layouts.master')

@section('title', $project->name)
@section('subtitle', $project->client_name.($project->location ? ' · '.$project->location : ''))

@section('header-actions')
    <a href="{{ route('projects.report.pdf', $project) }}" class="btn-ghost hidden sm:inline-flex">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Export PDF
    </a>
@endsection

@section('content')
    @php
        $totalBoq = $project->totalBoqAmount();
        $totalExpenses = $project->totalExpenses();
        $variance = $project->budgetVariance();
        $usedPct = $project->budgetUsedPercentage();
        $activeTab = request('tab', 'overview');
    @endphp

    {{-- Hero header (black + lime) --}}
    <div class="relative overflow-hidden rounded-3xl bg-black p-6 text-white shadow-lift lg:p-8">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute inset-0 bg-grid-lime bg-[length:26px_26px] opacity-40"></div>
            <div class="absolute -right-12 -top-12 h-52 w-52 rounded-full bg-brand-500/20 blur-3xl"></div>
            <div class="absolute -bottom-16 left-24 h-52 w-52 rounded-full bg-brand-500/10 blur-3xl"></div>
        </div>
        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <a href="{{ route('projects.index') }}" class="mb-2 inline-flex items-center gap-1 text-sm text-white/60 transition hover:text-brand-500">← Back to projects</a>
                <div class="flex flex-wrap items-center gap-3">
                    <h2 class="text-2xl font-extrabold tracking-tight sm:text-3xl">{{ $project->name }}</h2>
                    <span class="badge bg-brand-500 text-black ring-transparent">{{ $project->statusLabel() }}</span>
                </div>
                <div class="mt-3 flex flex-wrap gap-x-6 gap-y-1 text-sm text-white/75">
                    <span class="inline-flex items-center gap-1.5"><svg class="h-4 w-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>{{ $project->client_name }}</span>
                    @if ($project->type)<span class="inline-flex items-center gap-1.5"><svg class="h-4 w-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>{{ $project->type }}</span>@endif
                    <span class="inline-flex items-center gap-1.5"><svg class="h-4 w-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ optional($project->start_date)->format('d M Y') ?: '—' }} → {{ optional($project->expected_completion_date)->format('d M Y') ?: '—' }}</span>
                </div>
            </div>
            <div class="flex items-center gap-5">
                <div class="rounded-2xl bg-white/5 p-3 ring-1 ring-white/10">
                    <x-progress-ring :value="$project->progress" :size="104" :stroke="10" from="#aeff00" to="#aeff00" track="rgba(255,255,255,0.14)" label="Overall" textClass="text-white" />
                </div>
                <a href="{{ route('projects.edit', $project) }}" class="btn-primary">Edit Project</a>
            </div>
        </div>
    </div>

    {{-- Metric cards --}}
    <div class="mt-6 grid grid-cols-1 gap-4 stagger sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total BOQ" :value="$totalBoq" prefix="₹" :decimals="2"
            :sublabel="$project->boqItems->count().' line items'"
            icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        <x-stat-card label="Total Expenses" :value="$totalExpenses" prefix="₹" :decimals="2"
            :sublabel="$project->expenses->count().' entries'"
            icon="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        <x-stat-card label="Estimated Budget" :value="$project->estimated_budget" prefix="₹" :decimals="2"
            :sublabel="$usedPct.'% utilised'"
            icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
        <x-stat-card label="Budget Variance" :value="abs($variance)" prefix="₹" :decimals="2"
            :sublabel="$variance < 0 ? '▲ Over budget' : '▼ Under budget'"
            :tone="$variance < 0 ? 'dark' : 'lime'"
            icon="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: '{{ $activeTab }}' }" class="mt-8">
        <div class="rounded-2xl border border-black/10 bg-white p-1.5 shadow-soft">
            <nav class="flex gap-1 overflow-x-auto">
                @foreach (['overview' => 'Overview', 'boq' => 'BOQ', 'expenses' => 'Expenses', 'progress' => 'Progress'] as $key => $label)
                    <button @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}' ? 'bg-brand-500 text-black shadow-glow' : 'text-gray-500 hover:bg-black/5 hover:text-black'"
                            class="flex-1 whitespace-nowrap rounded-xl px-4 py-2.5 text-sm font-bold transition duration-200">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>

        {{-- OVERVIEW --}}
        <div x-show="tab === 'overview'" x-cloak x-transition.opacity.duration.300ms class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="card p-6 lg:col-span-2">
                <h3 class="mb-4 text-base font-bold text-black">Project Details</h3>
                <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    <div><dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Client</dt><dd class="mt-0.5 text-sm text-black">{{ $project->client_name }}</dd></div>
                    <div><dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Location</dt><dd class="mt-0.5 text-sm text-black">{{ $project->location ?: '—' }}</dd></div>
                    <div><dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Type</dt><dd class="mt-0.5 text-sm text-black">{{ $project->type ?: '—' }}</dd></div>
                    <div><dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Status</dt><dd class="mt-0.5"><span class="badge {{ $project->statusColor() }}">{{ $project->statusLabel() }}</span></dd></div>
                    <div><dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Start Date</dt><dd class="mt-0.5 text-sm text-black">{{ optional($project->start_date)->format('d M Y') ?: '—' }}</dd></div>
                    <div><dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Expected Completion</dt><dd class="mt-0.5 text-sm text-black">{{ optional($project->expected_completion_date)->format('d M Y') ?: '—' }}</dd></div>
                    <div class="sm:col-span-2"><dt class="text-xs font-medium uppercase tracking-wide text-gray-400">Description</dt><dd class="mt-0.5 text-sm leading-relaxed text-gray-700">{{ $project->description ?: '—' }}</dd></div>
                </dl>
            </div>
            <div class="card flex flex-col items-center p-6">
                <h3 class="mb-4 self-start text-base font-bold text-black">Budget Utilisation</h3>
                <x-progress-ring :value="min($usedPct, 100)" :size="150" :stroke="14"
                    :from="$usedPct > 100 ? '#000000' : '#aeff00'" :to="$usedPct > 100 ? '#000000' : '#aeff00'" label="Used" />
                <div class="mt-5 w-full space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Spent</span><span class="font-bold text-black">₹{{ number_format($totalExpenses, 0) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Budget</span><span class="font-bold text-black">₹{{ number_format($project->estimated_budget, 0) }}</span></div>
                    <div class="flex justify-between border-t border-black/10 pt-2"><span class="text-gray-500">Remaining</span><span class="font-bold text-black">{{ $variance < 0 ? '−' : '' }}₹{{ number_format(abs($variance), 0) }}</span></div>
                </div>
            </div>
        </div>

        {{-- BOQ --}}
        <div x-show="tab === 'boq'" x-cloak x-transition.opacity.duration.300ms class="mt-6">
            @include('boq.partials.table', ['project' => $project, 'boqItems' => $project->boqItems])
        </div>

        {{-- EXPENSES --}}
        <div x-show="tab === 'expenses'" x-cloak x-transition.opacity.duration.300ms class="mt-6">
            @include('expenses.partials.table', ['project' => $project, 'expenses' => $project->expenses])
        </div>

        {{-- PROGRESS --}}
        <div x-show="tab === 'progress'" x-cloak x-transition.opacity.duration.300ms class="mt-6">
            @include('progress.partials.table', ['project' => $project, 'tasks' => $project->progressTasks])
        </div>
    </div>
@endsection
