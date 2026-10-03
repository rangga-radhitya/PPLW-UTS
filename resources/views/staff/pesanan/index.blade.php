{{-- GET /staff/pesanan  |  variabel: $orders (status aktif)
     Polling: public/js/staff-orders.js menyegarkan isi #orders-live tiap 5 detik --}}
@extends('layouts.staff')
@section('title', 'Pesanan masuk')

@section('content')
  <div class="d-flex justify-content-between align-items-end flex-wrap gap-2 mb-3">
    <div>
      <h1 class="page-title">Pesanan masuk</h1>
      <small class="text-muted"><span class="live-dot"></span>Diperbarui otomatis tiap 5 detik</small>
    </div>
    <a href="{{ url('/staff/pesanan-selesai') }}" class="btn btn-outline-primary btn-sm">Lihat pesanan selesai</a>
  </div>

  <div id="orders-live" data-url="{{ request()->url() }}">
    @php $all = collect($orders); @endphp
    <div class="row g-3 mb-3">
      <div class="col-4"><div class="stat stat--butter"><i class="bi bi-hourglass-split"></i><div><div class="stat__num">{{ $all->where('status', 'pending')->count() }}</div><div class="stat__label">Menunggu</div></div></div></div>
      <div class="col-4"><div class="stat stat--rust"><i class="bi bi-fire"></i><div><div class="stat__num">{{ $all->whereIn('status', ['confirmed', 'processing'])->count() }}</div><div class="stat__label">Dibuat</div></div></div></div>
      <div class="col-4"><div class="stat stat--navy"><i class="bi bi-bell"></i><div><div class="stat__num">{{ $all->where('status', 'ready')->count() }}</div><div class="stat__label">Siap diantar</div></div></div></div>
    </div>
    <div class="panel">
      @include('staff.pesanan._table', ['orders' => $orders, 'showAction' => true, 'emptyText' => 'Belum ada pesanan masuk. Pesanan baru akan muncul di sini.'])
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/staff-orders.js') }}"></script>
@endpush
