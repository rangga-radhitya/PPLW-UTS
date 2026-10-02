<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BowlMate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="auth-body">
<div class="auth-card">
    <div class="text-center mb-4"><span class="brand-mark">BM</span><h1 class="h3 mt-3">Buat Akun BowlMate</h1></div>
    @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <form method="POST" action="{{ url('/register') }}">
        @csrf
        <div class="mb-3"><label class="form-label">Nama</label><input name="name" value="{{ old('name') }}" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input name="email" type="email" value="{{ old('email') }}" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Nomor HP</label><input name="phone" value="{{ old('phone') }}" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Password</label><input name="password" type="password" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Konfirmasi Password</label><input name="password_confirmation" type="password" class="form-control" required></div>
        <button class="btn btn-bowlmate w-100">Daftar</button>
    </form>
    <p class="text-center mt-3 mb-0">Sudah punya akun? <a href="{{ url('/login') }}">Login</a></p>
</div>
</body>
</html>
