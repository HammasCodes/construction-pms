<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'type',
        'description',
        'quantity',
        'unit',
        'rate',
        'date',
        'vendor',
        'remarks',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'rate' => 'decimal:2',
        'date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Total cost of the expense: quantity * rate.
     */
    public function total(): float
    {
        return (float) $this->quantity * (float) $this->rate;
    }

    public function typeLabel(): string
    {
        return ucfirst($this->type);
    }

    public function typeColor(): string
    {
        return match ($this->type) {
            'material' => 'bg-brand-500 text-black ring-transparent',
            'labour' => 'bg-black text-brand-500 ring-transparent',
            'equipment' => 'bg-white text-black ring-black/20',
            default => 'bg-black/[0.06] text-ink-700 ring-transparent',
        };
    }
}
