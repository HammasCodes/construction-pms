<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgressTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'milestone',
        'planned_work',
        'completed_work',
        'completion_percentage',
        'start_date',
        'due_date',
        'status',
        'remarks',
    ];

    protected $casts = [
        'completion_percentage' => 'integer',
        'start_date' => 'date',
        'due_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function statusLabel(): string
    {
        return ucwords(str_replace('_', ' ', $this->status));
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'completed' => 'bg-brand-500 text-black ring-transparent',
            'in_progress' => 'bg-black text-brand-500 ring-transparent',
            default => 'bg-white text-black ring-black/20',
        };
    }
}
