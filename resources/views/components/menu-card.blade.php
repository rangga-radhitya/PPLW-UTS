{{-- Kartu menu (baris) sesuai Figma. Pakai: <x-menu-card :menu="$menu" /> --}}
@props(['menu'])
@php
  $habis = ! $menu->is_available;
  $line  = session('cart', [])[$menu->id] ?? null;
  $qty   = $line ? (is_array($line) ? ($line['quantity'] ?? 1) : (int) $line) : 0;
  $label = data_get($menu, 'label');
@endphp
<article class="menu-card {{ $habis ? 'is-soldout' : '' }}" data-menu-card="{{ $menu->id }}">
  <a class="menu-card__photo" href="{{ url('/menu/'.$menu->id) }}" aria-label="Lihat {{ $menu->name }}">
    <x-menu-image :image="$menu->image" :name="$menu->name" />
    @if($habis)<span class="menu-card__label menu-card__label--dark">Habis</span>
    @elseif($label)<span class="menu-card__label">{{ $label }}</span>@endif
  </a>
  <div class="menu-card__body">
    <div>
      <h3><a href="{{ url('/menu/'.$menu->id) }}">{{ $menu->name }}</a></h3>
      <p class="menu-card__desc">{{ Str::limit($menu->description, 80) }}</p>
    </div>
    <div class="menu-card__foot">
      <span class="menu-card__price">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
      @if($habis)
        <span class="menu-card__soldout">Habis</span>
      @elseif($qty > 0)
        <form method="POST" action="{{ url('/keranjang/'.$menu->id) }}" data-live data-live-toast="Jumlah diperbarui">
          @csrf @method('PATCH')
          <div class="qty" data-qty data-autosubmit>
            <button type="button" data-step="-1" aria-label="Kurangi">&minus;</button>
            <input type="number" name="quantity" value="{{ $qty }}" min="1" max="20" aria-label="Jumlah">
            <button type="button" data-step="1" aria-label="Tambah">+</button>
          </div>
        </form>
      @else
        <form method="POST" action="{{ url('/keranjang') }}" data-live data-live-toast="{{ $menu->name }} ditambahkan">
          @csrf
          <input type="hidden" name="menu_id" value="{{ $menu->id }}">
          <input type="hidden" name="quantity" value="1">
          <button class="btn-add"><i class="bi bi-plus-lg"></i> Tambah</button>
        </form>
      @endif
    </div>
  </div>
</article>
