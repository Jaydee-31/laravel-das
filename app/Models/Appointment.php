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
        'schedule_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'doctor_id',
        'added_by_id',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'date',
            'date' => 'datetime',
//            'start_time' => 'time',
//            'end_time' => 'time',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by_id', 'id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class, 'schedule_id', 'id');
    }
}
