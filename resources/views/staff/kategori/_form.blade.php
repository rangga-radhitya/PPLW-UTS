@php $category = $category ?? null; @endphp
<form method="POST" action="{{ $category ? url('/staff/kategori/'.$category->id) : url('/staff/kategori') }}" class="panel" style="max-width:480px">
  @csrf
  @if($category) @method('PUT') @endif
  <div class="mb-4">
    <label for="name" class="form-label fw-semibold">Nama kategori</label>
    <input id="name" type="text" name="name" value="{{ old('name', optional($category)->name) }}" class="form-control" placeholder="Contoh: Main Menu" required>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-primary">Simpan kategori</button>
    <a href="{{ url('/staff/kategori') }}" class="btn btn-outline-secondary">Batal</a>
  </div>
</form>
