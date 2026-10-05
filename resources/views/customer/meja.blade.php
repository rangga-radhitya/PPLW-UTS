{{-- GET /outlets/{id}/meja  |  variabel: $outlet, $tables  (Figma: Table Selection)
     Scan QR membuka halaman ini dengan ?no=5 sehingga meja langsung terpilih. --}}
@extends('layouts.customer')
@section('title', 'Pilih meja')
@section('back', url('/outlets'))

@section('content')
  @php $selected = request('no'); @endphp

  <div class="d-flex flex-wrap gap-2 mb-3">
    <span class="pill-soft"><i class="bi bi-geo-alt-fill"></i> {{ $outlet->name }}</span>
    <span class="pill-butter"><i class="bi bi-egg-fried"></i> DINE-IN</span>
  </div>
  <h1 class="page-title">Pilih meja</h1>
  <p class="text-muted">Pilih nomor meja yang kamu tempati. Nomornya ada di stiker meja.</p>

  <section class="card-box">
    <div class="card-box__head"><span class="card-box__icon"><i class="bi bi-grid-3x3-gap"></i></span><h2>Nomor meja</h2>
      @if($selected)<span class="verified"><i class="bi bi-check-circle-fill"></i> Terpilih</span>@endif
    </div>

    @if($selected)
      <div class="table-picked"><i class="bi bi-123"></i> Meja {{ $selected }}</div>
    @endif

    <div class="table-grid">
      @forelse($tables as $table)
        <a href="{{ url('/outlets/'.$outlet->id.'/meja?no='.$table->table_number) }}"
           class="table-chip {{ (string) $selected === (string) $table->table_number ? 'is-selected' : '' }}"><small>Meja</small>{{ $table->table_number }}</a>
      @empty
        <div class="empty-state w-100"><i class="bi bi-grid-3x3-gap"></i>Outlet ini belum punya data meja.</div>
      @endforelse
    </div>
  </section>

  <div class="info-box mt-3"><i class="bi bi-info-circle"></i><span>Duduk bersama teman? Semua orang di meja yang sama bisa memesan bersamaan.</span></div>

  @if($selected)
    <div class="sticky-action">
      <a href="{{ url('/menu') }}" class="btn btn-primary btn-xl w-100">Lanjut ke Menu <i class="bi bi-arrow-right"></i></a>
      <small>Makan di <b>{{ $outlet->name }}</b> &bull; <span class="text-rust">Meja {{ $selected }}</span></small>
    </div>
  @endif
@endsection
