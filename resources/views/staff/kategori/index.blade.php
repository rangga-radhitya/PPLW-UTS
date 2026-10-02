{{-- GET /staff/kategori  |  variabel: $categories --}}
@extends('layouts.staff')
@section('title', 'Kelola kategori')

@section('content')
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h1 class="page-title mb-0">Kategori</h1>
    <a href="{{ url('/staff/kategori/create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah kategori</a>
  </div>

  <div class="panel">
    @if(count($categories) === 0)
      <div class="empty-state"><i class="bi bi-tags"></i>Belum ada kategori.</div>
    @else
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Nama kategori</th><th class="text-end">Aksi</th></tr></thead>
          <tbody>
            @foreach($categories as $category)
              <tr>
                <td class="fw-semibold">{{ $category->name }}</td>
                <td class="text-end text-nowrap">
                  <a href="{{ url('/staff/kategori/'.$category->id.'/edit') }}" class="btn btn-sm btn-outline-primary">Ubah</a>
                  <form method="POST" action="{{ url('/staff/kategori/'.$category->id) }}" class="d-inline" data-confirm="Hapus kategori {{ $category->name }}? Menu di dalamnya bisa ikut terpengaruh.">
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
