<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Staff') - BowlMate Staff</title>
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
  $links = [
    ['/staff/pesanan',         'staff/pesanan',         'bi-inboxes',      'Pesanan masuk'],
    ['/staff/pesanan-selesai', 'staff/pesanan-selesai', 'bi-check2-circle','Pesanan selesai'],
    ['/staff/menu',            'staff/menu*',           'bi-egg-fried',     'Menu'],
    ['/staff/kategori',        'staff/kategori*',       'bi-tags',         'Kategori'],
    ['/staff/meja',            'staff/meja*',           'bi-grid-3x3-gap', 'Meja'],
    ['/staff/outlet',          'staff/outlet*',         'bi-shop',         'Info outlet'],
    ['/staff/transaksi',       'staff/transaksi*',      'bi-cash-coin',    'Transaksi'],
  ];
  // Nama outlet yang SEDANG dipilih staff di /staff/pilih-outlet (disimpan BE di session).
  // Dicari dari key session apa pun yang mengandung kata "outlet" (outlet_id, staff_outlet_id, outlet_name, dst).
  // Kalau belum memilih, jatuh ke outlet bawaan akun staff.
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
    <button class="btn btn-sm btn-outline-light" data-bs-toggle="offcanvas" data-bs-target="#staffMenu" aria-label="Buka menu"><i class="bi bi-list"></i></button>
    <span class="brand-chip"><img src="{{ asset('images/logo/logo-bowlmate.png') }}" alt="BowlMate" class="brand-logo"></span><strong class="text-white">Staff</strong>
  </div>
  <div class="offcanvas offcanvas-start staff-side" tabindex="-1" id="staffMenu" style="width:260px">
    @include('layouts._staff-sidebar')
  </div>

  <main class="staff-content">
    <x-flash-alert />
    @yield('content')
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
