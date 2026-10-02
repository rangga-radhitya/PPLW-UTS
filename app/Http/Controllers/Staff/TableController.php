<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::where('outlet_id', auth()->user()->outlet_id)
            ->orderBy('table_number')
            ->get();

        return view('staff.meja.index', compact('tables'));
    }

    public function create()
    {
        return view('staff.meja.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'table_number' => 'required|string|max:50',
            'capacity'     => 'nullable|integer|min:1',
        ]);
        $data['outlet_id'] = auth()->user()->outlet_id;

        Table::create($data);

        return redirect('/staff/meja')->with('success', 'Meja berhasil ditambahkan.');
    }

    public function edit(Table $table)
    {
        abort_unless($table->outlet_id === auth()->user()->outlet_id, 403);
        return view('staff.meja.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        abort_unless($table->outlet_id === auth()->user()->outlet_id, 403);

        $table->update($request->validate([
            'table_number' => 'required|string|max:50',
            'capacity'     => 'nullable|integer|min:1',
        ]));

        return redirect('/staff/meja')->with('success', 'Meja berhasil diubah.');
    }

    public function destroy(Table $table)
    {
        abort_unless($table->outlet_id === auth()->user()->outlet_id, 403);
        $table->delete();

        return redirect('/staff/meja')->with('success', 'Meja berhasil dihapus.');
    }
}
