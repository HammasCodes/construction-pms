@php
    $inputClass = 'field';
    $labelClass = 'field-label';
@endphp

<div x-data="{
        quantity: {{ old('quantity', $expense->quantity ?? 0) }},
        rate: {{ old('rate', $expense->rate ?? 0) }},
        get total() { return this.quantity * this.rate; },
        fmt(n) { return '₹' + Number(n).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
     }"
     class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label class="{{ $labelClass }}">Type <span class="text-black">*</span></label>
        <select name="type" class="{{ $inputClass }}" required>
            @foreach (['material' => 'Material', 'labour' => 'Labour', 'equipment' => 'Equipment', 'other' => 'Other'] as $value => $label)
                <option value="{{ $value }}" @selected(old('type', $expense->type ?? 'material') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="{{ $labelClass }}">Date <span class="text-black">*</span></label>
        <input type="date" name="date" value="{{ old('date', isset($expense->date) ? $expense->date->format('Y-m-d') : now()->format('Y-m-d')) }}" class="{{ $inputClass }}" required>
    </div>
    <div class="md:col-span-2">
        <label class="{{ $labelClass }}">Description <span class="text-black">*</span></label>
        <input type="text" name="description" value="{{ old('description', $expense->description ?? '') }}" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Quantity <span class="text-black">*</span></label>
        <input type="number" step="0.01" min="0" name="quantity" x-model.number="quantity" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Unit</label>
        <input type="text" name="unit" value="{{ old('unit', $expense->unit ?? '') }}" placeholder="bags, hrs, nos…" class="{{ $inputClass }}">
    </div>
    <div>
        <label class="{{ $labelClass }}">Rate (₹) <span class="text-black">*</span></label>
        <input type="number" step="0.01" min="0" name="rate" x-model.number="rate" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Vendor</label>
        <input type="text" name="vendor" value="{{ old('vendor', $expense->vendor ?? '') }}" class="{{ $inputClass }}">
    </div>
    <div class="md:col-span-2">
        <label class="{{ $labelClass }}">Remarks</label>
        <textarea name="remarks" rows="2" class="{{ $inputClass }}">{{ old('remarks', $expense->remarks ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2 rounded-lg bg-gray-50 p-4 text-center">
        <p class="text-xs text-gray-400">Total Cost</p>
        <p class="text-lg font-bold text-black" x-text="fmt(total)"></p>
    </div>
</div>
