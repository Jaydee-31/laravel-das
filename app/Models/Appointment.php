<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'gender',
        'birthdate',
        'schedule_date',
        'schedule_time',
        'doctor',
        'added_by_id',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'schedule_date' => 'datetime',
            'schedule_time' => 'timestamp',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id',  'id');
    }
}
