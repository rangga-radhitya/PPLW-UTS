<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Outlet;

class OutletController extends Controller
{
    public function index()
    {
        $outlets = Outlet::all();

        return view('customer.outlet', compact('outlets'));
    }

    public function meja($id)
    {
        $outlet = Outlet::findOrFail($id);
        $tables = $outlet->tables;

        session(['outlet_id' => $outlet->id]);

        return view('customer.meja', compact('outlet', 'tables'));
    }
}
