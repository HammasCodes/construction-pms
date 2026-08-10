@php
    $inputClass = 'field';
    $labelClass = 'field-label';
@endphp

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="{{ $labelClass }}">Milestone <span class="text-black">*</span></label>
        <input type="text" name="milestone" value="{{ old('milestone', $progress->milestone ?? '') }}" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Planned Work</label>
        <textarea name="planned_work" rows="2" class="{{ $inputClass }}">{{ old('planned_work', $progress->planned_work ?? '') }}</textarea>
    </div>
    <div>
        <label class="{{ $labelClass }}">Completed Work</label>
        <textarea name="completed_work" rows="2" class="{{ $inputClass }}">{{ old('completed_work', $progress->completed_work ?? '') }}</textarea>
    </div>
    <div>
        <label class="{{ $labelClass }}">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($progress->start_date) ? $progress->start_date->format('Y-m-d') : '') }}" class="{{ $inputClass }}">
    </div>
    <div>
        <label class="{{ $labelClass }}">Due Date</label>
        <input type="date" name="due_date" value="{{ old('due_date', isset($progress->due_date) ? $progress->due_date->format('Y-m-d') : '') }}" class="{{ $inputClass }}">
    </div>
    <div>
        <label class="{{ $labelClass }}">Status <span class="text-black">*</span></label>
        <select name="status" class="{{ $inputClass }}" required>
            @foreach (['not_started' => 'Not Started', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $progress->status ?? 'not_started') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div x-data="{ pct: {{ old('completion_percentage', $progress->completion_percentage ?? 0) }} }">
        <label class="{{ $labelClass }}">Completion: <span x-text="pct + '%'"></span></label>
        <div class="mt-2 flex items-center gap-3">
            <input type="range" min="0" max="100" name="completion_percentage" x-model="pct" class="w-full accent-black">
            <span class="w-12 text-right text-sm font-medium text-gray-700" x-text="pct + '%'"></span>
        </div>
    </div>
    <div class="md:col-span-2">
        <label class="{{ $labelClass }}">Remarks</label>
        <textarea name="remarks" rows="2" class="{{ $inputClass }}">{{ old('remarks', $progress->remarks ?? '') }}</textarea>
    </div>
</div>
