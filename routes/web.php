<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\ScreeningStart;
use App\Livewire\Admin\Dashboard;

// Rute untuk Tamu
Route::get('/', function () {
    return view('welcome');
})->middleware('redirect.admin');

// Rute untuk Pengguna Biasa (User)
Route::middleware(['auth', 'verified', 'redirect.admin'])->group(function () {
    Route::get('/screening', ScreeningStart::class)->name('screening.start'); 
});

// Rute KHUSUS untuk Admin
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard'); 
});

require __DIR__.'/auth.php';
