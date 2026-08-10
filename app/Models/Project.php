<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_name',
        'location',
        'type',
        'description',
        'start_date',
        'expected_completion_date',
        'status',
        'estimated_budget',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_completion_date' => 'date',
        'estimated_budget' => 'decimal:2',
        'progress' => 'integer',
    ];

    public function boqItems(): HasMany
    {
        return $this->hasMany(BoqItem::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function progressTasks(): HasMany
    {
        return $this->hasMany(ProgressTask::class);
    }

    /**
     * Sum of the total (amount + tax) of every BOQ item on this project.
     */
    public function totalBoqAmount(): float
    {
        return (float) $this->boqItems->sum(fn (BoqItem $item) => $item->total());
    }

    /**
     * Sum of the total cost of every expense on this project.
     */
    public function totalExpenses(): float
    {
        return (float) $this->expenses->sum(fn (Expense $expense) => $expense->total());
    }

    /**
     * Estimated budget minus what has actually been spent.
     * Positive means under budget, negative means over budget.
     */
    public function budgetVariance(): float
    {
        return (float) $this->estimated_budget - $this->totalExpenses();
    }

    /**
     * Percentage of the estimated budget that has been spent.
     */
    public function budgetUsedPercentage(): float
    {
        if ((float) $this->estimated_budget <= 0) {
            return 0;
        }

        return round(($this->totalExpenses() / (float) $this->estimated_budget) * 100, 1);
    }

    /**
     * Tailwind colour helpers for the status badge.
     */
    public function statusColor(): string
    {
        return match ($this->status) {
            'completed' => 'bg-brand-500 text-black ring-transparent',
            'in_progress' => 'bg-black text-brand-500 ring-transparent',
            default => 'bg-white text-black ring-black/20',
        };
    }

    public function statusLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }
}
