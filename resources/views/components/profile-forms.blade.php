{{-- Form profil dipakai customer/profil dan staff/profil.
     Pakai: <x-profile-forms :user="$user" :allow-delete="true" />  (hapus akun hanya untuk customer)
     Route BE: PUT /profil (name,email,phone,photo,remove_photo), PUT /password, DELETE /profile --}}
@props(['user', 'allowDelete' => false])
@php
  // Bagian foto hanya muncul kalau kolom users.photo sudah ada (migration foto profil sudah dijalankan)
  $photoSupported = array_key_exists('photo', $user->getAttributes());
  $hasPhoto = (bool) data_get($user, 'photo');
@endphp

<div class="row g-4">
  <div class="col-lg-6">
    <div class="summary-box h-100">
      <h2 class="h5 mb-3">{{ $photoSupported ? 'Foto dan data diri' : 'Data diri' }}</h2>
      <form method="POST" action="{{ url('/profil') }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        @if($photoSupported)
          <div class="d-flex align-items-center gap-3 mb-4">
            <div data-avatar-preview data-size="88"><x-avatar :user="$user" :size="88" /></div>
            <div class="flex-grow-1">
              <label for="photo" class="form-label fw-semibold mb-1">Foto profil</label>
              <input id="photo" type="file" name="photo" accept="image/png,image/jpeg,image/webp" class="form-control form-control-sm" data-avatar-input>
              <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
              @if($hasPhoto)
                <div class="form-check mt-1">
                  <input class="form-check-input" type="checkbox" name="remove_photo" value="1" id="remove_photo">
                  <label class="form-check-label small" for="remove_photo">Hapus foto saat ini</label>
                </div>
              @endif
            </div>
          </div>
        @endif

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
    <div class="summary-box h-100">
      <h2 class="h5 mb-3">Ganti kata sandi</h2>
      <form method="POST" action="{{ url('/password') }}">
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

  @if($allowDelete)
    <div class="col-12">
      <div class="summary-box d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
          <h2 class="h6 mb-1">Hapus akun</h2>
          <div class="text-muted small">Akun dan datamu akan dihapus permanen dan tidak bisa dikembalikan.</div>
        </div>
        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">Hapus akun</button>
      </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ url('/profile') }}" class="modal-content">
          @csrf @method('DELETE')
          <div class="modal-header">
            <h2 class="modal-title h5" id="deleteAccountTitle">Hapus akun?</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <p class="text-muted">Masukkan kata sandimu untuk memastikan ini benar-benar kamu.</p>
            <input type="password" name="password" class="form-control" placeholder="Kata sandi" required autocomplete="current-password">
            @error('password', 'userDeletion')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
          </div>
          <div class="modal-footer">
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
</div>
