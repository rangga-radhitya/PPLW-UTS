<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\MenuController;
use Illuminate\Support\Facades\Route;

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

require __DIR__.'/auth.php';
