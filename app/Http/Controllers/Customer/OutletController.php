<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();

        return view('customer.outlet', compact('outlets'));
    }

    // URL: /outlets/{id}/meja atau /outlets/{id}/meja?no=5 (hasil scan QR)
    public function meja(Request $request, $id)
    {
        $outlet = Outlet::findOrFail($id);
        $tables = $outlet->tables;

        session(['outlet_id' => $outlet->id]);

        // Simpan meja yang dipilih. Kalau tidak ada atau tidak valid, kosongkan
        // supaya tidak terbawa meja dari outlet sebelumnya.
        $table = $request->filled('no')
            ? $tables->firstWhere('table_number', $request->no)
            : null;

        if ($table) {
            session(['table_id' => $table->id]);
        } else {
            session()->forget('table_id');
        }

        return view('customer.meja', compact('outlet', 'tables'));
    }
}
