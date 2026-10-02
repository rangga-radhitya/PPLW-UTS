{{-- GET /staff/menu  |  variabel: $menus (dengan relasi category) --}}
@extends('layouts.staff')
@section('title', 'Kelola menu')

@section('content')
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h1 class="page-title mb-0">Menu</h1>
    <a href="{{ url('/staff/menu/create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah menu</a>
  </div>

  <div class="panel">
    @if(count($menus) === 0)
      <div class="empty-state"><i class="bi bi-bowl-hot"></i>Belum ada menu. Tambahkan menu pertamamu.</div>
    @else
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th></th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Ketersediaan</th><th class="text-end">Aksi</th></tr></thead>
          <tbody>
            @foreach($menus as $menu)
              <tr>
                <td><x-menu-image :image="$menu->image" :name="$menu->name" class="thumb" /></td>
                <td class="fw-semibold">{{ $menu->name }}</td>
                <td>{{ optional($menu->category)->name }}</td>
                <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                <td>
                  <form method="POST" action="{{ url('/staff/menu/'.$menu->id.'/ketersediaan') }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="is_available" value="{{ $menu->is_available ? 0 : 1 }}">
                    <button class="btn btn-sm {{ $menu->is_available ? 'btn-primary' : 'btn-outline-secondary' }}" title="Klik untuk mengubah">
                      {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                    </button>
                  </form>
                </td>
                <td class="text-end text-nowrap">
                  <a href="{{ url('/staff/menu/'.$menu->id.'/edit') }}" class="btn btn-sm btn-outline-primary">Ubah</a>
                  <form method="POST" action="{{ url('/staff/menu/'.$menu->id) }}" class="d-inline" data-confirm="Hapus menu {{ $menu->name }}?">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
@endsection
