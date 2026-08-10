@extends('layouts.master')

@section('title', 'Progress · '.$project->name)

@section('content')
    <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'progress']) }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to project</a>
    @include('progress.partials.table', ['project' => $project, 'tasks' => $tasks])
@endsection
