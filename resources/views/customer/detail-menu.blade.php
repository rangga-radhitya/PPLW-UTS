{{-- GET /menu/{id}  |  variabel: $menu  (Figma: Product Detail) --}}
@extends('layouts.customer')
@section('title', $menu->name)
@section('back', url('/menu'))
@section('body_class', 'no-nav')

@section('content')
  <div class="detail">
    <div class="detail__hero">
      <x-menu-image :image="$menu->image" :name="$menu->name" />
      @unless($menu->is_available)<span class="menu-card__label menu-card__label--dark detail__badge">Habis</span>@endunless
    </div>

    <div class="detail__body">
      @if($menu->category)<span class="step-chip">{{ $menu->category->name }}</span>@endif
      <div class="detail__row">
        <h1 class="detail__name">{{ $menu->name }}</h1>
        <div class="detail__price">Rp{{ number_format($menu->price, 0, ',', '.') }}</div>
      </div>
      <p class="detail__desc">{{ $menu->description }}</p>
    </div>
  </div>

  @if($menu->is_available)
    <form method="POST" action="{{ url('/keranjang') }}" class="detail-bar" data-price="{{ $menu->price }}">
      @csrf
      <input type="hidden" name="menu_id" value="{{ $menu->id }}">
      <div>
        <div class="detail-bar__label">TOTAL HARGA</div>
        <div class="detail-bar__total" data-total>Rp{{ number_format($menu->price, 0, ',', '.') }}</div>
      </div>
      <div class="qty" data-qty>
        <button type="button" data-step="-1" aria-label="Kurangi">&minus;</button>
        <input type="number" name="quantity" value="1" min="1" max="20" aria-label="Jumlah">
        <button type="button" data-step="1" aria-label="Tambah">+</button>
      </div>
      <button class="btn btn-primary"><i class="bi bi-basket3"></i> Tambah ke Pesanan</button>
    </form>
  @else
    <div class="detail-bar detail-bar--off"><i class="bi bi-slash-circle"></i> Menu ini sedang habis</div>
  @endif
@endsection
