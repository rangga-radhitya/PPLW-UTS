{{-- GET /riwayat  |  variabel: $orders (milik user yang login)  (Figma: Order History) --}}
@extends('layouts.customer')
@section('title', 'Riwayat pesanan')

@section('content')
  @php $outlets = collect($orders)->map(fn ($o) => optional($o->outlet)->name)->filter()->unique()->values(); @endphp
  <div class="d-flex justify-content-between align-items-center">
    <h1 class="page-title mb-0">Riwayat Pesanan</h1>
    <span class="pill"><i class="bi bi-receipt"></i> {{ count($orders) }} Pesanan</span>
  </div>
  <p class="text-muted mb-3">Lihat pesanan dine-in dan struk sebelumnya.</p>

  @if(count($orders) > 0)
    @if($outlets->count() > 1)
      <div class="cat-tabs mb-3" data-filter-group>
        <button type="button" class="cat-tab active" data-filter="all">Semua ({{ count($orders) }})</button>
        @foreach($outlets as $o)
          <button type="button" class="cat-tab" data-filter="{{ Str::slug($o) }}">{{ $o }}</button>
        @endforeach
      </div>
    @endif

    <div data-filter-scope>
    @foreach($orders as $order)
      @php
        $items = $order->items ?? $order->orderItems ?? collect();
        $first = $items->first();
        $names = $items->map(fn ($i) => optional($i->menu)->name.($i->quantity > 1 ? ' '.$i->quantity.'×' : ''))->implode(', ');
        $pay   = $order->payment;
      @endphp
      <article class="order-card" data-filter-item="{{ Str::slug(optional($order->outlet)->name ?? '') }}">
        <div class="d-flex justify-content-between align-items-center gap-2">
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <b class="order-card__code"><x-order-code :id="$order->id" /></b>
            <span class="pill-soft pill-soft--sm"><i class="bi bi-grid-3x3-gap"></i> Meja {{ optional($order->table)->table_number }}</span>
          </div>
          <x-status-badge :status="$order->status" />
        </div>
        <div class="order-card__meta"><i class="bi bi-clock"></i> {{ $order->created_at->locale('id')->translatedFormat('d M Y • H:i') }} WIB</div>
        <div class="order-card__meta"><i class="bi bi-shop"></i> {{ optional($order->outlet)->name }}</div>

        <div class="order-card__items">
          <x-menu-image :image="optional(optional($first)->menu)->image" :name="optional(optional($first)->menu)->name" />
          <div>
            <div class="d-flex justify-content-between"><b>{{ count($items) }} item</b><span class="text-rust small fw-bold">Dine-in</span></div>
            <div class="small text-muted">{{ Str::limit($names, 70) }}</div>
            @if($pay)<div class="small text-muted mt-1"><i class="bi {{ $pay->method === 'qris' ? 'bi-qr-code' : 'bi-cash' }}"></i> {{ $pay->method === 'qris' ? 'Pembayaran QRIS' : 'Tunai ke staff' }}</div>@endif
          </div>
        </div>

        <div class="order-card__foot">
          <div><small>TOTAL TAGIHAN</small><strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong></div>
          <a href="{{ url('/pesanan/'.$order->id) }}" class="btn btn-soft btn-sm"><i class="bi bi-eye"></i> Lihat Detail</a>
        </div>
      </article>
    @endforeach
    </div>
  @else
    <div class="empty-state">
      <span class="empty-state__bowl"><i class="bi bi-receipt"></i></span>
      <h2 class="h5 mt-2">Belum ada pesanan</h2>
      <p>Pesanan dine-in kamu akan muncul di sini.</p>
      <a href="{{ url('/outlets') }}" class="btn btn-primary">Mulai pesan</a>
    </div>
  @endif

  @if($orders instanceof \Illuminate\Contracts\Pagination\Paginator)
    {{ $orders->links('pagination::bootstrap-5') }}
  @endif
@endsection
