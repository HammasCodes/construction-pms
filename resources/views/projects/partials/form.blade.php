@php
    $inputClass = 'field';
    $labelClass = 'field-label';
@endphp

<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label class="{{ $labelClass }}">Project Name <span class="text-black">*</span></label>
        <input type="text" name="name" value="{{ old('name', $project->name ?? '') }}" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Client Name <span class="text-black">*</span></label>
        <input type="text" name="client_name" value="{{ old('client_name', $project->client_name ?? '') }}" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Location</label>
        <input type="text" name="location" value="{{ old('location', $project->location ?? '') }}" class="{{ $inputClass }}">
    </div>
    <div>
        <label class="{{ $labelClass }}">Type</label>
        <input type="text" name="type" value="{{ old('type', $project->type ?? '') }}" placeholder="Residential, Commercial…" class="{{ $inputClass }}">
    </div>
    <div class="md:col-span-2">
        <label class="{{ $labelClass }}">Description</label>
        <textarea name="description" rows="3" class="{{ $inputClass }}">{{ old('description', $project->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="{{ $labelClass }}">Start Date</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($project->start_date) ? $project->start_date->format('Y-m-d') : '') }}" class="{{ $inputClass }}">
    </div>
    <div>
        <label class="{{ $labelClass }}">Expected Completion</label>
        <input type="date" name="expected_completion_date" value="{{ old('expected_completion_date', isset($project->expected_completion_date) ? $project->expected_completion_date->format('Y-m-d') : '') }}" class="{{ $inputClass }}">
    </div>
    <div>
        <label class="{{ $labelClass }}">Status <span class="text-black">*</span></label>
        <select name="status" class="{{ $inputClass }}" required>
            @foreach (['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $project->status ?? 'pending') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="{{ $labelClass }}">Estimated Budget (₹) <span class="text-black">*</span></label>
        <input type="number" step="0.01" min="0" name="estimated_budget" value="{{ old('estimated_budget', $project->estimated_budget ?? '0') }}" class="{{ $inputClass }}" required>
    </div>
    <div class="md:col-span-2" x-data="{ progress: {{ old('progress', $project->progress ?? 0) }} }">
        <label class="{{ $labelClass }}">Progress: <span x-text="progress + '%'"></span></label>
        <div class="mt-2 flex items-center gap-3">
            <input type="range" min="0" max="100" name="progress" x-model="progress" class="w-full accent-black">
            <span class="w-12 text-right text-sm font-medium text-gray-700" x-text="progress + '%'"></span>
        </div>
    </div>
</div>
