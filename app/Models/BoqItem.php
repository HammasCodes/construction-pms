<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoqItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'category',
        'description',
        'unit',
        'quantity',
        'rate',
        'tax_percentage',
        'remarks',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'rate' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Base amount before tax: quantity * rate.
     */
    public function amount(): float
    {
        return (float) $this->quantity * (float) $this->rate;
    }

    /**
     * Tax value: amount * (tax_percentage / 100).
     */
    public function taxAmount(): float
    {
        return $this->amount() * ((float) $this->tax_percentage / 100);
    }

    /**
     * Grand total: amount + tax.
     */
    public function total(): float
    {
        return $this->amount() + $this->taxAmount();
    }
}
