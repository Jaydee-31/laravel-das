<?php

namespace App\Livewire;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;
use Omnia\LivewireCalendar\LivewireCalendar;

class AppointmentsCalendar extends LivewireCalendar
{
//    public function render()
//    {
//        return view('livewire.appointments-calendar');
//    }

    public function events() : Collection
    {
        return Appointment::query()
            ->whereDate('schedule_date', '>=', $this->gridStartsAt)
            ->whereDate('schedule_date', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (Appointment $model) {
                return [
                    'id' => $model->id,
                    'title' => $model->name,
                    'description' => date('H:i A', $model->schedule_time),
                    'date' => $model->schedule_date,
                ];
            });
    }
}
