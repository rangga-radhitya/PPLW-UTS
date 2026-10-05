{{-- Tabel pesanan dipakai index (aktif) dan selesai. Variabel: $orders, $showAction (bool), $filterable (bool) --}}
@if(count($orders) === 0)
  <div class="empty-state"><i class="bi bi-inbox"></i>{{ $emptyText ?? 'Belum ada pesanan.' }}</div>
@else
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0 orders-table">
      <thead>
        <tr><th>No. Pesanan</th><th>Waktu (WIB)</th><th>Pelanggan</th><th>Meja</th><th>Rincian Menu</th><th class="text-end">Total</th><th>Pembayaran</th><th>Status</th><th class="text-end">Aksi</th></tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          @php
            $items = $order->items ?? $order->orderItems ?? collect();
            $summary = $items->map(fn ($i) => $i->quantity.'× '.optional($i->menu)->name)->implode(', ');
            $group = in_array($order->status, ['confirmed', 'processing']) ? 'processing' : $order->status;
            $pay = $order->payment;
          @endphp
          <tr data-filter-item="{{ $group }}" class="{{ $order->status === 'pending' ? 'row-attn' : '' }}">
            <td class="fw-bold text-rust text-nowrap"><x-order-code :id="$order->id" /></td>
            <td class="text-muted text-nowrap">{{ $order->created_at->format('H:i') }}</td>
            <td>{{ optional($order->user)->name }}</td>
            <td><span class="pill-soft pill-soft--sm">Meja {{ optional($order->table)->table_number }}</span></td>
            <td class="small text-muted" style="max-width:240px">{{ Str::limit($summary, 60) }}</td>
            <td class="text-end fw-bold text-nowrap">Rp{{ number_format($order->total, 0, ',', '.') }}</td>
            <td>
              @if($pay)
                <span class="pay-pill {{ $pay->status === 'paid' ? 'pay-pill--paid' : 'pay-pill--wait' }}">{{ $pay->method === 'qris' ? 'QRIS' : 'Tunai' }} [{{ $pay->status === 'paid' ? 'Lunas' : 'Pending' }}]</span>
              @endif
            </td>
            <td><x-status-badge :status="$order->status" /></td>
            <td class="text-end text-nowrap">
              <a href="{{ url('/staff/pesanan/'.$order->id) }}" class="btn btn-sm btn-soft">Detail</a>
              @if($showAction ?? false)<x-order-action :order="$order" />@endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endif
