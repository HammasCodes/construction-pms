@php
    $inputClass = 'field';
    $labelClass = 'field-label';
@endphp

<div x-data="{
        quantity: {{ old('quantity', $boq->quantity ?? 0) }},
        rate: {{ old('rate', $boq->rate ?? 0) }},
        tax: {{ old('tax_percentage', $boq->tax_percentage ?? 0) }},
        get amount() { return this.quantity * this.rate; },
        get taxAmount() { return this.amount * (this.tax / 100); },
        get total() { return this.amount + this.taxAmount; },
        fmt(n) { return '₹' + Number(n).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
     }"
     class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div>
        <label class="{{ $labelClass }}">Category</label>
        <input type="text" name="category" value="{{ old('category', $boq->category ?? '') }}" placeholder="Civil, Electrical…" class="{{ $inputClass }}">
    </div>
    <div>
        <label class="{{ $labelClass }}">Unit</label>
        <input type="text" name="unit" value="{{ old('unit', $boq->unit ?? '') }}" placeholder="m³, kg, nos…" class="{{ $inputClass }}">
    </div>
    <div class="md:col-span-2">
        <label class="{{ $labelClass }}">Description <span class="text-black">*</span></label>
        <input type="text" name="description" value="{{ old('description', $boq->description ?? '') }}" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Quantity <span class="text-black">*</span></label>
        <input type="number" step="0.01" min="0" name="quantity" x-model.number="quantity" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Rate (₹) <span class="text-black">*</span></label>
        <input type="number" step="0.01" min="0" name="rate" x-model.number="rate" class="{{ $inputClass }}" required>
    </div>
    <div>
        <label class="{{ $labelClass }}">Tax % <span class="text-black">*</span></label>
        <input type="number" step="0.01" min="0" max="100" name="tax_percentage" x-model.number="tax" class="{{ $inputClass }}" required>
    </div>
    <div class="md:col-span-2">
        <label class="{{ $labelClass }}">Remarks</label>
        <textarea name="remarks" rows="2" class="{{ $inputClass }}">{{ old('remarks', $boq->remarks ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2 grid grid-cols-3 gap-3 rounded-lg bg-gray-50 p-4 text-center">
        <div><p class="text-xs text-gray-400">Amount</p><p class="font-semibold text-gray-800" x-text="fmt(amount)"></p></div>
        <div><p class="text-xs text-gray-400">Tax</p><p class="font-semibold text-gray-800" x-text="fmt(taxAmount)"></p></div>
        <div><p class="text-xs text-gray-400">Total</p><p class="font-bold text-black" x-text="fmt(total)"></p></div>
    </div>
</div>
