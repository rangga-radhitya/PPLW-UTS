{{-- GET /outlets/{id}/meja  |  variabel: $outlet, $tables
     Scan QR membuka halaman ini dengan ?no=5 sehingga meja langsung terpilih. --}}
@extends('layouts.customer')
@section('title', 'Pilih meja')

@section('content')
  @php $selected = request('no'); @endphp

  <a href="{{ url('/outlets') }}" class="text-decoration-none small"><i class="bi bi-chevron-left"></i> Ganti outlet</a>
  <h1 class="page-title mt-2">{{ $outlet->name }}</h1>
  <p class="text-muted mb-4">Pilih nomor meja yang kamu tempati. Nomornya ada di stiker meja.</p>

  <div class="row g-2 mb-4">
    @forelse($tables as $table)
      <div class="col-3 col-sm-2 col-md-1">
        <a href="{{ url('/outlets/'.$outlet->id.'/meja?no='.$table->table_number) }}"
           class="table-chip {{ (string) $selected === (string) $table->table_number ? 'is-selected' : '' }}">{{ $table->table_number }}</a>
      </div>
    @empty
      <div class="empty-state"><i class="bi bi-grid-3x3-gap"></i>Outlet ini belum punya data meja.</div>
    @endforelse
  </div>

  @if($selected)
    <div class="summary-box d-flex flex-wrap justify-content-between align-items-center gap-3">
      <div>Kamu duduk di <strong>meja {{ $selected }}</strong></div>
      <a href="{{ url('/menu') }}" class="btn btn-primary">Lihat menu</a>
    </div>
  @endif
@endsection
