{{-- GET/PUT /staff/outlet  |  variabel: $outlet --}}
@extends('layouts.staff')
@section('title', 'Info outlet')

@section('content')
  <h1 class="page-title mb-3">Info outlet</h1>
  <form method="POST" action="{{ url('/staff/outlet') }}" class="panel" style="max-width:560px">
    @csrf @method('PUT')
    <div class="mb-3">
      <label for="name" class="form-label fw-semibold">Nama outlet</label>
      <input id="name" type="text" name="name" value="{{ old('name', $outlet->name) }}" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="address" class="form-label fw-semibold">Alamat</label>
      <textarea id="address" name="address" rows="2" class="form-control" required>{{ old('address', $outlet->address) }}</textarea>
    </div>
    <div class="mb-3">
      <label for="open_hours" class="form-label fw-semibold">Jam buka</label>
      <input id="open_hours" type="text" name="open_hours" value="{{ old('open_hours', $outlet->open_hours) }}" class="form-control" placeholder="Contoh: 10.00 - 21.00" required>
    </div>
    <div class="mb-4">
      <label for="phone" class="form-label fw-semibold">Telepon</label>
      <input id="phone" type="tel" name="phone" value="{{ old('phone', $outlet->phone) }}" class="form-control">
    </div>
    <button class="btn btn-primary">Simpan info outlet</button>
  </form>
@endsection
