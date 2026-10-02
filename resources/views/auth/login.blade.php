<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BowlMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="auth-body">
<div class="auth-card">
    <div class="text-center mb-4"><span class="brand-mark">BM</span><h1 class="h3 mt-3">BowlMate</h1><p class="text-muted">Masuk untuk melanjutkan</p></div>
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" value="{{ old('email') }}" class="form-control" required autofocus></div>
        <div class="mb-3"><label class="form-label">Password</label><input name="password" type="password" class="form-control" required></div>
        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Ingat saya</label></div>
        <button class="btn btn-bowlmate w-100">Login</button>
    </form>
    <p class="text-center mt-3 mb-0">Belum punya akun? <a href="{{ url('/register') }}">Daftar</a></p>
</div>
</body>
</html>
