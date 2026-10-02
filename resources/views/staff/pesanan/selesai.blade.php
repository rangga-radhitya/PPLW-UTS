{{-- GET /staff/pesanan-selesai  |  variabel: $orders (status done) --}}
@extends('layouts.staff')
@section('title', 'Pesanan selesai')

@section('content')
  <h1 class="page-title mb-3">Pesanan selesai</h1>
  <div class="panel">
    @include('staff.pesanan._table', ['orders' => $orders, 'showAction' => false, 'emptyText' => 'Belum ada pesanan yang selesai.'])
  </div>
  @if($orders instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-3">{{ $orders->links('pagination::bootstrap-5') }}</div>
  @endif
@endsection
