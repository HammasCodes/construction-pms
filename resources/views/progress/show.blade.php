@extends('layouts.master')

@section('title', 'Progress Task')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'progress']) }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to project</a>
        <div class="card p-6 lg:p-7">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">{{ $progress->milestone }}</h2>
                <a href="{{ route('projects.progress.edit', [$project, $progress]) }}" class="btn-primary">Edit</a>
            </div>
            <div class="mb-4">
                <div class="mb-1 flex justify-between text-sm text-gray-500"><span>Completion</span><span>{{ $progress->completion_percentage }}%</span></div>
                <div class="h-2.5 w-full overflow-hidden rounded-full bg-gray-100">
                    <div class="h-full rounded-full bg-brand-500" style="width: {{ $progress->completion_percentage }}%"></div>
                </div>
            </div>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                <div><dt class="text-xs uppercase text-gray-400">Status</dt><dd><span class="badge {{ $progress->statusColor() }} ring-transparent">{{ $progress->statusLabel() }}</span></dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Start Date</dt><dd class="text-sm text-gray-800">{{ optional($progress->start_date)->format('d M Y') ?: '—' }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Due Date</dt><dd class="text-sm text-gray-800">{{ optional($progress->due_date)->format('d M Y') ?: '—' }}</dd></div>
                <div class="col-span-2"><dt class="text-xs uppercase text-gray-400">Planned Work</dt><dd class="text-sm text-gray-800">{{ $progress->planned_work ?: '—' }}</dd></div>
                <div class="col-span-2"><dt class="text-xs uppercase text-gray-400">Completed Work</dt><dd class="text-sm text-gray-800">{{ $progress->completed_work ?: '—' }}</dd></div>
                <div class="col-span-2"><dt class="text-xs uppercase text-gray-400">Remarks</dt><dd class="text-sm text-gray-800">{{ $progress->remarks ?: '—' }}</dd></div>
            </dl>
        </div>
    </div>
@endsection
