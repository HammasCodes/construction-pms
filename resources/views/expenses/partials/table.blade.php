@php
    $expensesTotal = $project->totalExpenses();
@endphp

<div class="card overflow-hidden">
    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-black text-brand-500 shadow-md">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 9v1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Expenses</h3>
                <p class="text-xs text-gray-400">{{ $expenses->count() }} entry(s)</p>
            </div>
        </div>
        <a href="{{ route('projects.expenses.create', $project) }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Expense
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
            <thead class="bg-gray-50/80 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3">Vendor</th>
                    <th class="px-4 py-3 text-right">Qty</th>
                    <th class="px-4 py-3 text-right">Rate</th>
                    <th class="px-4 py-3 text-right">Total</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($expenses as $expense)
                    <tr class="transition hover:bg-brand-50/40">
                        <td class="px-4 py-3 text-gray-600">{{ optional($expense->date)->format('d M Y') ?: '—' }}</td>
                        <td class="px-4 py-3"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $expense->typeColor() }}">{{ $expense->typeLabel() }}</span></td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $expense->description }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $expense->vendor ?: '—' }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">{{ number_format($expense->quantity, 2) }} {{ $expense->unit }}</td>
                        <td class="px-4 py-3 text-right text-gray-600">₹{{ number_format($expense->rate, 2) }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-800">₹{{ number_format($expense->total(), 2) }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('projects.expenses.edit', [$project, $expense]) }}" class="rounded-md px-2 py-1 text-xs font-bold text-black transition hover:bg-brand-500">Edit</a>
                                <form method="POST" action="{{ route('projects.expenses.destroy', [$project, $expense]) }}" onsubmit="return confirm('Delete this expense?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-md px-2 py-1 text-xs font-bold text-black transition hover:bg-black hover:text-white">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-4 py-10 text-center text-gray-400">No expenses recorded yet.</td></tr>
                @endforelse
            </tbody>
            @if ($expenses->isNotEmpty())
                <tfoot class="bg-black/[0.04] font-bold text-black">
                    <tr>
                        <td colspan="6" class="px-4 py-3.5 text-right">Total Expenses</td>
                        <td class="px-4 py-3.5 text-right text-black">₹{{ number_format($expensesTotal, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>
