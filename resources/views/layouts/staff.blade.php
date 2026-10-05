<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Staff') - BowlMate Staff</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-bowlmate.png') }}">
  @stack('head')
</head>
<body class="staff-body">
@php
  $links = [
    ['/staff/pesanan',         'staff/pesanan',         'bi-receipt',      'Pesanan'],
    ['/staff/pesanan-selesai', 'staff/pesanan-selesai', 'bi-check2-circle','Pesanan Selesai'],
    ['/staff/menu',            'staff/menu*',           'bi-egg-fried',    'Menu'],
    ['/staff/kategori',        'staff/kategori*',       'bi-tags',         'Kategori'],
    ['/staff/meja',            'staff/meja*',           'bi-grid-3x3-gap', 'Meja'],
    ['/staff/outlet',          'staff/outlet*',         'bi-shop',         'Outlet'],
    ['/staff/transaksi',       'staff/transaksi*',      'bi-cash-coin',    'Transaksi'],
  ];
  // Outlet yang SEDANG dipilih staff (disimpan BE di session); jika belum memilih, pakai outlet bawaan akun.
  $picked = collect(session()->all())->first(fn ($v, $k) => str_contains((string) $k, 'outlet'));
  $outletName = null;
  if (is_numeric($picked) && class_exists(\App\Models\Outlet::class)) {
      $outletName = optional(\App\Models\Outlet::find($picked))->name;
  } elseif (is_string($picked) && $picked !== '') {
      $outletName = $picked;
  } elseif (is_object($picked)) {
      $outletName = $picked->name ?? null;
  } elseif (is_array($picked)) {
      $outletName = $picked['name'] ?? null;
  }
  $outletName = $outletName ?? optional(auth()->user()->outlet ?? null)->name;
@endphp

<div class="staff-shell">
  <aside class="staff-side staff-side--fixed">@include('layouts._staff-sidebar')</aside>

  <div class="staff-topbar">
    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#staffMenu" aria-label="Buka menu"><i class="bi bi-list"></i></button>
    <strong class="staff-topbar__title">BowlMate Staff</strong>
    <span class="ms-auto small text-muted">{{ $outletName }}</span>
  </div>
  <div class="offcanvas offcanvas-start staff-side" tabindex="-1" id="staffMenu">
    @include('layouts._staff-sidebar')
  </div>

  <div class="staff-main">
    <div class="staff-head d-none d-lg-flex">
      <a href="{{ url('/staff/pilih-outlet') }}" class="staff-head__outlet"><i class="bi bi-shop"></i> <b>{{ $outletName ?? 'Pilih outlet' }}</b> <small>Ganti Outlet <i class="bi bi-chevron-down"></i></small></a>
      <div class="staff-head__right">
        <span class="staff-head__clock"><i class="bi bi-clock"></i> <span id="wib-clock">--</span></span>
        <a href="{{ url('/profil') }}" class="staff-head__user"><span>{{ auth()->user()->name }}<small>Staff</small></span> <x-avatar :user="auth()->user()" :size="38" /></a>
      </div>
    </div>
    <main class="staff-content" id="main">
      <x-flash-alert />
      @yield('content')
    </main>
  </div>
</div>

@include('partials.overlays')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
