<?php

use App\Http\Controllers\Staff\CategoryController;
use App\Http\Controllers\Staff\TableController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\MenuController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Customer\OutletController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Staff\OrderController as StaffOrderController;
use App\Http\Controllers\Staff\OutletController as StaffOutletController;
use App\Http\Controllers\Staff\MenuController as StaffMenuController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    return $request->user()->role === 'staff'
        ? redirect()->route('staff.pilih-outlet')
        : redirect()->route('customer.outlets');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/outlets', [OutletController::class, 'index'])->name('customer.outlets');
    Route::get('/outlets/{id}/meja', [OutletController::class, 'meja'])->name('customer.meja');
    Route::get('/menu', [MenuController::class, 'index'])->name('customer.menu');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('customer.menu.show');

    Route::get('/keranjang', [CartController::class, 'index'])->name('customer.keranjang');
    Route::post('/keranjang', [CartController::class, 'store'])->name('customer.keranjang.tambah');
    Route::patch('/keranjang/{id}', [CartController::class, 'update'])->name('customer.keranjang.ubah');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('customer.keranjang.hapus');

        Route::get('/checkout', [OrderController::class, 'checkout'])->name('customer.checkout');
    Route::post('/pesanan', [OrderController::class, 'store'])->name('customer.pesanan.simpan');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('customer.pesanan');
    Route::get('/pesanan/{id}/status', [OrderController::class, 'status'])->name('customer.pesanan.status');
    Route::get('/riwayat', [OrderController::class, 'riwayat'])->name('customer.riwayat');
});

Route::prefix('staff')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/pilih-outlet', [StaffOutletController::class, 'choose'])->name('staff.pilih-outlet');
    Route::post('/pilih-outlet', [StaffOutletController::class, 'store'])->name('staff.pilih-outlet.simpan');

    Route::get('/pesanan', [StaffOrderController::class, 'index'])->name('staff.pesanan');

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
