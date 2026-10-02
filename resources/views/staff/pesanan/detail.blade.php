{{-- GET /staff/pesanan/{id}  |  variabel: $order --}}
@extends('layouts.staff')
@section('title', 'Pesanan #'.$order->id)

@section('content')
  @php $items = $order->items ?? $order->orderItems ?? collect(); @endphp

  <a href="{{ url('/staff/pesanan') }}" class="text-decoration-none small"><i class="bi bi-chevron-left"></i> Kembali ke daftar</a>
  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-2 mb-3">
    <h1 class="page-title mb-0">Pesanan #{{ $order->id }}</h1>
    <div class="d-flex align-items-center gap-2">
      <x-status-badge :status="$order->status" />
      <x-order-action :order="$order" />
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-7">
      <div class="panel">
        <h2 class="h5 mb-3">Item pesanan</h2>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead><tr><th>Menu</th><th class="text-center">Jumlah</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
            <tbody>
              @foreach($items as $item)
                <tr>
                  <td>{{ optional($item->menu)->name }}</td>
                  <td class="text-center">{{ $item->quantity }}</td>
                  <td class="text-end">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                  <td class="text-end">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot><tr><th colspan="3" class="text-end">Total</th><th class="text-end">Rp {{ number_format($order->total, 0, ',', '.') }}</th></tr></tfoot>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="panel">
        <h2 class="h5 mb-3">Info pesanan</h2>
        <dl class="row mb-0">
          <dt class="col-5 text-muted fw-normal">Pelanggan</dt><dd class="col-7">{{ optional($order->user)->name }}</dd>
          <dt class="col-5 text-muted fw-normal">Telepon</dt><dd class="col-7">{{ optional($order->user)->phone ?: '-' }}</dd>
          <dt class="col-5 text-muted fw-normal">Outlet</dt><dd class="col-7">{{ optional($order->outlet)->name }}</dd>
          <dt class="col-5 text-muted fw-normal">Meja</dt><dd class="col-7">{{ optional($order->table)->table_number }}</dd>
          <dt class="col-5 text-muted fw-normal">Masuk</dt><dd class="col-7">{{ $order->created_at->format('d M Y, H:i') }}</dd>
          <dt class="col-5 text-muted fw-normal">Pembayaran</dt>
          <dd class="col-7">
            @if($order->payment)
              {{ $order->payment->method === 'qris' ? 'QRIS' : 'Tunai' }}
              <x-pay-badge :status="$order->payment->status" />
            @else - @endif
          </dd>
        </dl>
      </div>
    </div>
  </div>
@endsection
