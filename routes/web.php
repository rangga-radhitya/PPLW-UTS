<?php

use App\Http\Controllers\Staff\MenuController as StaffMenuController;
use App\Http\Controllers\Staff\CategoryController;
use App\Http\Controllers\Staff\TableController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\OutletController;
use App\Http\Controllers\Customer\MenuController;
use App\Http\Controllers\Staff\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/outlets', [OutletController::class, 'index'])->name('customer.outlets');
    Route::get('/menu', [MenuController::class, 'index'])->name('customer.menu');
});

Route::prefix('staff')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/pesanan', [OrderController::class, 'index'])->name('staff.pesanan');
    Route::resource('menu', StaffMenuController::class)->except('show')
    ->names('staff.menu');

Route::resource('kategori', CategoryController::class)->except('show')
    ->parameters(['kategori' => 'category'])
    ->names('staff.kategori');

Route::resource('meja', TableController::class)->except('show')
    ->parameters(['meja' => 'table'])
    ->names('staff.meja');
});

require __DIR__.'/auth.php';
