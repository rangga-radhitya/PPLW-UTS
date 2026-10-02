{{-- GET /menu?kategori=1&cari=katsu  |  variabel: $menus, $categories --}}
@extends('layouts.customer')
@section('title', 'Menu')

@section('content')
  <h1 class="page-title">Menu</h1>
  <p class="text-muted">Pilih rice bowl, tambahan, dan minumanmu.</p>

  <form method="GET" action="{{ url('/menu') }}" class="mb-3">
    @if(request('kategori'))<input type="hidden" name="kategori" value="{{ request('kategori') }}">@endif
    <div class="input-group">
      <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
      <input type="search" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari menu, misalnya katsu" data-autosearch>
    </div>
  </form>

  <div class="cat-pills mb-3">
    <a href="{{ url('/menu') . (request('cari') ? '?cari='.urlencode(request('cari')) : '') }}" class="cat-pill {{ request('kategori') ? '' : 'active' }}">Semua</a>
    @foreach($categories as $category)
      <a href="{{ url('/menu?kategori='.$category->id) . (request('cari') ? '&cari='.urlencode(request('cari')) : '') }}"
         class="cat-pill {{ (string) request('kategori') === (string) $category->id ? 'active' : '' }}">{{ $category->name }}</a>
    @endforeach
  </div>

  <div class="row g-3 gx-3">
    @forelse($menus as $menu)
      <div class="col-6 col-md-4 col-lg-3"><x-menu-card :menu="$menu" /></div>
    @empty
      <div class="empty-state">
        <i class="bi bi-search"></i>
        Tidak ada menu yang cocok{{ request('cari') ? ' dengan "'.e(request('cari')).'"' : '' }}.<br>
        <a href="{{ url('/menu') }}">Tampilkan semua menu</a>
      </div>
    @endforelse
  </div>
@endsection
