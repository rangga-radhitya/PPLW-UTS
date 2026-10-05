{{-- GET /staff/pesanan-selesai  |  variabel: $orders (status done) --}}
@extends('layouts.staff')
@section('title', 'Pesanan selesai')

@section('content')
  <div class="page-head"><div><h1 class="page-title">Pesanan Selesai</h1><p class="text-muted mb-0">Riwayat pesanan yang sudah selesai dilayani.</p></div></div>
  <div class="panel">
    @include('staff.pesanan._table', ['orders' => $orders, 'showAction' => false, 'emptyText' => 'Belum ada pesanan yang selesai.'])
  </div>
  @if($orders instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
  @endif
@endsection
