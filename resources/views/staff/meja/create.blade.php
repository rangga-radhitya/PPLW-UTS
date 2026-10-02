@extends('layouts.staff')
@section('title', 'Tambah Meja')
@section('content')
<div class="staff-page-heading"><h1>Tambah Meja</h1></div><form method="POST" action="{{ url('/staff/meja') }}" class="card p-4 form-card">@csrf<label class="form-label">Outlet</label><select name="outlet_id" class="form-select mb-3" required>@foreach($outlets ?? [] as $outlet)<option value="{{ data_get($outlet,'id') }}">{{ data_get($outlet,'name') }}</option>@endforeach</select><label class="form-label">Nomor Meja</label><input name="table_number" type="number" class="form-control mb-3" required><button class="btn btn-bowlmate">Simpan</button></form>
@endsection
