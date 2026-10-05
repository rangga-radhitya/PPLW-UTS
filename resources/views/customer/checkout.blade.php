{{-- GET /checkout -> POST /pesanan  |  variabel: $cart, $total  (Figma: Payment Method / Order Summary) --}}
@extends('layouts.customer')
@section('title', 'Checkout')
@section('back', url('/keranjang'))
@section('body_class', 'no-nav')

@section('content')
  @php
    $mejaNo   = trim(\Illuminate\Support\Facades\Blade::render('<x-table-no />'));
    $outletNm = trim(\Illuminate\Support\Facades\Blade::render('<x-outlet-name />'));
    $method   = old('payment_method', 'qris');
    $items    = collect($cart)->sum(fn ($i) => data_get($i, 'quantity', 1));
  @endphp

  <form method="POST" action="{{ url('/pesanan') }}" class="checkout">
    @csrf
    @if($outletNm !== '' || $mejaNo !== '')
      <div class="order-context">
        <span class="order-context__icon"><i class="bi bi-shop"></i></span>
        <div>
          <small>KONTEKS PESANAN</small>
          <b>{{ $outletNm ?: 'BowlMate' }}</b>
          <span>Dine-in{{ $mejaNo !== '' ? ' • Meja '.$mejaNo : '' }}</span>
        </div>
      </div>
    @endif

    <section class="card-box">
      <div class="card-box__head"><span class="card-box__icon"><i class="bi bi-receipt"></i></span><h2>Ringkasan Pesanan</h2><span class="pill pill--butter ms-auto">{{ $items }} item</span></div>
      @foreach($cart as $item)
        <div class="sum-row">
          <x-menu-image :image="data_get($item, 'image')" :name="data_get($item, 'name')" />
          <div class="grow"><b>{{ data_get($item, 'name') }}</b><small>{{ data_get($item, 'quantity', 1) }}&times; &bull; Rp{{ number_format(data_get($item, 'price', 0), 0, ',', '.') }}</small></div>
          <span class="sum-row__price">Rp{{ number_format(data_get($item, 'price', 0) * data_get($item, 'quantity', 1), 0, ',', '.') }}</span>
        </div>
      @endforeach
      <div class="sum-total"><span>Total Bayar</span><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></div>
    </section>

    <h2 class="section-title"><i class="bi bi-wallet2"></i> Metode Pembayaran</h2>

    <label class="pay-card">
      <input class="visually-hidden" type="radio" name="payment_method" value="qris" data-label="QRIS" {{ $method === 'qris' ? 'checked' : '' }}>
      <span class="pay-card__check"><i class="bi bi-check-lg"></i></span>
      <span class="pay-card__icon"><i class="bi bi-qr-code-scan"></i></span>
      <div>
        <b>QRIS <small class="tag">Non-tunai</small></b>
        <span>Bayar digital lewat e-wallet atau mobile banking.</span>
        <em class="pay-card__hint {{ $method === 'qris' ? '' : 'd-none' }}" data-pay-hint="qris"><i class="bi bi-info-circle"></i> Kode QRIS tampil di halaman pesananmu setelah memesan. Tunjukkan bukti bayar ke staff untuk konfirmasi.</em>
      </div>
    </label>

    <label class="pay-card">
      <input class="visually-hidden" type="radio" name="payment_method" value="cash" data-label="Tunai" {{ $method === 'cash' ? 'checked' : '' }}>
      <span class="pay-card__check"><i class="bi bi-check-lg"></i></span>
      <span class="pay-card__icon"><i class="bi bi-cash-stack"></i></span>
      <div>
        <b>Tunai <small class="tag">Bayar di tempat</small></b>
        <span>Bayar langsung ke staff di mejamu.</span>
        <em class="pay-card__hint {{ $method === 'cash' ? '' : 'd-none' }}" data-pay-hint="cash"><i class="bi bi-info-circle"></i> Siapkan uang pas, atau kembalian akan diberikan oleh staff.</em>
      </div>
    </label>

    <div class="checkout-bar">
      <div class="checkout-bar__top">
        <div><small>TOTAL BAYAR</small><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></div>
        <div class="text-end"><small>Metode</small><b data-pay-label>{{ $method === 'cash' ? 'Tunai' : 'QRIS' }}</b></div>
      </div>
      <button class="btn btn-primary btn-xl w-100">Pesan Sekarang <i class="bi bi-arrow-right"></i></button>
    </div>
  </form>
@endsection
