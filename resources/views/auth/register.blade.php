@extends('layouts.auth')
@section('title', 'Daftar')
@section('subtitle', 'Buat akun agar bisa memesan dari mejamu')

@section('content')
  <form method="POST" action="{{ route('register') }}" novalidate>
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label fw-semibold">Nama lengkap</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus autocomplete="name">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label fw-semibold">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autocomplete="username">
    </div>
    <div class="mb-3">
      <label for="phone" class="form-label fw-semibold">Nomor HP</label>
      <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="08xxxxxxxxxx" required autocomplete="tel">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label fw-semibold">Kata sandi</label>
      <input id="password" type="password" name="password" class="form-control" required autocomplete="new-password">
      <div class="form-text">Minimal 8 karakter.</div>
    </div>
    <div class="mb-4">
      <label for="password_confirmation" class="form-label fw-semibold">Ulangi kata sandi</label>
      <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required autocomplete="new-password">
    </div>
    <button class="btn btn-primary w-100">Daftar</button>
  </form>

  <p class="text-center text-muted mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk</a></p>
@endsection
