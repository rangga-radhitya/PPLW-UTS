<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    // Halaman pilih outlet untuk staff
    public function choose()
    {
        $outlets = Outlet::all();

        return view('staff.pilih-outlet', compact('outlets'));
    }

    // Simpan outlet pilihan staff ke session
    public function store(Request $request)
    {
        $request->validate(['outlet_id' => 'required|exists:outlets,id']);

        session(['staff_outlet_id' => (int) $request->outlet_id]);

        return redirect()->route('staff.pesanan');
    }

   public function meja($id)
    {
    $outlet = \App\Models\Outlet::with('tables')->findOrFail($id);
    $tables = $outlet->tables;

    session(['outlet_id' => $outlet->id]);

    return view('customer.meja', compact('outlet', 'tables'));
    }
}

