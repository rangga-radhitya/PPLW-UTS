{{-- GET /keranjang  |  variabel: $cart, $total  (Figma: My Cart)
     Asumsi $cart (session): [ menu_id => ['name','price','quantity','image'], ... ] --}}
@extends('layouts.customer')
@section('title', 'Keranjang')

@section('content')
  <div data-live-slot="cart-live">
    @php $count = is_countable($cart) ? count($cart) : 0; $items = collect($cart)->sum(fn ($i) => data_get($i, 'quantity', 1)); @endphp

    <div class="d-flex align-items-center gap-2 mb-2">
      <h1 class="page-title mb-0">Keranjangku</h1>
      @if($count > 0)<span class="pill pill--butter">{{ $items }} item</span>@endif
    </div>

    @if($count === 0)
      <div class="empty-state">
        <span class="empty-state__bowl"><i class="bi bi-basket3"></i></span>
        <h2 class="h5 mt-2">Keranjangmu masih kosong</h2>
        <p>Yuk pilih rice bowl favoritmu dulu.</p>
        <a href="{{ url('/menu') }}" class="btn btn-primary"><i class="bi bi-egg-fried"></i> Lihat menu</a>
      </div>
    @else
      @php $mejaNo = trim(\Illuminate\Support\Facades\Blade::render('<x-table-no />')); $outletNm = trim(\Illuminate\Support\Facades\Blade::render('<x-outlet-name />')); @endphp
      <div class="context-pill mb-3">
        <b class="text-navy">DINE-IN</b>
        @if($outletNm !== '')<span>{{ $outletNm }}</span>@endif
        @if($mejaNo !== '')<b class="text-rust">Meja {{ $mejaNo }}</b>@endif
        <a href="{{ url('/menu') }}" class="ms-auto text-rust fw-bold text-decoration-none"><i class="bi bi-plus-circle"></i> Tambah menu</a>
      </div>

      <div class="row g-3">
        <div class="col-lg-7">
          @foreach($cart as $id => $item)
            @php $price = data_get($item, 'price', 0); $qty = data_get($item, 'quantity', 1); @endphp
            <div class="cart-row">
              <x-menu-image :image="data_get($item, 'image')" :name="data_get($item, 'name')" />
              <div class="grow">
                <div class="d-flex justify-content-between gap-2">
                  <div class="cart-row__name">{{ data_get($item, 'name') }}</div>
                  <form method="POST" action="{{ url('/keranjang/'.$id) }}" data-live data-live-remove=".cart-row" data-live-toast="Menu dihapus dari keranjang">
                    @csrf @method('DELETE')
                    <button class="icon-btn" aria-label="Hapus {{ data_get($item, 'name') }}"><i class="bi bi-trash3"></i></button>
                  </form>
                </div>
                <div class="cart-row__unit">Satuan Rp{{ number_format($price, 0, ',', '.') }}</div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                  <div class="cart-row__sum">Rp{{ number_format($price * $qty, 0, ',', '.') }}</div>
                  <form method="POST" action="{{ url('/keranjang/'.$id) }}" data-live data-live-toast="Jumlah diperbarui">
                    @csrf @method('PATCH')
                    <div class="qty qty--lg" data-qty data-autosubmit>
                      <button type="button" data-step="-1" aria-label="Kurangi">&minus;</button>
                      <input type="number" name="quantity" value="{{ $qty }}" min="1" max="20" aria-label="Jumlah">
                      <button type="button" data-step="1" aria-label="Tambah">+</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="col-lg-5">
          <div class="bill">
            <div class="bill__head"><h2>Rincian Tagihan</h2>@if($outletNm !== '')<small>{{ $outletNm }}</small>@endif</div>
            <div class="bill__row"><span>Subtotal ({{ $items }} item)</span><b>Rp{{ number_format($total, 0, ',', '.') }}</b></div>
            @if($mejaNo !== '')<div class="bill__note"><i class="bi bi-egg-fried"></i> Diantar langsung ke <b class="text-rust">Meja {{ $mejaNo }}</b></div>@endif
            <div class="bill__total">
              <div><small>TOTAL BAYAR</small><span>Sudah termasuk semua item</span></div>
              <strong data-live-slot="cart-total" data-live-tick>Rp{{ number_format($total, 0, ',', '.') }}</strong>
            </div>
          </div>
          <a href="{{ url('/checkout') }}" class="btn btn-primary btn-xl w-100 mt-3 checkout-cta">
            <span><i class="bi bi-lightning-charge-fill"></i> Lanjut ke Checkout</span>
            <b>Rp{{ number_format($total, 0, ',', '.') }} <i class="bi bi-arrow-right"></i></b>
          </a>
        </div>
      </div>
    @endif
  </div>
@endsection
