{{-- GET /menu/{id}  |  variabel: $menu --}}
@extends('layouts.customer')
@section('title', $menu->name)

@section('content')
  <a href="{{ url('/menu') }}" class="text-decoration-none small"><i class="bi bi-chevron-left"></i> Kembali ke menu</a>

  <div class="row g-4 mt-1 align-items-center">
    <div class="col-md-5">
      <x-menu-image :image="$menu->image" :name="$menu->name" class="detail-photo" />
    </div>
    <div class="col-md-7">
      @if($menu->category)<span class="bm-badge bm-status-ready mb-2">{{ $menu->category->name }}</span>@endif
      <h1 class="page-title">{{ $menu->name }}</h1>
      <p class="text-muted" style="max-width:60ch">{{ $menu->description }}</p>
      <div class="price-lg mb-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>

      @if($menu->is_available)
        <form method="POST" action="{{ url('/keranjang') }}" class="d-flex flex-wrap align-items-center gap-3">
          @csrf
          <input type="hidden" name="menu_id" value="{{ $menu->id }}">
          <div class="qty" data-qty>
            <button type="button" data-step="-1" aria-label="Kurangi">&minus;</button>
            <input type="number" name="quantity" value="1" min="1" max="20" aria-label="Jumlah">
            <button type="button" data-step="1" aria-label="Tambah">+</button>
          </div>
          <button class="btn btn-primary"><i class="bi bi-basket3"></i> Masukkan ke keranjang</button>
        </form>
      @else
        <div class="alert alert-secondary d-inline-block mb-0">Menu ini sedang habis.</div>
      @endif
    </div>
  </div>
@endsection
