{{-- GET /pesanan/{id}  |  variabel: $order
     Polling: public/js/status.js memanggil GET /pesanan/{id}/status tiap 5 detik --}}
@extends('layouts.customer')
@section('title', 'Status pesanan')

@section('content')
  @php
    $items   = $order->items ?? $order->orderItems ?? collect();
    $payment = $order->payment;
    $steps   = ['pending' => 'Dikirim', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Dibuat', 'ready' => 'Siap', 'done' => 'Selesai'];
    $keys    = array_keys($steps);
    $idx     = array_search($order->status, $keys);
  @endphp

  <a href="{{ url('/riwayat') }}" class="text-decoration-none small"><i class="bi bi-chevron-left"></i> Riwayat pesanan</a>

  <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mt-2">
    <div>
      <h1 class="page-title">Pesanan #{{ $order->id }}</h1>
      <p class="text-muted mb-0">
        {{ optional($order->outlet)->name }} &middot; Meja {{ optional($order->table)->table_number }} &middot; {{ $order->created_at->format('d M Y, H:i') }}
      </p>
    </div>
    <x-status-badge :status="$order->status" id="status-badge" />
  </div>

  <div id="order-tracker" data-url="{{ url('/pesanan/'.$order->id.'/status') }}" data-status="{{ $order->status }}">
    <ul class="tracker" aria-label="Tahapan pesanan">
      @foreach($steps as $key => $label)
        @php $i = array_search($key, $keys); @endphp
        <li data-step="{{ $key }}" class="{{ $i < $idx || $order->status === 'done' ? 'is-done' : ($i === $idx ? 'is-current' : '') }}">
          <span>@if($i < $idx || $order->status === 'done')<i class="bi bi-check-lg"></i>@else{{ $i + 1 }}@endif</span>{{ $label }}
        </li>
      @endforeach
    </ul>
    <p class="text-center mb-4">Status sekarang: <strong id="status-text">{{ $order->status }}</strong>
      <br><small class="text-muted"><span class="live-dot"></span>Diperbarui otomatis</small></p>
  </div>

  <div class="row g-3 align-items-start">
  <div class="col-lg-7">
  <div class="summary-box">
    <h2 class="h5 mb-3">Rincian pesanan</h2>
    @foreach($items as $item)
      <div class="d-flex justify-content-between mb-2">
        <span>{{ $item->quantity }} &times; {{ optional($item->menu)->name }}</span>
        <span>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
      </div>
    @endforeach
    <hr>
    <div class="d-flex justify-content-between fw-bold mb-3"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
    @if($payment)
      <div class="d-flex justify-content-between align-items-center">
        <span class="text-muted">Pembayaran {{ $payment->method === 'qris' ? 'QRIS' : 'tunai' }}</span>
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
      <div class="qris-box">
        <h2 class="h5 mb-2">Bayar dengan QRIS</h2>
        @if($qrisUrl)
          <img src="{{ $qrisUrl }}" alt="Kode QRIS BowlMate" class="qris-box__img">
          <a href="{{ $qrisUrl }}" download class="btn btn-sm btn-outline-primary mt-2"><i class="bi bi-download"></i> Simpan gambar QRIS</a>
        @endif
        <div class="qris-box__total">Bayar sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></div>
        <ol class="qris-box__steps">
          <li>Scan QRIS di atas dengan e-wallet atau mobile banking.</li>
          <li>Masukkan nominal sesuai total pesanan.</li>
          <li>Tunjukkan bukti pembayaran ke staff dan sebutkan <b>Pesanan #{{ $order->id }}</b>.</li>
        </ol>
        <div class="small text-muted mt-2">Pesananmu mulai dibuat setelah staff mengonfirmasi pembayaran.</div>
      </div>
    </div>
  @endif
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/status.js') }}"></script>
@endpush
