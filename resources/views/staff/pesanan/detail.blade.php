{{-- GET /staff/pesanan/{id}  |  variabel: $order  (Figma: Order Detail) --}}
@extends('layouts.staff')
@section('title', 'Pesanan #'.$order->id)

@section('content')
  @php
    $items = $order->items ?? $order->orderItems ?? collect();
    $pay   = $order->payment;
    $steps = [
      'pending'    => ['1. Pending',    'Perlu konfirmasi', 'bi-hourglass-split'],
      'confirmed'  => ['2. Confirmed',  'Diterima dapur',   'bi-check-circle'],
      'processing' => ['3. Processing', 'Sedang dimasak',   'bi-fire'],
      'ready'      => ['4. Ready',      'Siap diantar',     'bi-bell'],
      'done'       => ['5. Done',       'Selesai',          'bi-check2-all'],
    ];
    $keys = array_keys($steps);
    $idx  = array_search($order->status, $keys);
  @endphp

  <nav class="crumbs"><a href="{{ url('/staff/pesanan') }}"><i class="bi bi-receipt"></i> Pesanan</a> <i class="bi bi-chevron-right"></i> <span>Detail Pesanan <x-order-code :id="$order->id" /></span></nav>

  <section class="panel order-head">
    <span class="order-head__icon"><i class="bi bi-receipt"></i></span>
    <div class="grow">
      <div class="d-flex flex-wrap align-items-center gap-2"><h1 class="page-title mb-0">Pesanan <x-order-code :id="$order->id" /></h1><x-status-badge :status="$order->status" /></div>
      <div class="text-muted small">{{ $order->created_at->locale('id')->translatedFormat('l, d M Y') }} &bull; {{ $order->created_at->format('H:i') }} WIB</div>
      <div class="order-head__facts">
        <div><i class="bi bi-grid-3x3-gap"></i><small>NOMOR MEJA</small><b>Meja {{ optional($order->table)->table_number }}</b></div>
        <div><i class="bi bi-person"></i><small>NAMA PEMESAN</small><b>{{ optional($order->user)->name }}</b></div>
        <div><i class="bi bi-telephone"></i><small>TELEPON</small><b>{{ optional($order->user)->phone ?: '-' }}</b></div>
      </div>
    </div>
  </section>

  <section class="panel mt-3">
    <p class="list-label mb-2">PROGRES STATUS PESANAN</p>
    <ul class="progress-steps">
      @foreach($steps as $key => [$title, $sub, $icon])
        @php $i = array_search($key, $keys); @endphp
        <li class="{{ $i < $idx || $order->status === 'done' ? 'is-done' : ($i === $idx ? 'is-current' : '') }}">
          <span><i class="bi {{ $icon }}"></i></span><b>{{ $title }}</b><small>{{ $sub }}</small>
        </li>
      @endforeach
    </ul>
  </section>

  <div class="row g-3 mt-0">
    <div class="col-lg-8">
      <section class="panel p-0 overflow-hidden">
        <div class="panel-head panel-head--pad"><h2 class="h6 mb-0"><i class="bi bi-bag text-rust"></i> Daftar Item Pesanan ({{ count($items) }} menu)</h2><span class="pill">Dine In</span></div>
        @foreach($items as $item)
          <div class="item-row">
            <x-menu-image :image="optional($item->menu)->image" :name="optional($item->menu)->name" class="item-row__img" />
            <div class="grow">
              <div class="d-flex justify-content-between gap-2"><span><span class="qty-chip">{{ $item->quantity }}x</span> <b>{{ optional($item->menu)->name }}</b></span><b>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</b></div>
              <small class="text-muted">Rp{{ number_format($item->price, 0, ',', '.') }} / porsi</small>
            </div>
          </div>
        @endforeach
      </section>
    </div>

    <div class="col-lg-4">
      <section class="panel">
        <h2 class="h6 mb-3 d-flex justify-content-between">Ringkasan Biaya <i class="bi bi-receipt text-muted"></i></h2>
        <div class="kv"><span>Subtotal ({{ count($items) }} menu)</span><b>Rp{{ number_format($order->total, 0, ',', '.') }}</b></div>
        <div class="kv kv--total"><span><small>TOTAL AKHIR</small></span><strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></div>
        <hr class="my-3">
        <div class="kv"><span>Metode Pembayaran</span><b>{{ $pay ? ($pay->method === 'qris' ? 'QRIS' : 'Tunai') : '-' }}</b></div>
        <div class="kv"><span>Status Pembayaran</span>@if($pay)<x-pay-badge :status="$pay->status" />@else<b>-</b>@endif</div>
        <div class="kv"><span>Outlet</span><b>{{ optional($order->outlet)->name }}</b></div>
      </section>

      @if($order->status === 'pending')
        <div class="info-box info-box--navy mt-3"><i class="bi bi-info-circle"></i><span><b>Instruksi:</b> klik <b>Terima pesanan</b> agar pesanan diteruskan ke dapur. Pembayaran akan ditandai lunas.</span></div>
      @endif

      @if($order->status !== 'done')
        <section class="panel mt-3">
          <p class="list-label mb-2">AKSI CEPAT STAF</p>
          <x-order-action :order="$order" :block="true" />
        </section>
      @endif
    </div>
  </div>
@endsection
