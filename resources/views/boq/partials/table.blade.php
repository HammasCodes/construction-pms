@php
    $boqTotal = $project->totalBoqAmount();
@endphp

<div class="card overflow-hidden">
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-black text-brand-500 shadow-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Bill of Quantities</h3>
                <p class="text-xs text-gray-400">{{ $boqItems->count() }} item(s)</p>
            </div>
        </div>
        <a href="{{ route('projects.boq.create', $project) }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add BOQ Item
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50/80 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Unit</th>
                    <th class="px-4 py-3 text-right">Qty</th>
                    <th class="px-4 py-3 text-right">Rate</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                    <th class="px-4 py-3 text-right">Tax %</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($boqItems as $item)
                    <tr class="transition hover:bg-brand-50/40">
                        <td class="px-4 py-3 text-gray-600">{{ $item->category ?: '—' }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $item->description }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $item->unit ?: '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">{{ number_format($item->quantity, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">₹{{ number_format($item->rate, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">₹{{ number_format($item->amount(), 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">{{ number_format($item->tax_percentage, 2) }}%</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">₹{{ number_format($item->total(), 2) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('projects.boq.edit', [$project, $item]) }}" class="rounded-md px-2 py-1 text-xs font-bold text-black transition hover:bg-brand-500">Edit</a>
                                <form method="POST" action="{{ route('projects.boq.destroy', [$project, $item]) }}" onsubmit="return confirm('Delete this BOQ item?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-md px-2 py-1 text-xs font-bold text-black transition hover:bg-black hover:text-white">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="px-4 py-10 text-center text-gray-400">No BOQ items yet.</td></tr>
                @endforelse
            </tbody>
            @if ($boqItems->isNotEmpty())
                <tfoot class="bg-black/[0.04] font-bold text-black">
                    <tr>
                        <td colspan="7" class="px-4 py-3.5 text-right">Total BOQ Amount</td>
                        <td class="px-4 py-3.5 text-right text-black">₹{{ number_format($boqTotal, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
