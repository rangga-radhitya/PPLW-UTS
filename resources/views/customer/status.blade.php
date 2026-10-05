{{-- GET /pesanan/{id}  |  variabel: $order  (Figma: Order Tracking / Scan to Pay)
     Polling: public/js/status.js memanggil GET /pesanan/{id}/status tiap 5 detik --}}
@extends('layouts.customer')
@section('title', 'Status pesanan')
@section('back', url('/riwayat'))

@section('content')
  @php
    $items   = $order->items ?? $order->orderItems ?? collect();
    $payment = $order->payment;
    $steps   = ['pending' => 'Dikirim', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Dibuat', 'ready' => 'Siap', 'done' => 'Selesai'];
    $keys    = array_keys($steps);
    $idx     = array_search($order->status, $keys);
  @endphp

  <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
    <div>
      <h1 class="page-title mb-1">Pesanan <x-order-code :id="$order->id" /></h1>
      <p class="text-muted small mb-0"><i class="bi bi-clock"></i> {{ $order->created_at->locale('id')->translatedFormat('d M Y, H:i') }} WIB<br>
        <i class="bi bi-shop"></i> {{ optional($order->outlet)->name }} &bull; Meja {{ optional($order->table)->table_number }}</p>
    </div>
    <x-status-badge :status="$order->status" id="status-badge" />
  </div>

  <div id="order-tracker" class="panel mt-3" data-url="{{ url('/pesanan/'.$order->id.'/status') }}" data-status="{{ $order->status }}">
    <ul class="tracker" aria-label="Tahapan pesanan">
      @foreach($steps as $key => $label)
        @php $i = array_search($key, $keys); @endphp
        <li data-step="{{ $key }}" class="{{ $i < $idx || $order->status === 'done' ? 'is-done' : ($i === $idx ? 'is-current' : '') }}">
          <span>@if($i < $idx || $order->status === 'done')<i class="bi bi-check-lg"></i>@else{{ $i + 1 }}@endif</span>{{ $label }}
        </li>
      @endforeach
    </ul>
    <p class="text-center mb-0">Status sekarang: <strong id="status-text">{{ $order->status }}</strong>
      <br><small class="text-muted"><span class="live-dot"></span>Diperbarui otomatis</small></p>
  </div>

  <div class="row g-3 mt-1 align-items-start">
    <div class="col-lg-7">
      <div class="panel">
        <h2 class="h6 mb-3"><i class="bi bi-receipt text-rust"></i> Rincian pesanan</h2>
        @foreach($items as $item)
          <div class="sum-row">
            <x-menu-image :image="optional($item->menu)->image" :name="optional($item->menu)->name" />
            <div class="grow"><b>{{ optional($item->menu)->name }}</b><small>{{ $item->quantity }}&times; &bull; Rp{{ number_format($item->price, 0, ',', '.') }}</small></div>
            <span class="sum-row__price">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
          </div>
        @endforeach
        <div class="sum-total"><span>Total</span><strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></div>
        @if($payment)
          <div class="d-flex justify-content-between align-items-center mt-2">
            <span class="text-muted small">Pembayaran {{ $payment->method === 'qris' ? 'QRIS' : 'tunai' }}</span>
            <x-pay-badge :status="$payment->status" id="payment-badge" />
          </div>
        @endif
      </div>
    </div>

    @if($payment && $payment->method === 'qris')
      @php
        $qrisFile = collect(glob(public_path('images/qris/*.*')) ?: [])->first();
        $qrisUrl  = $qrisFile ? asset('images/qris/'.rawurlencode(basename($qrisFile))) : null;
        $hideQr   = $payment->status === 'paid' || $order->status !== 'pending';
      @endphp
      <div class="col-lg-5 {{ $hideQr ? 'd-none' : '' }}" id="qris-panel">
        <div class="qris-card">
          <div class="qris-card__wait"><i class="bi bi-hourglass-split"></i> Menunggu pembayaran</div>
          <h2 class="h5 mb-1">Scan untuk Bayar</h2>
          <p class="text-muted small">Scan dengan e-wallet atau mobile banking apa pun.</p>
          @if($qrisUrl)
            <img src="{{ $qrisUrl }}" alt="Kode QRIS BowlMate" class="qris-box__img">
            <a href="{{ $qrisUrl }}" download class="btn btn-sm btn-outline-primary mt-2"><i class="bi bi-download"></i> Simpan gambar</a>
          @endif
          <div class="qris-card__amount">
            <div><small>Total pembayaran</small><strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></div>
            <button type="button" class="btn btn-yolk btn-sm" data-copy="{{ (int) $order->total }}"><i class="bi bi-copy"></i> Salin nominal</button>
          </div>
          <div class="info-box"><i class="bi bi-info-circle"></i><span>Setelah bayar, tunjukkan bukti pembayaran ke staff dan sebutkan <b><x-order-code :id="$order->id" /></b>. Pesananmu mulai dibuat setelah staff mengonfirmasi.</span></div>
        </div>
      </div>
    @endif
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/status.js') }}"></script>
@endpush
