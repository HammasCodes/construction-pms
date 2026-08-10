@extends('layouts.master')

@section('title', 'Edit Progress Task')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'progress']) }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to project</a>
        <div class="card p-6 lg:p-7">
            <h2 class="mb-6 text-lg font-semibold text-gray-800">Edit Progress Task &mdash; {{ $project->name }}</h2>
            <form method="POST" action="{{ route('projects.progress.update', [$project, $progress]) }}" class="space-y-5">
                @csrf @method('PUT')
                @include('progress.partials.form', ['progress' => $progress])
                <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
                    <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'progress']) }}" class="btn-ghost">Cancel</a>
                    <button type="submit" class="btn-primary">Update Task</button>
                </div>
            </form>
        </div>
    </div>
@endsection
