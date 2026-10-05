<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'BowlMate') - BowlMate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-bowlmate.png') }}">
  @stack('head')
</head>
<body class="@yield('body_class')">
@php
  $cartCount = collect(session('cart', []))->sum(fn ($i) => is_array($i) ? ($i['quantity'] ?? 1) : (int) $i);
  $hdrUser = auth()->user();
  $hdrPhoto = $hdrUser ? data_get($hdrUser, 'photo') : null;
@endphp

<header class="bm-nav sticky-top">
  <div class="container bm-nav__in">
    @hasSection('back')
      <a href="@yield('back')" class="bm-back" aria-label="Kembali"><i class="bi bi-arrow-left"></i></a>
    @endif
    <a class="brand" href="{{ url('/outlets') }}" aria-label="BowlMate"><img src="{{ asset('images/logo/logo-bowlmate.png') }}" alt="BowlMate" class="brand-logo"></a>
    <x-table-pill />

    <nav class="bm-nav__links d-none d-md-flex">
      <a class="{{ request()->is('outlets*') ? 'active' : '' }}" href="{{ url('/outlets') }}">Beranda</a>
      <a class="{{ request()->is('menu*') ? 'active' : '' }}" href="{{ url('/menu') }}">Menu</a>
      <a class="{{ request()->is('keranjang*') ? 'active' : '' }}" href="{{ url('/keranjang') }}">Keranjang <span class="cart-count cart-count--inline" data-live-slot="cart-count" data-live-bump>{{ $cartCount ?: '' }}</span></a>
      <a class="{{ request()->is('riwayat*', 'pesanan*') ? 'active' : '' }}" href="{{ url('/riwayat') }}">Pesanan</a>
    </nav>

    <div class="bm-nav__right">
      <div class="dropdown">
        <button class="hdr-avatar" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Akun">
          @if($hdrPhoto)<x-avatar :user="$hdrUser" :size="34" />@else<i class="bi bi-person"></i>@endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end bm-dropdown">
          <li class="px-3 py-2 small text-muted">{{ $hdrUser->name ?? '' }}</li>
          <li><a class="dropdown-item" href="{{ url('/profil') }}"><i class="bi bi-person"></i> Profil saya</a></li>
          <li><a class="dropdown-item" href="{{ url('/riwayat') }}"><i class="bi bi-receipt"></i> Riwayat pesanan</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">@csrf
              <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </div>
</header>

<main class="container bm-main" id="main">
  <x-flash-alert />
  @yield('content')
</main>

<footer class="bm-footer d-none d-md-block">&copy; {{ date('Y') }} BowlMate Indonesia. Rice bowl untuk teman makanmu.</footer>

<nav class="bm-bottomnav d-md-none" aria-label="Navigasi utama">
  <a href="{{ url('/outlets') }}" class="{{ request()->is('outlets*') ? 'active' : '' }}"><i class="bi bi-house-door"></i>Beranda</a>
  <a href="{{ url('/menu') }}" class="{{ request()->is('menu*') ? 'active' : '' }}"><i class="bi bi-egg-fried"></i>Menu</a>
  <a href="{{ url('/keranjang') }}" class="{{ request()->is('keranjang*', 'checkout*') ? 'active' : '' }}"><i class="bi bi-basket3"></i>Keranjang <span class="cart-count" data-live-slot="cart-count" data-live-bump>{{ $cartCount ?: '' }}</span></a>
  <a href="{{ url('/riwayat') }}" class="{{ request()->is('riwayat*', 'pesanan*') ? 'active' : '' }}"><i class="bi bi-receipt"></i>Pesanan</a>
  <a href="{{ url('/profil') }}" class="{{ request()->is('profil*') ? 'active' : '' }}"><i class="bi bi-person"></i>Profil</a>
</nav>

@include('partials.overlays')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
