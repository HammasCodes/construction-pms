@extends('layouts.master')

@section('title', 'New Project')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('projects.index') }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to projects</a>
        <div class="card p-6 lg:p-7">
            <h2 class="mb-6 text-lg font-semibold text-gray-800">Create Project</h2>
            <form method="POST" action="{{ route('projects.store') }}" class="space-y-5">
                @csrf
                @include('projects.partials.form', ['project' => null])
                <div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
                    <a href="{{ route('projects.index') }}" class="btn-ghost">Cancel</a>
                    <button type="submit" class="btn-primary">Create Project</button>
                </div>
            </form>
        </div>
    </div>
@endsection
