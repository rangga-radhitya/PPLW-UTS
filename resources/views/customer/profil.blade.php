{{-- GET/PUT /profil  |  variabel: $user
     Ganti kata sandi memakai route bawaan Breeze: PUT route('password.update') --}}
@extends('layouts.customer')
@section('title', 'Profil')

@section('content')
  <h1 class="page-title mb-4">Profil saya</h1>

  <div class="row g-4">
    <div class="col-lg-6">
      <div class="summary-box">
        <h2 class="h5 mb-3">Data diri</h2>
        <form method="POST" action="{{ url('/profil') }}">
          @csrf @method('PUT')
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label fw-semibold">Nomor HP</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
          </div>
          <button class="btn btn-primary">Simpan perubahan</button>
        </form>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="summary-box">
        <h2 class="h5 mb-3">Ganti kata sandi</h2>
        <form method="POST" action="{{ route('password.update') }}">
          @csrf @method('PUT')
          <div class="mb-3">
            <label for="current_password" class="form-label fw-semibold">Kata sandi saat ini</label>
            <input id="current_password" type="password" name="current_password" class="form-control" autocomplete="current-password" required>
            @error('current_password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="new_password" class="form-label fw-semibold">Kata sandi baru</label>
            <input id="new_password" type="password" name="password" class="form-control" autocomplete="new-password" required>
            @error('password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="new_password_confirmation" class="form-label fw-semibold">Ulangi kata sandi baru</label>
            <input id="new_password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
          </div>
          <button class="btn btn-outline-primary">Ganti kata sandi</button>
        </form>
      </div>
    </div>
  </div>

  <form method="POST" action="{{ route('logout') }}" class="mt-4 d-md-none">
    @csrf
    <button class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right"></i> Keluar</button>
  </form>
@endsection
