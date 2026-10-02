{{-- Form menu dipakai create & edit. Variabel: $categories, $menu (opsional saat create) --}}
@php $menu = $menu ?? null; @endphp
<form method="POST" action="{{ $menu ? url('/staff/menu/'.$menu->id) : url('/staff/menu') }}" enctype="multipart/form-data" class="panel" style="max-width:640px">
  @csrf
  @if($menu) @method('PUT') @endif

  <div class="mb-3">
    <label for="name" class="form-label fw-semibold">Nama menu</label>
    <input id="name" type="text" name="name" value="{{ old('name', optional($menu)->name) }}" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="category_id" class="form-label fw-semibold">Kategori</label>
    <select id="category_id" name="category_id" class="form-select" required>
      <option value="">Pilih kategori</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}" {{ (string) old('category_id', optional($menu)->category_id) === (string) $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="mb-3">
    <label for="description" class="form-label fw-semibold">Deskripsi</label>
    <textarea id="description" name="description" rows="3" class="form-control">{{ old('description', optional($menu)->description) }}</textarea>
  </div>
  <div class="mb-3">
    <label for="price" class="form-label fw-semibold">Harga (Rp)</label>
    <input id="price" type="number" name="price" min="0" step="500" value="{{ old('price', optional($menu)->price) }}" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="image" class="form-label fw-semibold">Foto</label>
    @if($menu && $menu->image)<div class="mb-2"><x-menu-image :image="$menu->image" :name="$menu->name" class="thumb" style="width:80px;height:80px" /></div>@endif
    <input id="image" type="file" name="image" accept="image/*" class="form-control">
    @if($menu)<div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>@endif
  </div>
  <div class="form-check form-switch mb-4">
    <input type="hidden" name="is_available" value="0">
    <input class="form-check-input" type="checkbox" role="switch" id="is_available" name="is_available" value="1" {{ old('is_available', $menu ? $menu->is_available : 1) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_available">Menu tersedia</label>
  </div>

  <div class="d-flex gap-2">
    <button class="btn btn-primary">Simpan menu</button>
    <a href="{{ url('/staff/menu') }}" class="btn btn-outline-secondary">Batal</a>
  </div>
</form>
