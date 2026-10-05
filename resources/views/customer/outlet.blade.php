{{-- GET /outlets  |  variabel: $outlets  (Figma: Select Outlet) --}}
@extends('layouts.customer')
@section('title', 'Pilih outlet')

@section('content')
  <span class="step-chip"><i class="bi bi-shop"></i> Langkah 1 dari 2 &bull; Lokasi dine-in</span>
  <h1 class="page-title mt-2">Pilih outlet</h1>
  <p class="text-muted">Pilih outlet BowlMate tempatmu makan hari ini.</p>

  <div class="outlet-list">
    @forelse($outlets as $outlet)
      <a href="{{ url('/outlets/'.$outlet->id.'/meja') }}" class="outlet-card">
        <span class="outlet-card__icon"><i class="bi bi-egg-fried"></i></span>
        <div class="outlet-card__body">
          <h3>{{ $outlet->name }}</h3>
          <div class="outlet-card__addr">{{ $outlet->address }}</div>
          <div class="outlet-card__chips">
            @if($outlet->open_hours)<span><i class="bi bi-clock"></i> Buka &bull; {{ $outlet->open_hours }}</span>@endif
            @if($outlet->phone)<span><i class="bi bi-telephone"></i> {{ $outlet->phone }}</span>@endif
          </div>
        </div>
        <span class="outlet-card__radio" aria-hidden="true"><i class="bi bi-check-lg"></i></span>
      </a>
    @empty
      <div class="empty-state"><i class="bi bi-shop"></i>Belum ada outlet yang tersedia.</div>
    @endforelse
  </div>
@endsection
