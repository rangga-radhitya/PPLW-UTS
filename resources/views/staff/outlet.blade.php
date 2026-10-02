@extends('layouts.staff')
@section('title', 'Info Outlet')
@section('content')
<div class="staff-page-heading"><h1>Informasi Outlet</h1><p>Kelola informasi outlet yang sedang dipilih.</p></div>
<form method="POST" action="{{ url('/staff/outlet') }}" class="card p-4 form-card">@csrf @method('PUT')<div class="mb-3"><label class="form-label">Nama Outlet</label><input class="form-control" name="name" value="{{ data_get($outlet,'name') }}" required></div><div class="mb-3"><label class="form-label">Alamat</label><textarea class="form-control" name="address" rows="3">{{ data_get($outlet,'address') }}</textarea></div><div class="mb-3"><label class="form-label">Jam Buka</label><input class="form-control" name="open_hours" value="{{ data_get($outlet,'open_hours') }}"></div><div class="mb-3"><label class="form-label">Nomor Telepon</label><input class="form-control" name="phone" value="{{ data_get($outlet,'phone') }}"></div><button class="btn btn-bowlmate">Simpan</button></form>
@endsection
