<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    FasilitasController,
    ProfileController,
    JamaahController,
    PerusahaanController,
    PaketController,
    PembayaranController,
    ReferralController,
    SuratController,
    UserController
};

// Route::get('/', function () {
//     return view('/auth/register');
// });

Route::get('/', function () {
    return view('/auth/login');
});

Route::get('/notadmin', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/master', function () {
        return view('master');
    })->name('master');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::resource('jamaah', JamaahController::class);
    Route::resource('paket', PaketController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::resource('referral', ReferralController::class);
    Route::resource('surat', SuratController::class);
    Route::resource('perusahaan', PerusahaanController::class);
    Route::resource('fasilitas', FasilitasController::class);
    Route::resource('user', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
