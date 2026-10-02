{{-- Tabel pesanan dipakai oleh index (aktif) dan selesai. Variabel: $orders, $showAction (bool) --}}
@if(count($orders) === 0)
  <div class="empty-state"><i class="bi bi-inbox"></i>{{ $emptyText ?? 'Belum ada pesanan.' }}</div>
@else
  <div class="table-responsive">
    <table class="table align-middle mb-0">
      <thead>
        <tr><th>#</th><th>Meja</th><th>Pelanggan</th><th>Total</th><th>Bayar</th><th>Status</th><th>Waktu</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <td class="fw-bold">#{{ $order->id }}</td>
            <td>{{ optional($order->table)->table_number }}</td>
            <td>{{ optional($order->user)->name }}</td>
            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            <td>
              @if($order->payment)
                {{ $order->payment->method === 'qris' ? 'QRIS' : 'Tunai' }}
                <x-pay-badge :status="$order->payment->status" />
              @endif
            </td>
            <td><x-status-badge :status="$order->status" /></td>
            <td class="text-muted small">{{ $order->created_at->format('H:i') }}</td>
            <td class="text-end text-nowrap">
              <a href="{{ url('/staff/pesanan/'.$order->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
              @if($showAction ?? false)<x-order-action :order="$order" />@endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif
