<?php

use App\Http\Controllers\GuestComplaintController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lapor', [GuestComplaintController::class, 'create'])->name('complaints.create');
Route::post('/lapor', [GuestComplaintController::class, 'store'])->name('complaints.store');

Route::get('/cek-status', [GuestComplaintController::class, 'track'])->name('complaints.track');
Route::post('/cek-status', [GuestComplaintController::class, 'show'])->name('complaints.show');

Route::prefix('pengaduan')->name('complaints_old.')->group(function () {
    Route::get('/buat', [GuestComplaintController::class, 'create'])->name('create');
    Route::post('/buat', [GuestComplaintController::class, 'store'])->name('store');

    Route::get('/lacak', [GuestComplaintController::class, 'track'])->name('track');
    Route::post('/lacak', [GuestComplaintController::class, 'show'])->name('show');
});

Route::get('/symlink', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return 'Symlink berhasil dibuat! Silakan hapus atau nonaktifkan route ini untuk keamanan.';
    } catch (\Exception $e) {
        return 'Gagal membuat symlink: ' . $e->getMessage();
    }
});
