@extends('layouts.master')

@section('title', 'Projects')
@section('subtitle', 'Browse and manage every construction project')

@section('header-actions')
    <a href="{{ route('projects.create') }}" class="btn-primary hidden sm:inline-flex">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Project
    </a>
@endsection

@section('content')
    <div class="grid grid-cols-1 gap-5 stagger md:grid-cols-2 xl:grid-cols-3">
        @forelse ($projects as $project)
            @php
                $variance = $project->budgetVariance();
                $bar = match ($project->status) {
                    'completed' => 'bg-brand-500',
                    'in_progress' => 'bg-black',
                    default => 'bg-gray-300',
                };
            @endphp
            <div class="card card-hover group flex flex-col overflow-hidden">
                <div class="h-1.5 w-full {{ $bar }}"></div>
                <div class="flex flex-1 flex-col p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('projects.show', $project) }}" class="text-base font-bold text-black">{{ $project->name }}</a>
                            <p class="truncate text-xs text-gray-400">{{ $project->client_name }} @if($project->location)&middot; {{ $project->location }}@endif</p>
                        </div>
                        <span class="badge {{ $project->statusColor() }} shrink-0">{{ $project->statusLabel() }}</span>
                    </div>

                    <p class="mt-3 line-clamp-2 text-sm text-gray-500">{{ $project->description ?: 'No description provided.' }}</p>

                    <div class="mt-4">
                        <div class="mb-1.5 flex justify-between text-xs text-gray-500">
                            <span>Progress</span><span class="font-bold text-black">{{ $project->progress }}%</span>
                        </div>
                        <div class="h-2 w-full overflow-hidden rounded-full bg-black/[0.06]">
                            <div class="h-full rounded-full bg-brand-500"
                                 style="width: 0" x-data x-init="$nextTick(() => { $el.style.transition = 'width 1s cubic-bezier(0.22,1,0.36,1)'; requestAnimationFrame(() => $el.style.width = '{{ $project->progress }}%') })"></div>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-3 gap-2 text-center text-xs">
                        <div class="rounded-xl bg-black/[0.04] p-2.5">
                            <p class="text-gray-400">Budget</p>
                            <p class="mt-0.5 font-bold text-black">₹{{ number_format($project->estimated_budget, 0) }}</p>
                        </div>
                        <div class="rounded-xl bg-black/[0.04] p-2.5">
                            <p class="text-gray-400">Spent</p>
                            <p class="mt-0.5 font-bold text-black">₹{{ number_format($project->totalExpenses(), 0) }}</p>
                        </div>
                        <div class="rounded-xl bg-black/[0.04] p-2.5">
                            <p class="text-gray-400">Variance</p>
                            <p class="mt-0.5 font-bold text-black">{{ $variance < 0 ? '−' : '' }}₹{{ number_format(abs($variance), 0) }}</p>
                        </div>
                    </div>

                    <div class="mt-auto flex items-center justify-between border-t border-black/10 pt-3">
                        <a href="{{ route('projects.show', $project) }}" class="text-sm font-bold text-black hover:text-brand-700">Open →</a>
                        <div class="flex gap-1">
                            <a href="{{ route('projects.edit', $project) }}" class="rounded-lg px-2 py-1 text-xs font-semibold text-gray-500 transition hover:bg-black/5 hover:text-black">Edit</a>
                            <a href="{{ route('projects.report.pdf', $project) }}" class="rounded-lg px-2 py-1 text-xs font-semibold text-gray-500 transition hover:bg-black/5 hover:text-black">PDF</a>
                            <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Delete this project and all its data?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded-lg px-2 py-1 text-xs font-semibold text-black transition hover:bg-black hover:text-white">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="card flex flex-col items-center p-16 text-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-black text-brand-500 animate-float">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
                    </div>
                    <p class="mt-4 text-lg font-bold text-black">No projects yet</p>
                    <p class="text-sm text-gray-400">Create your first project to get started.</p>
                    <a href="{{ route('projects.create') }}" class="btn-primary mt-5">New Project</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
