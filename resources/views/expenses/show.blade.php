@extends('layouts.master')

@section('title', 'Expense')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'expenses']) }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to project</a>
        <div class="card p-6 lg:p-7">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">{{ $expense->description }}</h2>
                <a href="{{ route('projects.expenses.edit', [$project, $expense]) }}" class="btn-primary">Edit</a>
            </div>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                <div><dt class="text-xs uppercase text-gray-400">Type</dt><dd><span class="badge {{ $expense->typeColor() }} ring-transparent">{{ $expense->typeLabel() }}</span></dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Date</dt><dd class="text-sm text-gray-800">{{ optional($expense->date)->format('d M Y') ?: '—' }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Quantity</dt><dd class="text-sm text-gray-800">{{ number_format($expense->quantity, 2) }} {{ $expense->unit }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Rate</dt><dd class="text-sm text-gray-800">₹{{ number_format($expense->rate, 2) }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Vendor</dt><dd class="text-sm text-gray-800">{{ $expense->vendor ?: '—' }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Total</dt><dd class="text-sm font-bold text-black">₹{{ number_format($expense->total(), 2) }}</dd></div>
                <div class="col-span-2"><dt class="text-xs uppercase text-gray-400">Remarks</dt><dd class="text-sm text-gray-800">{{ $expense->remarks ?: '—' }}</dd></div>
            </dl>
        </div>
    </div>
@endsection
