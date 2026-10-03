@extends('layouts.auth')
@section('title', 'Masuk')
@section('subtitle', 'Masuk untuk mulai memesan')

@section('content')
  <form method="POST" action="{{ route('login') }}" novalidate>
    @csrf
    <div class="mb-3">
      <label for="email" class="form-label fw-semibold">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="nama@email.com" required autofocus autocomplete="username">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label fw-semibold">Kata sandi</label>
      <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label" for="remember">Ingat saya</label>
      </div>
      @if(Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="small">Lupa kata sandi?</a>
      @endif
    </div>
    <button class="btn btn-primary w-100">Masuk</button>
  </form>

  <p class="text-center text-muted mt-4 mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar sekarang</a></p>
@endsection
