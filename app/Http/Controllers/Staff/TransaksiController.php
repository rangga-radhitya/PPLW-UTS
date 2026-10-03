<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class TransaksiController extends Controller
{
    // Daftar pembayaran outlet yang dipilih staff
    // URL: GET /staff/transaksi  (variabel: $payments, relasi order.table)
    public function index()
    {
        $outletId = session('staff_outlet_id');

        if (! $outletId) {
            return redirect()->route('staff.pilih-outlet')
                ->with('error', 'Pilih outlet dulu.');
        }

        $payments = Payment::with('order.table')
            ->whereHas('order', fn ($q) => $q->where('outlet_id', $outletId))
            ->latest()
            ->paginate(15);

        return view('staff.transaksi', compact('payments'));
    }
}
