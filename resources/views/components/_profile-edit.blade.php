<form method="POST" action="{{ url('/profil') }}" enctype="multipart/form-data">
  @csrf @method('PUT')
  @if($photoSupported)
    <div class="d-flex align-items-center gap-3 mb-3">
      <div data-avatar-preview data-size="72"><x-avatar :user="$user" :size="72" /></div>
      <div class="flex-grow-1">
        <label for="photo" class="form-label fw-bold small mb-1">Foto profil</label>
        <input id="photo" type="file" name="photo" accept="image/png,image/jpeg,image/webp" class="form-control form-control-sm" data-avatar-input>
        <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
        @if($hasPhoto)
          <div class="form-check mt-1"><input class="form-check-input" type="checkbox" name="remove_photo" value="1" id="remove_photo"><label class="form-check-label small" for="remove_photo">Hapus foto saat ini</label></div>
        @endif
      </div>
    </div>
  @endif
  <div class="mb-3"><label for="name" class="auth-label">Nama</label><input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required></div>
  <div class="mb-3"><label for="email" class="auth-label">Email</label><input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required></div>
  <div class="mb-3"><label for="phone" class="auth-label">Nomor HP</label><input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control"></div>
  <button class="btn btn-primary">Simpan perubahan</button>
</form>
