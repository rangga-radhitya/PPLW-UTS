<form method="POST" action="{{ url('/password') }}">
  @csrf @method('PUT')
  <div class="mb-3"><label for="current_password" class="auth-label">Kata sandi saat ini</label>
    <input id="current_password" type="password" name="current_password" class="form-control" autocomplete="current-password" required>
    @error('current_password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
  <div class="mb-3"><label for="new_password" class="auth-label">Kata sandi baru</label>
    <input id="new_password" type="password" name="password" class="form-control" autocomplete="new-password" required>
    @error('password', 'updatePassword')<div class="text-danger small mt-1">{{ $message }}</div>@enderror</div>
  <div class="mb-3"><label for="new_password_confirmation" class="auth-label">Ulangi kata sandi baru</label>
    <input id="new_password_confirmation" type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required></div>
  <button class="btn btn-outline-primary">Ganti kata sandi</button>
</form>
