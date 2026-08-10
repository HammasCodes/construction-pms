<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Project Report — {{ $project->name }}</title>
    <style>
        @page { margin: 28px 32px; }
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1f2937; margin: 0; }
        h1, h2, h3 { margin: 0; }
        .muted { color: #6b7280; }
        .header { border-bottom: 2px solid #4f46e5; padding-bottom: 10px; margin-bottom: 16px; }
        .header .brand { color: #4f46e5; font-size: 12px; font-weight: bold; letter-spacing: 1px; }
        .header h1 { font-size: 20px; margin-top: 4px; color: #111827; }
        .header .meta { font-size: 10px; color: #6b7280; margin-top: 4px; }
        .section { margin-bottom: 18px; }
        .section-title { font-size: 13px; font-weight: bold; color: #111827; border-left: 3px solid #4f46e5; padding-left: 8px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 4px 6px; vertical-align: top; }
        .info-table .label { color: #6b7280; width: 130px; font-size: 10px; text-transform: uppercase; }
        .data-table { font-size: 10px; }
        .data-table th { background: #f3f4f6; color: #374151; text-align: left; padding: 6px; border: 1px solid #e5e7eb; font-size: 9px; text-transform: uppercase; }
        .data-table td { padding: 6px; border: 1px solid #e5e7eb; }
        .data-table tfoot td { background: #f9fafb; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 9px; }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-yellow { background: #fef9c3; color: #854d0e; }
        .summary-grid { width: 100%; }
        .summary-grid td { width: 25%; padding: 8px; border: 1px solid #e5e7eb; text-align: center; }
        .summary-grid .val { font-size: 15px; font-weight: bold; color: #111827; }
        .summary-grid .cap { font-size: 9px; color: #6b7280; text-transform: uppercase; }
        .pos { color: #15803d; }
        .neg { color: #b91c1c; }
        .footer { margin-top: 20px; border-top: 1px solid #e5e7eb; padding-top: 8px; font-size: 9px; color: #9ca3af; text-align: center; }
    </style>
</head>
<body>
    @php
        $totalBoq = $project->totalBoqAmount();
        $totalExpenses = $project->totalExpenses();
        $variance = $project->budgetVariance();
        $rs = fn ($n) => 'Rs. ' . number_format((float) $n, 2);
        $badge = match ($project->status) {
            'completed' => 'badge-green',
            'in_progress' => 'badge-blue',
            default => 'badge-yellow',
        };
    @endphp

    <div class="header">
        <div class="brand">CONSTRUCTPMS</div>
        <h1>{{ $project->name }}</h1>
        <div class="meta">
            Client: {{ $project->client_name }}
            @if ($project->location) &nbsp;|&nbsp; Location: {{ $project->location }} @endif
            @if ($project->type) &nbsp;|&nbsp; Type: {{ $project->type }} @endif
            &nbsp;|&nbsp; Generated: {{ now()->format('d M Y, h:i A') }}
        </div>
    </div>

    {{-- Project Summary --}}
    <div class="section">
        <div class="section-title">Project Summary</div>
        <table class="info-table">
            <tr>
                <td class="label">Status</td>
                <td><span class="badge {{ $badge }}">{{ $project->statusLabel() }}</span></td>
                <td class="label">Overall Progress</td>
                <td>{{ $project->progress }}%</td>
            </tr>
            <tr>
                <td class="label">Start Date</td>
                <td>{{ optional($project->start_date)->format('d M Y') ?: '—' }}</td>
                <td class="label">Expected Completion</td>
                <td>{{ optional($project->expected_completion_date)->format('d M Y') ?: '—' }}</td>
            </tr>
            <tr>
                <td class="label">Description</td>
                <td colspan="3">{{ $project->description ?: '—' }}</td>
            </tr>
        </table>
    </div>

    {{-- Key figures --}}
    <div class="section">
        <table class="summary-grid">
            <tr>
                <td><div class="cap">Total BOQ</div><div class="val">{{ $rs($totalBoq) }}</div></td>
                <td><div class="cap">Estimated Budget</div><div class="val">{{ $rs($project->estimated_budget) }}</div></td>
                <td><div class="cap">Total Expenses</div><div class="val">{{ $rs($totalExpenses) }}</div></td>
                <td><div class="cap">Budget Variance</div><div class="val {{ $variance < 0 ? 'neg' : 'pos' }}">{{ $rs($variance) }}</div></td>
            </tr>
        </table>
    </div>

    {{-- BOQ --}}
    <div class="section">
        <div class="section-title">Bill of Quantities</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Category</th><th>Description</th><th>Unit</th>
                    <th class="text-right">Qty</th><th class="text-right">Rate</th>
                    <th class="text-right">Amount</th><th class="text-right">Tax %</th><th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($project->boqItems as $item)
                    <tr>
                        <td>{{ $item->category ?: '—' }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->unit ?: '—' }}</td>
                        <td class="text-right">{{ number_format($item->quantity, 2) }}</td>
                        <td class="text-right">{{ $rs($item->rate) }}</td>
                        <td class="text-right">{{ $rs($item->amount()) }}</td>
                        <td class="text-right">{{ number_format($item->tax_percentage, 2) }}%</td>
                        <td class="text-right">{{ $rs($item->total()) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center muted">No BOQ items.</td></tr>
                @endforelse
            </tbody>
            @if ($project->boqItems->isNotEmpty())
                <tfoot>
                    <tr><td colspan="7" class="text-right">Total BOQ Amount</td><td class="text-right">{{ $rs($totalBoq) }}</td></tr>
                </tfoot>
            @endif
        </table>
    </div>

    {{-- Expenses --}}
    <div class="section">
        <div class="section-title">Expenses</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th><th>Type</th><th>Description</th><th>Vendor</th>
                    <th class="text-right">Qty</th><th class="text-right">Rate</th><th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($project->expenses as $expense)
                    <tr>
                        <td>{{ optional($expense->date)->format('d M Y') ?: '—' }}</td>
                        <td>{{ $expense->typeLabel() }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ $expense->vendor ?: '—' }}</td>
                        <td class="text-right">{{ number_format($expense->quantity, 2) }} {{ $expense->unit }}</td>
                        <td class="text-right">{{ $rs($expense->rate) }}</td>
                        <td class="text-right">{{ $rs($expense->total()) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center muted">No expenses recorded.</td></tr>
                @endforelse
            </tbody>
            @if ($project->expenses->isNotEmpty())
                <tfoot>
                    <tr><td colspan="6" class="text-right">Total Expenses</td><td class="text-right">{{ $rs($totalExpenses) }}</td></tr>
                </tfoot>
            @endif
        </table>
    </div>

    {{-- Progress --}}
    <div class="section">
        <div class="section-title">Progress &amp; Milestones</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Milestone</th><th>Planned</th><th>Completed</th>
                    <th class="text-right">%</th><th>Start</th><th>Due</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($project->progressTasks as $task)
                    <tr>
                        <td>{{ $task->milestone }}</td>
                        <td>{{ $task->planned_work ?: '—' }}</td>
                        <td>{{ $task->completed_work ?: '—' }}</td>
                        <td class="text-right">{{ $task->completion_percentage }}%</td>
                        <td>{{ optional($task->start_date)->format('d M Y') ?: '—' }}</td>
                        <td>{{ optional($task->due_date)->format('d M Y') ?: '—' }}</td>
                        <td>{{ $task->statusLabel() }}</td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center muted">No progress tasks.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Budget vs Actual --}}
    <div class="section">
        <div class="section-title">Budget vs Actual</div>
        <table class="data-table">
            <tbody>
                <tr><td>Estimated Budget</td><td class="text-right">{{ $rs($project->estimated_budget) }}</td></tr>
                <tr><td>Total BOQ Value</td><td class="text-right">{{ $rs($totalBoq) }}</td></tr>
                <tr><td>Actual Expenses</td><td class="text-right">{{ $rs($totalExpenses) }}</td></tr>
                <tr><td>Budget Utilised</td><td class="text-right">{{ $project->budgetUsedPercentage() }}%</td></tr>
                <tr>
                    <td><strong>Budget Variance ({{ $variance < 0 ? 'Over Budget' : 'Under Budget' }})</strong></td>
                    <td class="text-right {{ $variance < 0 ? 'neg' : 'pos' }}"><strong>{{ $rs($variance) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        This report was generated by ConstructPMS on {{ now()->format('d M Y, h:i A') }}. &nbsp;|&nbsp; Confidential
    </div>
</body>
</html>
