@extends('layouts.customer')
@section('title', 'Pilih Meja - BowlMate')
@section('content')
<div class="page-heading"><h1>{{ data_get($outlet,'name','BowlMate') }}</h1><p>Pilih atau masukkan nomor meja.</p></div>
<div class="card p-4 shadow-sm mb-3 text-center"><div class="qr-placeholder mx-auto mb-3">QR</div><h3 class="h5">Scan QR Meja</h3><p class="text-muted mb-0">Gunakan kamera ponsel untuk memilih meja otomatis.</p></div>
<form method="GET" action="{{ url('/menu') }}" class="card p-4 shadow-sm">
    <label class="form-label fw-semibold">Atau masukkan nomor meja</label>
    <select name="meja" class="form-select mb-3" required>
        <option value="">Pilih meja</option>
        @foreach($tables ?? [] as $table)<option value="{{ data_get($table,'id') }}">Meja {{ data_get($table,'table_number') }}</option>@endforeach
    </select>
    <input type="hidden" name="outlet" value="{{ data_get($outlet,'id') }}">
    <button class="btn btn-bowlmate">Lanjut ke Menu</button>
</form>
@endsection
