<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private const ACTIVE = ['pending', 'confirmed', 'processing', 'ready'];

    // Urutan status. Tombol hanya boleh menaikkan satu tahap.
    private const NEXT = [
        'pending'    => 'confirmed',
        'confirmed'  => 'processing',
        'processing' => 'ready',
        'ready'      => 'done',
    ];

    // Daftar pesanan aktif outlet yang dipilih staff
    // URL: GET /staff/pesanan  (variabel: $orders)
    public function index()
    {
        $outletId = session('staff_outlet_id');

        if (! $outletId) {
            return redirect()->route('staff.pilih-outlet')
                ->with('error', 'Pilih outlet dulu.');
        }

        $orders = Order::with(['table', 'user', 'payment'])
            ->where('outlet_id', $outletId)
            ->whereIn('status', self::ACTIVE)
            ->oldest()
            ->get();

        return view('staff.pesanan.index', compact('orders'));
    }

    // Pesanan yang sudah selesai
    // URL: GET /staff/pesanan-selesai  (variabel: $orders, paginasi)
    public function selesai()
    {
        $outletId = session('staff_outlet_id');

        if (! $outletId) {
            return redirect()->route('staff.pilih-outlet')
                ->with('error', 'Pilih outlet dulu.');
        }

        $orders = Order::with(['table', 'user', 'payment'])
            ->where('outlet_id', $outletId)
            ->where('status', 'done')
            ->latest()
            ->paginate(15);

        return view('staff.pesanan.selesai', compact('orders'));
    }

    // Detail satu pesanan
    // URL: GET /staff/pesanan/{id}  (variabel: $order)
    public function show($id)
    {
        $outletId = session('staff_outlet_id');

        if (! $outletId) {
            return redirect()->route('staff.pilih-outlet')
                ->with('error', 'Pilih outlet dulu.');
        }

        $order = Order::with(['items.menu', 'user', 'outlet', 'table', 'payment'])
            ->where('outlet_id', $outletId)
            ->findOrFail($id);

        return view('staff.pesanan.detail', compact('order'));
    }

    // Naikkan status pesanan satu tahap
    // URL: PATCH /staff/pesanan/{id}/status  (field: status)
    public function updateStatus(Request $request, $id)
    {
        $outletId = session('staff_outlet_id');

        if (! $outletId) {
            return redirect()->route('staff.pilih-outlet')
                ->with('error', 'Pilih outlet dulu.');
        }

        $data = $request->validate([
            'status' => ['required', 'in:confirmed,processing,ready,done'],
        ]);

        $order = Order::with('payment')
            ->where('outlet_id', $outletId)
            ->findOrFail($id);

        // Hanya boleh maju satu tahap dari status sekarang
        if ((self::NEXT[$order->status] ?? null) !== $data['status']) {
            return back()->with('error', 'Status pesanan #' . $order->id . ' sudah berubah. Muat ulang halaman.');
        }

        DB::transaction(function () use ($order, $data) {
            $order->update(['status' => $data['status']]);

            // Pesanan diterima = staff sudah memastikan pembayaran (bukti QRIS / uang tunai)
            if ($data['status'] === 'confirmed' && $order->payment && $order->payment->status !== 'paid') {
                $order->payment->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                ]);
            }
        });

        return back()->with('success', 'Pesanan #' . $order->id . ' diperbarui.');
    }
}
