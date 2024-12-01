<?php

namespace App\Livewire;

use App\Models\Appointment;
use Illuminate\Support\Collection;
use Omnia\LivewireCalendar\LivewireCalendar;

class AppointmentsCalendar extends LivewireCalendar
{
//    public function render()
//    {
//        return view('livewire.appointments-calendar');
//    }

    public function events(): Collection
    {
        return Appointment::query()
            ->whereDate('date', '>=', $this->gridStartsAt)
            ->whereDate('date', '<=', $this->gridEndsAt)
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
