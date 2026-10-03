{{-- Pesan sukses / error. Pakai: <x-flash-alert /> (sudah ada di semua layout) --}}
@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
  </div>
@endif
@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
  </div>
@endif
@if(session('status') && is_string(session('status')))
  @php
    $statusText = [
      'profile-updated' => 'Profil berhasil diperbarui.',
      'password-updated' => 'Kata sandi berhasil diganti.',
      'verification-link-sent' => 'Tautan verifikasi baru sudah dikirim ke emailmu.',
    ][session('status')] ?? session('status');
  @endphp
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle me-1"></i> {{ $statusText }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
  </div>
@endif
@if($errors->any())
  <div class="alert alert-danger" role="alert">
    <strong>Periksa lagi isianmu:</strong>
    <ul class="mb-0 mt-1 ps-3">
      @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
  </div>
@endif
