@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
  <div class="auth-hero">
    <span class="auth-hero__icon"><i class="bi bi-egg-fried"></i></span>
    <div>
      <h1>Selamat datang kembali!</h1>
      <p>Masuk untuk memesan rice bowl hangat langsung ke mejamu.</p>
    </div>
  </div>

  <form method="POST" action="{{ route('login') }}" novalidate class="auth-form">
    @csrf
    <label for="email" class="auth-label">Email</label>
    <div class="field">
      <i class="bi bi-envelope field__icon"></i>
      <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="nama@email.com" required autofocus autocomplete="username">
    </div>

    <label for="password" class="auth-label">Kata sandi</label>
    <div class="field">
      <i class="bi bi-lock field__icon"></i>
      <input id="password" type="password" name="password" class="form-control" placeholder="Kata sandi" required autocomplete="current-password">
      <button type="button" class="field__toggle" data-toggle-password aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
    </div>

    <div class="d-flex justify-content-between align-items-center my-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label small fw-bold" for="remember">Ingat saya</label>
      </div>
      @if(Route::has('password.request'))
        <a href="{{ route('password.request') }}" class="small fw-bold link-navy">Lupa kata sandi?</a>
      @endif
    </div>
    <button class="btn btn-primary btn-xl w-100">Masuk <i class="bi bi-arrow-right"></i></button>
  </form>

  <p class="text-center text-muted mt-4 mb-0 small">Belum punya akun? <a href="{{ route('register') }}" class="fw-bold">Daftar</a></p>
@endsection
