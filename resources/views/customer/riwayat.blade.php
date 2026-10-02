{{-- GET /riwayat  |  variabel: $orders (milik user yang login) --}}
@extends('layouts.customer')
@section('title', 'Riwayat pesanan')

@section('content')
  <h1 class="page-title">Pesanan saya</h1>
  <p class="text-muted mb-4">Semua pesanan yang pernah kamu buat.</p>

  @forelse($orders as $order)
    <a href="{{ url('/pesanan/'.$order->id) }}" class="text-decoration-none text-reset">
      <div class="summary-box d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
          <div class="fw-bold">Pesanan #{{ $order->id }}</div>
          <div class="text-muted small">
            {{ optional($order->outlet)->name }} &middot; Meja {{ optional($order->table)->table_number }}<br>
            {{ $order->created_at->format('d M Y, H:i') }}
          </div>
        </div>
        <div class="text-end">
          <x-status-badge :status="$order->status" />
          <div class="fw-bold mt-1">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
        </div>
      </div>
    </a>
  @empty
    <div class="empty-state">
      <i class="bi bi-receipt"></i>
      Kamu belum pernah memesan.<br>
      <a href="{{ url('/outlets') }}" class="btn btn-primary mt-3">Mulai pesan</a>
    </div>
  @endforelse

  @if($orders instanceof \Illuminate\Contracts\Pagination\Paginator)
    {{ $orders->links('pagination::bootstrap-5') }}
  @endif
@endsection
