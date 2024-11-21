<?php

use App\Livewire\BannerList;
use App\Livewire\CountryList;
use App\Livewire\VendorList;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

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
    Route::get('/vendors', function () {
        return view('livewire.vendors.index');
    })->name('vendors');
    Route::get('/appointments', function () {
        return view('livewire.appointments.index');
    })->name('appointments');

    Route::get('/banners', BannerList::class)->name('banners');
    Route::get('/countries', CountryList::class)->name('countries');
    Route::get('/users', \App\Livewire\UserList::class);
});
