<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\OutletController;
use App\Http\Controllers\Staff\OutletController as StaffOutletController;
use App\Http\Controllers\Staff\OrderController as StaffOrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/menu', [MenuController::class, 'index'])->name('customer.menu');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('customer.menu.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/menu', [MenuController::class, 'index'])->name('customer.menu');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('customer.menu.show');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/outlets', [OutletController::class, 'index'])->name('customer.outlets');
    Route::get('/menu', [MenuController::class, 'index'])->name('customer.menu');
});

Route::prefix('staff')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/pilih-outlet', [StaffOutletController::class, 'choose'])->name('staff.pilih-outlet');
    Route::post('/pilih-outlet', [StaffOutletController::class, 'store'])->name('staff.pilih-outlet.simpan');
    Route::get('/pesanan', [StaffOrderController::class, 'index'])->name('staff.pesanan');
});

require __DIR__.'/auth.php';
