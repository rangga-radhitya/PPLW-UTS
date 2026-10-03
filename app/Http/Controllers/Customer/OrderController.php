<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Halaman checkout
    // URL: GET /checkout  (variabel: $cart, $total)
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('customer.keranjang')
                ->with('error', 'Keranjangmu masih kosong.');
        }

        if (! session('outlet_id') || ! session('table_id')) {
            return redirect()->route('customer.outlets')
                ->with('error', 'Pilih outlet dan meja dulu sebelum checkout.');
        }

        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);

        return view('customer.checkout', compact('cart', 'total'));
    }

    // Buat pesanan (orders + order_items + payments sekaligus)
    // URL: POST /pesanan  (field: payment_method = qris|cash)
    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_method' => ['required', 'in:qris,cash'],
        ]);

        $cart     = session('cart', []);
        $outletId = session('outlet_id');
        $tableId  = session('table_id');

        if (empty($cart)) {
            return redirect()->route('customer.keranjang')
                ->with('error', 'Keranjangmu masih kosong.');
        }

        if (! $outletId || ! $tableId) {
            return redirect()->route('customer.outlets')
                ->with('error', 'Pilih outlet dan meja dulu sebelum checkout.');
        }

        // Pastikan meja memang milik outlet yang dipilih
        $table = Table::where('id', $tableId)->where('outlet_id', $outletId)->first();

        if (! $table) {
            session()->forget('table_id');

            return redirect()->route('customer.outlets')
                ->with('error', 'Meja tidak valid, pilih meja lagi.');
        }

        // Harga dan ketersediaan dibaca ulang dari database
        $menus = Menu::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $habis = [];
        foreach ($cart as $id => $item) {
            $menu = $menus->get($id);

            if (! $menu || ! $menu->is_available) {
                $habis[] = $item['name'];
            }
        }

        if ($habis) {
            return redirect()->route('customer.keranjang')
                ->with('error', 'Menu berikut sedang tidak tersedia: ' . implode(', ', $habis) . '. Hapus dulu dari keranjang.');
        }

        $order = DB::transaction(function () use ($cart, $menus, $data, $outletId, $tableId, $request) {
            $total = 0;
            foreach ($cart as $id => $item) {
                $total += (int) $menus->get($id)->price * $item['quantity'];
            }

            $order = Order::create([
                'user_id'   => $request->user()->id,
                'outlet_id' => $outletId,
                'table_id'  => $tableId,
                'status'    => 'pending',
                'total'     => $total,
            ]);

            foreach ($cart as $id => $item) {
                $order->items()->create([
                    'menu_id'  => $id,
                    'quantity' => $item['quantity'],
                    'price'    => (int) $menus->get($id)->price,
                ]);
            }

            $order->payment()->create([
                'method' => $data['payment_method'],
                'status' => 'pending',
            ]);

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('customer.pesanan', $order->id)
            ->with('success', 'Pesanan berhasil dibuat.');
    }

    // Halaman status pesanan
    // URL: GET /pesanan/{id}  (variabel: $order)
    public function show(Request $request, $id)
    {
        $order = Order::with(['items.menu', 'payment', 'table', 'outlet'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return view('customer.status', compact('order'));
    }

    // JSON untuk polling status.js tiap 5 detik
    // URL: GET /pesanan/{id}/status
    public function status(Request $request, $id)
    {
        $order = Order::with('payment')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'status'         => $order->status,
            'payment_status' => optional($order->payment)->status,
        ]);
    }

    // Riwayat pesanan milik user yang login
    // URL: GET /riwayat  (variabel: $orders)
    public function riwayat(Request $request)
    {
        $orders = Order::with(['items.menu', 'payment'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('customer.riwayat', compact('orders'));
    }
}
