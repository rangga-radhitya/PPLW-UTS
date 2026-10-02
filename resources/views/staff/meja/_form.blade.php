@php $table = $table ?? null; @endphp
<form method="POST" action="{{ $table ? url('/staff/meja/'.$table->id) : url('/staff/meja') }}" class="panel" style="max-width:480px">
  @csrf
  @if($table) @method('PUT') @endif
  <div class="mb-4">
    <label for="table_number" class="form-label fw-semibold">Nomor meja</label>
    <input id="table_number" type="number" min="1" name="table_number" value="{{ old('table_number', optional($table)->table_number) }}" class="form-control" required>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-primary">Simpan meja</button>
    <a href="{{ url('/staff/meja') }}" class="btn btn-outline-secondary">Batal</a>
  </div>
</form>
