{{-- GET /outlets  |  variabel: $outlets --}}
@extends('layouts.customer')
@section('title', 'Pilih outlet')

@section('content')
  <h1 class="page-title">Kamu makan di outlet mana?</h1>
  <p class="text-muted mb-4">Pilih outlet, lalu pilih nomor mejamu.</p>

  <div class="row g-3">
    @forelse($outlets as $outlet)
      <div class="col-md-6 col-lg-4">
        <div class="outlet-card h-100">
          <h3>{{ $outlet->name }}</h3>
          <div class="meta"><i class="bi bi-geo-alt"></i><span>{{ $outlet->address }}</span></div>
          <div class="meta"><i class="bi bi-clock"></i><span>{{ $outlet->open_hours }}</span></div>
          <div class="meta"><i class="bi bi-telephone"></i><span>{{ $outlet->phone }}</span></div>
          <a href="{{ url('/outlets/'.$outlet->id.'/meja') }}" class="btn btn-primary mt-auto">Pilih outlet ini</a>
        </div>
      </div>
    @empty
      <div class="empty-state"><i class="bi bi-shop"></i>Belum ada outlet yang tersedia.</div>
    @endforelse
  </div>
@endsection
