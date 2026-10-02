<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BowlMate Staff')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="staff-body">
    <div class="staff-shell">
        <aside class="staff-sidebar">
            <div class="staff-brand"><span class="brand-mark">BM</span><span>BowlMate</span></div>
            <div class="staff-user small text-white-50">{{ auth()->user()->name ?? 'Staff' }}</div>
            <nav class="staff-nav">
                <a href="{{ url('/staff/pesanan') }}">Dashboard</a>
                <a href="{{ url('/staff/pesanan') }}">Pesanan</a>
                <a href="{{ url('/staff/pesanan-selesai') }}">Pesanan Selesai</a>
                <a href="{{ url('/staff/menu') }}">Menu</a>
                <a href="{{ url('/staff/kategori') }}">Kategori</a>
                <a href="{{ url('/staff/meja') }}">Meja</a>
                <a href="{{ url('/staff/outlet') }}">Outlet</a>
                <a href="{{ url('/staff/transaksi') }}">Transaksi</a>
            </nav>
            <form method="POST" action="{{ url('/logout') }}" class="mt-auto">
                @csrf
                <button class="btn btn-outline-light w-100">Logout</button>
            </form>
        </aside>
        <main class="staff-main">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/staff.js') }}"></script>
    @stack('scripts')
</body>
</html>
