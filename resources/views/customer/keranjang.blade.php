{{-- GET /keranjang  |  variabel: $cart, $total
     Asumsi bentuk $cart (dari session): [ menu_id => ['name'=>..., 'price'=>..., 'quantity'=>..., 'image'=>...], ... ] --}}
@extends('layouts.customer')
@section('title', 'Keranjang')

@section('content')
  <h1 class="page-title">Keranjang</h1>

  @if(empty($cart) || count($cart) === 0)
    <div class="empty-state">
      <i class="bi bi-basket3"></i>
      Keranjangmu masih kosong.<br>
      <a href="{{ url('/menu') }}" class="btn btn-primary mt-3">Lihat menu</a>
    </div>
  @else
    <div class="row g-4">
      <div class="col-lg-8">
        @foreach($cart as $id => $item)
          @php
            $price = data_get($item, 'price', 0);
            $qty   = data_get($item, 'quantity', 1);
          @endphp
          <div class="cart-row">
            <x-menu-image :image="data_get($item, 'image')" :name="data_get($item, 'name')" />
            <div class="grow">
              <div class="fw-bold">{{ data_get($item, 'name') }}</div>
              <div class="text-muted small">Rp {{ number_format($price, 0, ',', '.') }}</div>
              <div class="fw-bold text-end d-md-none">Rp {{ number_format($price * $qty, 0, ',', '.') }}</div>
            </div>

            <form method="POST" action="{{ url('/keranjang/'.$id) }}">
              @csrf @method('PATCH')
              <div class="qty" data-qty data-autosubmit>
                <button type="button" data-step="-1" aria-label="Kurangi">&minus;</button>
                <input type="number" name="quantity" value="{{ $qty }}" min="1" max="20" aria-label="Jumlah">
                <button type="button" data-step="1" aria-label="Tambah">+</button>
              </div>
            </form>

            <div class="fw-bold d-none d-md-block text-end" style="min-width:110px">Rp {{ number_format($price * $qty, 0, ',', '.') }}</div>

            <form method="POST" action="{{ url('/keranjang/'.$id) }}" data-confirm="Hapus {{ data_get($item, 'name') }} dari keranjang?">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger" aria-label="Hapus"><i class="bi bi-trash"></i></button>
            </form>
          </div>
        @endforeach
        <a href="{{ url('/menu') }}" class="text-decoration-none"><i class="bi bi-plus-lg"></i> Tambah menu lain</a>
      </div>

      <div class="col-lg-4">
        <div class="summary-box">
          <h2 class="h5">Ringkasan</h2>
          <div class="d-flex justify-content-between my-3">
            <span>Total</span><span class="price-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>
          <a href="{{ url('/checkout') }}" class="btn btn-primary w-100">Lanjut ke checkout</a>
        </div>
      </div>
    </div>
  @endif
@endsection
