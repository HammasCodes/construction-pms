@extends('layouts.master')

@section('title', 'Reports')
@section('subtitle', 'Generate and export project reports as PDF')

@section('content')
    @if ($projects->isEmpty())
        <div class="card flex flex-col items-center p-16 text-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-black text-brand-500 animate-float">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <p class="mt-4 text-lg font-bold text-black">No reports yet</p>
            <p class="text-sm text-gray-400">Create a project to generate its report.</p>
            <a href="{{ route('projects.create') }}" class="btn-primary mt-5">New Project</a>
        </div>
    @else
        <div class="grid grid-cols-1 gap-5 stagger md:grid-cols-2 xl:grid-cols-3">
            @foreach ($projects as $project)
                @php
                    $boq = $project->totalBoqAmount();
                    $spent = $project->totalExpenses();
                    $variance = $project->budgetVariance();
                @endphp
                <div class="card card-hover flex flex-col overflow-hidden">
                    <div class="flex items-start justify-between gap-3 border-b border-black/10 p-5">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-black text-brand-500 shadow-md">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="truncate font-bold text-black">{{ $project->name }}</p>
                                <p class="truncate text-xs text-gray-400">{{ $project->client_name }}</p>
                            </div>
                        </div>
                        <span class="badge {{ $project->statusColor() }} shrink-0">{{ $project->statusLabel() }}</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2 p-5 text-center text-xs">
                        <div class="rounded-xl bg-black/[0.04] p-2.5">
                            <p class="text-gray-400">BOQ</p>
                            <p class="mt-0.5 font-bold text-black">₹{{ number_format($boq, 0) }}</p>
                        </div>
                        <div class="rounded-xl bg-black/[0.04] p-2.5">
                            <p class="text-gray-400">Spent</p>
                            <p class="mt-0.5 font-bold text-black">₹{{ number_format($spent, 0) }}</p>
                        </div>
                        <div class="rounded-xl bg-black/[0.04] p-2.5">
                            <p class="text-gray-400">Variance</p>
                            <p class="mt-0.5 font-bold text-black">{{ $variance < 0 ? '−' : '' }}₹{{ number_format(abs($variance), 0) }}</p>
                        </div>
                    </div>

                    <div class="mt-auto flex items-center gap-2 border-t border-black/10 p-4">
                        <a href="{{ route('projects.report.view', $project) }}" target="_blank" rel="noopener" class="btn-ghost flex-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </a>
                        <a href="{{ route('projects.report.pdf', $project) }}" class="btn-primary flex-1">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            PDF
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
