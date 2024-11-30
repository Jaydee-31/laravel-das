<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'day',
        'week',
        'start_time',
        'end_time',
        'by_appointment',
    ];

    protected $casts = [
        'week' => 'array',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
