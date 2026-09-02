<?php

use App\Http\Controllers\GuestComplaintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('complaints.create');
});

Route::prefix('pengaduan')->name('complaints.')->group(function () {
    Route::get('/buat', [GuestComplaintController::class, 'create'])->name('create');
    Route::post('/buat', [GuestComplaintController::class, 'store'])->name('store');

    Route::get('/lacak', [GuestComplaintController::class, 'track'])->name('track');
    Route::post('/lacak', [GuestComplaintController::class, 'show'])->name('show');
});
