@extends('layouts.master')

@section('title', 'Dashboard')
@section('subtitle', 'Portfolio overview across all construction projects')

@section('header-actions')
    <a href="{{ route('projects.create') }}" class="btn-primary hidden sm:inline-flex">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Project
    </a>
@endsection

@section('content')
    @php
        $pending = $projects->where('status', 'pending')->count();
        $inProgress = $projects->where('status', 'in_progress')->count();
        $completed = $projects->where('status', 'completed')->count();
        $variance = $totals['estimated_budget'] - $totals['total_expenses'];
        $usedPct = $totals['estimated_budget'] > 0 ? round(($totals['total_expenses'] / $totals['estimated_budget']) * 100, 1) : 0;
    @endphp

    {{-- Summary cards --}}
    <div class="grid grid-cols-1 gap-4 stagger sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total Projects" :value="$totals['projects']" tone="lime"
            :sublabel="$inProgress.' active · '.$completed.' completed'"
            icon="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />

        <x-stat-card label="Estimated Budget" :value="$totals['estimated_budget']" prefix="₹"
            sublabel="Total contracted value"
            icon="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />

        <x-stat-card label="Total Expenses" :value="$totals['total_expenses']" prefix="₹"
            :sublabel="$usedPct.'% of budget utilised'"
            icon="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />

        <x-stat-card label="Budget Variance" :value="abs($variance)" prefix="₹"
            :sublabel="$variance < 0 ? '▲ Over budget' : '▼ Under budget'"
            :tone="$variance < 0 ? 'dark' : 'lime'"
            icon="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
    </div>

    {{-- Charts row --}}
    <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Status donut --}}
        <div class="card p-6 animate-fade-in-up">
            <h2 class="text-sm font-bold text-black">Project Status</h2>
            <p class="text-xs text-gray-400">Distribution by lifecycle stage</p>
            <div class="mt-4 flex items-center justify-center">
                <x-donut
                    :segments="[
                        ['value' => $completed, 'color' => '#aeff00', 'label' => 'Completed'],
                        ['value' => $inProgress, 'color' => '#000000', 'label' => 'In Progress'],
                        ['value' => $pending, 'color' => '#d4d4d4', 'label' => 'Pending'],
                    ]"
                    :centerValue="$totals['projects']" centerLabel="Projects" />
            </div>
            <div class="mt-5 space-y-2 text-sm">
                @foreach ([['Completed', $completed, 'bg-brand-500'], ['In Progress', $inProgress, 'bg-black'], ['Pending', $pending, 'bg-gray-300']] as [$lbl, $cnt, $dot])
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 text-gray-600"><span class="h-2.5 w-2.5 rounded-full {{ $dot }}"></span>{{ $lbl }}</span>
                        <span class="font-bold text-black">{{ $cnt }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Budget vs actual bars --}}
        <div class="card p-6 lg:col-span-2 animate-fade-in-up">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-black">Budget vs Actual</h2>
                    <p class="text-xs text-gray-400">Spend against estimated budget per project</p>
                </div>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-gray-200"></span>Budget</span>
                    <span class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-brand-500"></span>Spent</span>
                </div>
            </div>
            <div class="mt-5 space-y-5">
                @forelse ($projects as $project)
                    @php
                        $spent = $project->totalExpenses();
                        $budget = (float) $project->estimated_budget;
                        $pct = $budget > 0 ? min(($spent / $budget) * 100, 100) : 0;
                        $over = $budget > 0 && $spent > $budget;
                    @endphp
                    <div>
                        <div class="mb-1.5 flex items-center justify-between text-sm">
                            <a href="{{ route('projects.show', $project) }}" class="font-medium text-black hover:text-brand-700">{{ $project->name }}</a>
                            <span class="text-xs text-gray-500">₹{{ number_format($spent, 0) }} <span class="text-gray-300">/</span> ₹{{ number_format($budget, 0) }}</span>
                        </div>
                        <div class="h-2.5 w-full overflow-hidden rounded-full bg-black/[0.06]">
                            <div class="h-full origin-left rounded-full {{ $over ? 'bg-black' : 'bg-brand-500' }}"
                                 style="width: 0" x-data x-init="$nextTick(() => { $el.style.transition = 'width 1.1s cubic-bezier(0.22,1,0.36,1)'; requestAnimationFrame(() => $el.style.width = '{{ $pct }}%') })"></div>
                        </div>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-gray-400">No projects to chart yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Projects table --}}
    <div class="card mt-6 overflow-hidden animate-fade-in-up">
        <div class="flex items-center justify-between border-b border-black/10 px-6 py-4">
            <div>
                <h2 class="text-base font-bold text-black">Projects Overview</h2>
                <p class="text-xs text-gray-400">{{ $projects->count() }} project(s) tracked</p>
            </div>
            <a href="{{ route('projects.index') }}" class="text-sm font-bold text-black hover:text-brand-700">View all →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-black/5 text-sm">
                <thead class="bg-black/[0.03] text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-6 py-3.5">Project</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="w-56 px-6 py-3.5">Progress</th>
                        <th class="px-6 py-3.5 text-right">Budget</th>
                        <th class="px-6 py-3.5 text-right">Expenses</th>
                        <th class="px-6 py-3.5 text-right">Variance</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($projects as $project)
                        @php $variance = $project->budgetVariance(); @endphp
                        <tr class="group transition hover:bg-brand-50/60">
                            <td class="px-6 py-4">
                                <a href="{{ route('projects.show', $project) }}" class="font-bold text-black">{{ $project->name }}</a>
                                <p class="text-xs text-gray-400">{{ $project->client_name }} @if($project->location) &middot; {{ $project->location }} @endif</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge {{ $project->statusColor() }}">{{ $project->statusLabel() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="h-2 w-full overflow-hidden rounded-full bg-black/[0.06]">
                                        <div class="h-full rounded-full bg-brand-500" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                    <span class="w-9 text-right text-xs font-bold text-black">{{ $project->progress }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-700">₹{{ number_format($project->estimated_budget, 0) }}</td>
                            <td class="px-6 py-4 text-right text-gray-700">₹{{ number_format($project->totalExpenses(), 0) }}</td>
                            <td class="px-6 py-4 text-right font-bold text-black">
                                {{ $variance < 0 ? '−' : '' }}₹{{ number_format(abs($variance), 0) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('projects.show', $project) }}" class="rounded-lg px-2.5 py-1 text-xs font-bold text-black transition hover:bg-brand-500">View</a>
                                    <a href="{{ route('projects.report.pdf', $project) }}" class="rounded-lg px-2.5 py-1 text-xs font-semibold text-gray-500 transition hover:bg-black/5">PDF</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-black text-brand-500 animate-float">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                                    </div>
                                    <p class="mt-4 font-medium text-gray-600">No projects yet</p>
                                    <a href="{{ route('projects.create') }}" class="btn-primary mt-4">Create your first project</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
