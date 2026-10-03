<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'BowlMate') - BowlMate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&family=Zen+Maru+Gothic:wght@500;700;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-bowlmate.png') }}">
  @stack('head')
</head>
<body>
@php
  // Jumlah item di keranjang (cart disimpan di session oleh Back End)
  $cartCount = collect(session('cart', []))->sum(fn ($i) => is_array($i) ? ($i['quantity'] ?? 1) : (int) $i);
@endphp

<nav class="navbar navbar-expand-md bm-nav sticky-top">
  <div class="container">
    <a class="brand" href="{{ url('/outlets') }}" aria-label="BowlMate"><img src="{{ asset('images/logo/logo-bowlmate.png') }}" alt="BowlMate" class="brand-logo"></a>

    <div class="d-none d-md-flex align-items-center ms-4 me-auto gap-2">
      <a class="nav-link {{ request()->is('outlets*') ? 'active' : '' }}" href="{{ url('/outlets') }}">Outlet</a>
      <a class="nav-link {{ request()->is('menu*') ? 'active' : '' }}" href="{{ url('/menu') }}">Menu</a>
      <a class="nav-link {{ request()->is('riwayat*', 'pesanan*') ? 'active' : '' }}" href="{{ url('/riwayat') }}">Pesanan saya</a>
    </div>

    <div class="d-flex align-items-center gap-3 ms-auto">
      <a href="{{ url('/keranjang') }}" class="cart-link" aria-label="Keranjang">
        <i class="bi bi-basket3"></i>
        @if($cartCount > 0)<span class="cart-count" id="cart-count">{{ $cartCount }}</span>@endif
      </a>
      <div class="dropdown d-none d-md-block">
        <button class="btn btn-sm btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
          <x-avatar :user="auth()->user()" :size="22" class="me-1" /> {{ Str::limit(auth()->user()->name ?? 'Akun', 14) }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="{{ url('/profil') }}">Profil saya</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">@csrf
              <button class="dropdown-item text-danger">Keluar</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<main class="container bm-main">
  <x-flash-alert />
  @yield('content')
</main>

<footer class="text-center text-muted small pb-5 d-none d-md-block">
  &copy; {{ date('Y') }} BowlMate. Rice bowl untuk teman makanmu.
</footer>

{{-- Navigasi bawah khusus HP --}}
<nav class="bm-bottomnav d-md-none" aria-label="Navigasi utama">
  <a href="{{ url('/outlets') }}" class="{{ request()->is('outlets*') ? 'active' : '' }}"><i class="bi bi-geo-alt"></i>Outlet</a>
  <a href="{{ url('/menu') }}" class="{{ request()->is('menu*') ? 'active' : '' }}"><i class="bi bi-egg-fried"></i>Menu</a>
  <a href="{{ url('/riwayat') }}" class="{{ request()->is('riwayat*', 'pesanan*') ? 'active' : '' }}"><i class="bi bi-receipt"></i>Pesanan</a>
  <a href="{{ url('/profil') }}" class="{{ request()->is('profil*') ? 'active' : '' }}"><i class="bi bi-person"></i>Profil</a>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
