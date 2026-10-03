<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private const MAX_QTY = 20;

    // Tampilkan keranjang
    // URL: GET /keranjang
    public function index()
    {
        $cart = collect(session('cart', []))
            ->map(function ($item) {
                $item['subtotal'] = $item['price'] * $item['quantity'];
                return $item;
            })
            ->all();

        $total = collect($cart)->sum('subtotal');

        return view('customer.keranjang', compact('cart', 'total'));
    }

    // Tambah item
    // URL: POST /keranjang  (field: menu_id, quantity opsional)
    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_id'  => ['required', 'exists:menus,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:' . self::MAX_QTY],
        ]);

        $menu = Menu::findOrFail($data['menu_id']);

        if (! $menu->is_available) {
            return back()->with('error', $menu->name . ' sedang habis.');
        }

        $qty  = $data['quantity'] ?? 1;
        $cart = session('cart', []);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity'] = min(
                self::MAX_QTY,
                $cart[$menu->id]['quantity'] + $qty
            );
        } else {
            $cart[$menu->id] = [
                'id'       => $menu->id,
                'name'     => $menu->name,
                'price'    => $menu->price,
                'image'    => $menu->image,
                'quantity' => $qty,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', $menu->name . ' ditambahkan ke keranjang.');
    }

    // Ubah jumlah
    // URL: PATCH /keranjang/{id}  (field: quantity)
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . self::MAX_QTY],
        ]);

        $cart = session('cart', []);

        if (! isset($cart[$id])) {
            return redirect()->route('customer.keranjang')
                ->with('error', 'Item tidak ada di keranjang.');
        }

        $cart[$id]['quantity'] = $data['quantity'];
        session(['cart' => $cart]);

        return redirect()->route('customer.keranjang');
    }

    // Hapus item
    // URL: DELETE /keranjang/{id}
    public function destroy($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return redirect()->route('customer.keranjang')
            ->with('success', 'Item dihapus dari keranjang.');
    }
}
