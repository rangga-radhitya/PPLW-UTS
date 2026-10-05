@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
  <div class="auth-hero auth-hero--col">
    <span class="step-chip step-chip--butter"><i class="bi bi-egg-fried"></i> Akun baru</span>
    <h1>Buat akun BowlMate-mu</h1>
    <p>Daftar untuk memesan dari meja, menyimpan favorit, dan memantau pesananmu.</p>
  </div>

  <form method="POST" action="{{ route('register') }}" novalidate class="auth-form">
    @csrf
    <label for="name" class="auth-label">Nama lengkap</label>
    <div class="field">
      <i class="bi bi-person field__icon"></i>
      <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus autocomplete="name">
    </div>

    <label for="email" class="auth-label">Email</label>
    <div class="field">
      <i class="bi bi-envelope field__icon"></i>
      <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="username">
    </div>

    <label for="phone" class="auth-label">Nomor HP</label>
    <div class="field">
      <i class="bi bi-telephone field__icon"></i>
      <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="08xxxxxxxxxx" required autocomplete="tel">
    </div>

    <label for="password" class="auth-label">Kata sandi <small class="text-muted fw-normal">minimal 8 karakter</small></label>
    <div class="field">
      <i class="bi bi-lock field__icon"></i>
      <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
      <button type="button" class="field__toggle" data-toggle-password aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
    </div>

    <label for="password_confirmation" class="auth-label">Ulangi kata sandi</label>
    <div class="field">
      <i class="bi bi-shield-check field__icon"></i>
      <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
      <button type="button" class="field__toggle" data-toggle-password aria-label="Tampilkan kata sandi"><i class="bi bi-eye"></i></button>
    </div>

    <button class="btn btn-primary btn-xl w-100 mt-3">Buat Akun <i class="bi bi-arrow-right"></i></button>
  </form>

  <p class="text-center text-muted mt-4 mb-0 small">Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold">Masuk</a></p>
@endsection
