@extends('layouts.master')

@section('title', 'BOQ Item')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('projects.show', ['project' => $project, 'tab' => 'boq']) }}" class="mb-4 inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700">← Back to project</a>
        <div class="card p-6 lg:p-7">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-800">{{ $boq->description }}</h2>
                <a href="{{ route('projects.boq.edit', [$project, $boq]) }}" class="btn-primary">Edit</a>
            </div>
            <dl class="grid grid-cols-2 gap-x-6 gap-y-4">
                <div><dt class="text-xs uppercase text-gray-400">Category</dt><dd class="text-sm text-gray-800">{{ $boq->category ?: '—' }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Unit</dt><dd class="text-sm text-gray-800">{{ $boq->unit ?: '—' }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Quantity</dt><dd class="text-sm text-gray-800">{{ number_format($boq->quantity, 2) }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Rate</dt><dd class="text-sm text-gray-800">₹{{ number_format($boq->rate, 2) }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Amount</dt><dd class="text-sm text-gray-800">₹{{ number_format($boq->amount(), 2) }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Tax ({{ number_format($boq->tax_percentage, 2) }}%)</dt><dd class="text-sm text-gray-800">₹{{ number_format($boq->taxAmount(), 2) }}</dd></div>
                <div><dt class="text-xs uppercase text-gray-400">Total</dt><dd class="text-sm font-bold text-black">₹{{ number_format($boq->total(), 2) }}</dd></div>
                <div class="col-span-2"><dt class="text-xs uppercase text-gray-400">Remarks</dt><dd class="text-sm text-gray-800">{{ $boq->remarks ?: '—' }}</dd></div>
            </dl>
        </div>
    </div>
@endsection
