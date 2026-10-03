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

    // Form info outlet
    // URL: GET /staff/outlet  (variabel: $outlet)
    public function edit()
    {
        $outletId = session('staff_outlet_id');

        if (! $outletId) {
            return redirect()->route('staff.pilih-outlet')
                ->with('error', 'Pilih outlet dulu.');
        }

        $outlet = Outlet::findOrFail($outletId);

        return view('staff.outlet', compact('outlet'));
    }

    // Simpan perubahan info outlet
    // URL: PUT /staff/outlet
    public function update(Request $request)
    {
        $outletId = session('staff_outlet_id');

        if (! $outletId) {
            return redirect()->route('staff.pilih-outlet')
                ->with('error', 'Pilih outlet dulu.');
        }

        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'address'    => ['required', 'string', 'max:500'],
            'open_hours' => ['required', 'string', 'max:100'],
            'phone'      => ['nullable', 'string', 'max:30'],
        ]);

        Outlet::findOrFail($outletId)->update($data);

        return redirect()->route('staff.outlet')
            ->with('success', 'Info outlet diperbarui.');
    }
}
