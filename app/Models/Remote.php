<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Remote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'have_plan',
        'approver_id',
        'reason',
        'remedies',
        'reject_reason',
        'status',
    ];

    public function remotePeriods(): HasMany
    {
        return $this->hasMany(RemotePeriod::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
