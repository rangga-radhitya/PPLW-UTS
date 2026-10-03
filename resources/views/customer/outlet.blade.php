{{-- GET /outlets  |  variabel: $outlets --}}
@extends('layouts.customer')
@section('title', 'Pilih outlet')

@section('content')
  <section class="hero gingham mb-4">
    <div class="hero__card">
      <div class="hero__text">
        <span class="hero__tag">Rice bowl &amp; dine-in</span>
        <h1 class="hero__title">Lapar? Pesan dari mejamu, tanpa antre.</h1>
        <p class="text-muted mb-0">Pilih outlet dan nomor meja, lalu bowl favoritmu diantar ke meja.</p>
      </div>
      <div class="hero__photos" aria-hidden="true">
        <x-menu-image name="Chicken Katsu Bowl" class="hero__photo hero__photo--1" />
        <x-menu-image name="Gyoza" class="hero__photo hero__photo--2" />
        <x-menu-image name="Matcha Latte" class="hero__photo hero__photo--3" />
      </div>
    </div>
  </section>

  <div class="how mb-4">
    <div class="how__label">Cara pesan</div>
    <ol class="how__list">
      <li><span class="how__num">1</span><p><b>Pilih meja</b> Scan QR atau pilih nomor mejamu.</p></li>
      <li><span class="how__num">2</span><p><b>Pesan menu</b> Masukkan bowl favoritmu ke keranjang.</p></li>
      <li><span class="how__num">3</span><p><b>Pantau status</b> Lihat pesananmu diproses langsung di HP.</p></li>
    </ol>
  </div>

  <h2 class="page-title">Kamu makan di outlet mana?</h2>
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
