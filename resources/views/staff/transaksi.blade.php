{{-- GET /staff/transaksi  |  variabel: $payments (dengan relasi order.table) --}}
@extends('layouts.staff')
@section('title', 'Transaksi')

@section('content')
  <h1 class="page-title mb-1">Transaksi</h1>
  <p class="text-muted mb-3">Data pembayaran dari pesanan di outlet ini.</p>

  <div class="panel">
    @if(count($payments) === 0)
      <div class="empty-state"><i class="bi bi-cash-coin"></i>Belum ada transaksi.</div>
    @else
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Tanggal</th><th>Pesanan</th><th>Meja</th><th>Metode</th><th>Status</th><th class="text-end">Jumlah</th></tr></thead>
          <tbody>
            @foreach($payments as $payment)
              <tr>
                <td class="small">{{ optional($payment->paid_at ?? $payment->created_at)->format('d M Y, H:i') }}</td>
                <td><a href="{{ url('/staff/pesanan/'.$payment->order_id) }}">#{{ $payment->order_id }}</a></td>
                <td>{{ optional(optional($payment->order)->table)->table_number }}</td>
                <td>{{ $payment->method === 'qris' ? 'QRIS' : 'Tunai' }}</td>
                <td><x-pay-badge :status="$payment->status" /></td>
                <td class="text-end fw-semibold">Rp {{ number_format(optional($payment->order)->total ?? 0, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  @if($payments instanceof \Illuminate\Contracts\Pagination\Paginator)
    <div class="mt-3">{{ $payments->links('pagination::bootstrap-5') }}</div>
  @endif
@endsection
