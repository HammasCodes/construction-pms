@extends('layouts.master')

@section('title', 'Add BOQ Item')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'boq']) }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to project</a>
        <div class="card p-6 lg:p-7">
            <h2 class="mb-6 text-lg font-semibold text-gray-800">Add BOQ Item &mdash; {{ $project->name }}</h2>
            <form method="POST" action="{{ route('projects.boq.store', $project) }}" class="space-y-5">
                @csrf
                @include('boq.partials.form', ['boq' => null])
                <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
                    <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'boq']) }}" class="btn-ghost">Cancel</a>
                    <button type="submit" class="btn-primary">Save Item</button>
                </div>
            </form>
        </div>
    </div>
@endsection
