<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BowlMate')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="customer-body">
    <div class="mobile-shell">
        <header class="customer-header">
            <a href="{{ url('/menu') }}" class="brand-wrap text-decoration-none">
                <span class="brand-mark">BM</span>
                <span class="brand-name">BowlMate</span>
            </a>
            <div class="header-actions">
                <a href="{{ url('/keranjang') }}" class="icon-btn" aria-label="Keranjang">🛒</a>
            </div>
        </header>

        @if(session('success'))
            <div class="container-fluid px-3 pt-3"><div class="alert alert-success shadow-sm">{{ session('success') }}</div></div>
        @endif
        @if(session('error'))
            <div class="container-fluid px-3 pt-3"><div class="alert alert-danger shadow-sm">{{ session('error') }}</div></div>
        @endif

        <main class="page-content">
            @yield('content')
        </main>

        <nav class="bottom-nav">
            <a href="{{ url('/menu') }}" class="bottom-nav-item">⌂<span>Home</span></a>
            <a href="{{ url('/menu') }}" class="bottom-nav-item">☰<span>Menu</span></a>
            <a href="{{ url('/keranjang') }}" class="bottom-nav-item">🛒<span>Cart</span></a>
            <a href="{{ url('/riwayat') }}" class="bottom-nav-item">🧾<span>Orders</span></a>
            <a href="{{ url('/profil') }}" class="bottom-nav-item">◉<span>Profile</span></a>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/customer.js') }}"></script>
    @stack('scripts')
</body>
</html>
