<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', \App\Livewire\UserList::class)->name('users');
    Route::get('/doctors', \App\Livewire\DoctorList::class)->name('doctors');
    Route::get('/appointments', \App\Livewire\AppointmentList::class)->name('appointments');
    Route::get('appointment/{appointment}', \App\Livewire\ViewAppointment::class);
    Route::get('doctors/{doctor}', \App\Livewire\ViewDoctorAppointment::class)->name('doctor.appointment');
});
