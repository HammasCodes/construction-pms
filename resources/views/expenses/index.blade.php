@extends('layouts.master')

@section('title', 'Expenses · '.$project->name)

@section('content')
    <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'expenses']) }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to project</a>
    @include('expenses.partials.table', ['project' => $project, 'expenses' => $expenses])
@endsection
