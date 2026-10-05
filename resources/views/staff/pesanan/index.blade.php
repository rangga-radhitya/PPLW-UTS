{{-- GET /staff/pesanan  |  variabel: $orders (status aktif)  (Figma: Dashboard / Incoming Order)
     Polling: public/js/staff-orders.js menyegarkan isi #orders-live tiap 5 detik --}}
@extends('layouts.staff')
@section('title', 'Pesanan masuk')

@section('content')
  <div class="page-head">
    <div>
      <h1 class="page-title">Pesanan Masuk</h1>
      <p class="text-muted mb-0">Pantau pesanan masuk dan antrean dapur secara real-time.</p>
    </div>
    <span class="live-badge"><span class="live-dot"></span> Diperbarui otomatis</span>
  </div>

  <div id="orders-live" data-url="{{ request()->url() }}">
    @php
      $all = collect($orders);
      $nPending = $all->where('status', 'pending')->count();
      $nProcess = $all->whereIn('status', ['confirmed', 'processing'])->count();
      $nReady   = $all->where('status', 'ready')->count();
    @endphp
    <div class="row g-3 mb-3">
      <div class="col-6 col-xl-3"><div class="stat stat--navy"><div><div class="stat__label">Pesanan Aktif</div><div class="stat__num">{{ $all->count() }} <small>Pesanan</small></div></div><i class="bi bi-receipt"></i></div></div>
      <div class="col-6 col-xl-3"><div class="stat stat--rust {{ $nPending ? 'stat--attn' : '' }}"><div><div class="stat__label text-rust">Menunggu Konfirmasi</div><div class="stat__num">{{ $nPending }} <small>Pesanan</small></div>@if($nPending)<span class="stat__tag">Perlu tindakan staf segera</span>@endif</div><i class="bi bi-hourglass-split"></i></div></div>
      <div class="col-6 col-xl-3"><div class="stat stat--butter"><div><div class="stat__label">Sedang Dibuat</div><div class="stat__num">{{ $nProcess }} <small>Pesanan</small></div></div><i class="bi bi-fire"></i></div></div>
      <div class="col-6 col-xl-3"><div class="stat stat--green"><div><div class="stat__label">Siap Diantar</div><div class="stat__num">{{ $nReady }} <small>Pesanan</small></div></div><i class="bi bi-bell"></i></div></div>
    </div>

    <div class="panel" data-filter-scope>
      <div class="panel-head">
        <div><h2 class="h6 mb-0">Pesanan Masuk Terbaru</h2><small class="text-muted">Daftar transaksi dan antrean pesanan aktif.</small></div>
        <div class="seg" data-filter-group>
          <button type="button" class="seg__btn active" data-filter="all">Semua</button>
          <button type="button" class="seg__btn" data-filter="pending">Pending @if($nPending)<b class="seg__n">{{ $nPending }}</b>@endif</button>
          <button type="button" class="seg__btn" data-filter="processing">Diproses ({{ $nProcess }})</button>
          <button type="button" class="seg__btn" data-filter="ready">Siap ({{ $nReady }})</button>
        </div>
      </div>
      @include('staff.pesanan._table', ['orders' => $orders, 'showAction' => true, 'emptyText' => 'Belum ada pesanan masuk. Pesanan baru akan muncul di sini.'])
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/staff-orders.js') }}"></script>
@endpush
