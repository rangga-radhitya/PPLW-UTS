{{-- GET /menu?kategori=1&cari=katsu  |  variabel: $menus, $categories  (Figma: Menu) --}}
@extends('layouts.customer')
@section('title', 'Menu')

@section('content')
  @php
    $mejaNo = trim(\Illuminate\Support\Facades\Blade::render('<x-table-no />'));
    $activeCat = $categories->firstWhere('id', (int) request('kategori'));
    $cartItems = collect(session('cart', []));
    $cartQty  = $cartItems->sum(fn ($i) => is_array($i) ? ($i['quantity'] ?? 1) : (int) $i);
    $cartSum  = $cartItems->sum(fn ($i) => is_array($i) ? (($i['price'] ?? 0) * ($i['quantity'] ?? 1)) : 0);
  @endphp

  <x-outlet-bar />

  <section class="hero mb-3">
    <div class="hero__text">
      <h1 class="hero__title">Mau makan apa hari ini{{ $mejaNo !== '' ? ' di Meja '.$mejaNo : '' }}?</h1>
      <p class="hero__sub">Pesan langsung dari mejamu tanpa antre kasir. Rice bowl hangat dibuat saat kamu memesan.</p>
      <div class="hero__chips">
        <span class="chip-dark"><i class="bi bi-patch-check-fill"></i> 100% Halal</span>
        <span class="chip-dark"><i class="bi bi-stopwatch"></i> Rata-rata saji ~8 Menit</span>
      </div>
    </div>
  </section>

  <form method="GET" action="{{ url('/menu') }}" data-live-form class="search-box">
    @if(request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
    <i class="bi bi-search"></i>
    <input type="search" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari menu (Karaage, Gyudon, Gyoza...)" data-autosearch>
  </form>

  <div class="cat-tabs" data-live-slot="menu-filters">
    <a data-live-link href="{{ url('/menu') . (request('cari') ? '?cari='.urlencode(request('cari')) : '') }}" class="cat-tab {{ request('kategori') ? '' : 'active' }}"><i class="bi bi-grid"></i> Semua</a>
    @foreach($categories as $category)
      <a data-live-link href="{{ url('/menu?kategori='.$category->id) . (request('cari') ? '&cari='.urlencode(request('cari')) : '') }}"
         class="cat-tab {{ (string) request('kategori') === (string) $category->id ? 'active' : '' }}">{{ $category->name }}@isset($category->menus_count) ({{ $category->menus_count }})@endisset</a>
    @endforeach
  </div>

  <div data-live-slot="menu-list" class="menu-live">
    <div class="section-head">
      <h2>{{ $activeCat ? $activeCat->name.' BowlMate' : 'Semua Menu BowlMate' }}</h2>
      <span class="pill">{{ count($menus) }} Menu</span>
    </div>
    <div class="menu-list">
      @forelse($menus as $menu)
        <x-menu-card :menu="$menu" />
      @empty
        <div class="empty-state" style="grid-column:1/-1">
          <i class="bi bi-search"></i>
          Tidak ada menu yang cocok{{ request('cari') ? ' dengan "'.e(request('cari')).'"' : '' }}.<br>
          <a href="{{ url('/menu') }}" data-live-link>Tampilkan semua menu</a>
        </div>
      @endforelse
    </div>
  </div>

  <div data-live-slot="cart-bar">
    @if($cartQty > 0)
      <a href="{{ url('/keranjang') }}" class="cart-bar">
        <span class="cart-bar__left">
          <span class="cart-bar__icon"><i class="bi bi-basket3"></i><b>{{ $cartQty }}</b></span>
          <span><span class="cart-bar__meta d-block">{{ count($cartItems) }} Menu{{ $mejaNo !== '' ? ' • Meja '.$mejaNo : '' }}</span>
            @if($cartSum > 0)<span class="cart-bar__total">Rp{{ number_format($cartSum, 0, ',', '.') }}</span>@endif</span>
        </span>
        <span class="cart-bar__go">Lihat Pesanan <i class="bi bi-arrow-right"></i></span>
      </a>
    @endif
  </div>
@endsection
