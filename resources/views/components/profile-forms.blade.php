{{-- Form profil dipakai customer/profil dan staff/profil.
     Pakai: <x-profile-forms :user="$user" :allow-delete="true" :collapsible="true" />
     Route BE: PUT /profil (name,email,phone,photo,remove_photo), PUT /password, DELETE /profile --}}
@props(['user', 'allowDelete' => false, 'collapsible' => false])
@php
  $photoSupported = array_key_exists('photo', $user->getAttributes());
  $hasPhoto = (bool) data_get($user, 'photo');
  $openEdit = $errors->any() && ! $errors->updatePassword->any() && ! $errors->userDeletion->any();
  $openPass = $errors->updatePassword->any();
@endphp

@if($collapsible)
  <p class="list-label">PENGATURAN AKUN</p>
  <div class="menu-list-card">
    <button type="button" class="menu-row" data-bs-toggle="collapse" data-bs-target="#sec-edit" aria-expanded="{{ $openEdit ? 'true' : 'false' }}">
      <span class="menu-row__icon"><i class="bi bi-person"></i></span>
      <span class="menu-row__text"><b>Edit Profil</b><small>Nama, email, nomor HP{{ $photoSupported ? ', foto' : '' }}</small></span>
      <i class="bi bi-chevron-right menu-row__go"></i>
    </button>
    <div class="collapse {{ $openEdit ? 'show' : '' }}" id="sec-edit"><div class="menu-row__panel">@include('components._profile-edit')</div></div>
    <button type="button" class="menu-row" data-bs-toggle="collapse" data-bs-target="#sec-password" aria-expanded="{{ $openPass ? 'true' : 'false' }}">
      <span class="menu-row__icon"><i class="bi bi-shield-lock"></i></span>
      <span class="menu-row__text"><b>Ganti Kata Sandi</b><small>Perbarui kata sandi akunmu</small></span>
      <i class="bi bi-chevron-right menu-row__go"></i>
    </button>
    <div class="collapse {{ $openPass ? 'show' : '' }}" id="sec-password"><div class="menu-row__panel">@include('components._profile-password')</div></div>
  </div>
@else
  <div class="row g-3">
    <div class="col-lg-6"><div class="panel h-100"><h2 class="h6 mb-3">{{ $photoSupported ? 'Foto dan data diri' : 'Data diri' }}</h2>@include('components._profile-edit')</div></div>
    <div class="col-lg-6"><div class="panel h-100"><h2 class="h6 mb-3">Ganti kata sandi</h2>@include('components._profile-password')</div></div>
  </div>
@endif

@if($allowDelete)
  <div class="menu-list-card mt-3">
    <button type="button" class="menu-row" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
      <span class="menu-row__icon menu-row__icon--danger"><i class="bi bi-trash3"></i></span>
      <span class="menu-row__text"><b class="text-danger">Hapus Akun</b><small>Akun dan datamu dihapus permanen</small></span>
      <i class="bi bi-chevron-right menu-row__go"></i>
    </button>
  </div>

  <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form method="POST" action="{{ url('/profile') }}" class="modal-content bm-modal bm-modal--danger">
        @csrf @method('DELETE')
        <div class="bm-modal__icon"><i class="bi bi-trash3"></i></div>
        <h2 class="bm-modal__title" id="deleteAccountTitle">Hapus akun?</h2>
        <p class="bm-modal__text">Masukkan kata sandimu untuk memastikan ini benar-benar kamu.</p>
        <input type="password" name="password" class="form-control" placeholder="Kata sandi" required autocomplete="current-password">
        @error('password', 'userDeletion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        <div class="bm-modal__actions">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-danger">Ya, hapus akun</button>
        </div>
      </form>
    </div>
  </div>
  @push('scripts')
    @if($errors->userDeletion->isNotEmpty())
      <script>document.addEventListener('DOMContentLoaded', () => new bootstrap.Modal('#deleteAccountModal').show());</script>
    @endif
  @endpush
@endif
