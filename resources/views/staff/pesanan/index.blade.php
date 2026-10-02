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

  <div class="panel" id="orders-live" data-url="{{ request()->url() }}">
    @include('staff.pesanan._table', ['orders' => $orders, 'showAction' => true, 'emptyText' => 'Belum ada pesanan masuk. Pesanan baru akan muncul di sini.'])
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/staff-orders.js') }}"></script>
@endpush
