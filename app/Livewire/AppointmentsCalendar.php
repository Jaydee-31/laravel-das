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
    public $openAppointmentModal = false;
    public $appointment;

    public function events(): Collection
    {
        return Appointment::query()
            ->whereDate('date', '>=', $this->gridStartsAt)
            ->whereDate('date', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (Appointment $model) {
//                dd($model->start_time);
                return [
                    'id' => $model->id,
                    'title' => $model->name,
                    'description' => date('g:i', strtotime($model->start_time)) . ' - ' . date('g:i A', strtotime($model->end_time)),
                    'date' => $model->date,
                    'status' => $model->status, // Add status
                ];
            });
    }

    public function onEventClick($eventId)
    {
        $this->appointment = Appointment::find($eventId);

//        dd($this->appointment->doctor->user->name);
        $this->openAppointmentModal = true;
    }

    public function cancel()
    {
        $this->openAppointmentModal = false;
    }

}
