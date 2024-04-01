<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemotePeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'start',
        'end',
        'total',
    ];

    public function remote(): BelongsTo
    {
        return $this->belongsTo(Remote::class);
    }
}
