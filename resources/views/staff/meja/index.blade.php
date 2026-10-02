{{-- GET /staff/meja  |  variabel: $tables (meja milik outlet staff) --}}
@extends('layouts.staff')
@section('title', 'Kelola meja')

@section('content')
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <h1 class="page-title mb-0">Meja</h1>
    <a href="{{ url('/staff/meja/create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah meja</a>
  </div>

  <div class="panel">
    @if(count($tables) === 0)
      <div class="empty-state"><i class="bi bi-grid-3x3-gap"></i>Belum ada meja di outlet ini.</div>
    @else
      <div class="table-responsive">
        <table class="table mb-0">
          <thead><tr><th>Nomor meja</th><th>Link QR</th><th class="text-end">Aksi</th></tr></thead>
          <tbody>
            @foreach($tables as $table)
              <tr>
                <td class="fw-semibold">Meja {{ $table->table_number }}</td>
                <td class="small text-muted">{{ url('/outlets/'.$table->outlet_id.'/meja?no='.$table->table_number) }}</td>
                <td class="text-end text-nowrap">
                  <a href="{{ url('/staff/meja/'.$table->id.'/edit') }}" class="btn btn-sm btn-outline-primary">Ubah</a>
                  <form method="POST" action="{{ url('/staff/meja/'.$table->id) }}" class="d-inline" data-confirm="Hapus meja {{ $table->table_number }}?">
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
