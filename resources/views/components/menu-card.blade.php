{{-- Kartu menu. Pakai: <x-menu-card :menu="$menu" /> --}}
@props(['menu'])
@php $habis = ! $menu->is_available; @endphp
<div class="menu-card {{ $habis ? 'is-soldout' : '' }}">
  <a class="menu-card__photo" href="{{ url('/menu/'.$menu->id) }}">
    <x-menu-image :image="$menu->image" :name="$menu->name" />
  </a>
  <h3><a href="{{ url('/menu/'.$menu->id) }}">{{ $menu->name }}</a></h3>
  <p class="menu-card__desc mb-0">{{ Str::limit($menu->description, 60) }}</p>
  <div class="menu-card__price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
  @if($habis)
    <button class="btn btn-sm btn-outline-secondary w-100" disabled>Habis</button>
  @else
    <form method="POST" action="{{ url('/keranjang') }}">
      @csrf
      <input type="hidden" name="menu_id" value="{{ $menu->id }}">
      <input type="hidden" name="quantity" value="1">
      <button class="btn btn-sm btn-primary w-100"><i class="bi bi-plus-lg"></i> Tambah</button>
    </form>
  @endif
</div>
