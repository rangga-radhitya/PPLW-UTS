@extends('layouts.staff')
@section('title', 'Tambah Kategori')
@section('content')
<div class="staff-page-heading"><h1>Tambah Kategori</h1></div><form method="POST" action="{{ url('/staff/kategori') }}" class="card p-4 form-card">@csrf<label class="form-label">Nama Kategori</label><input name="name" class="form-control mb-3" required><button class="btn btn-bowlmate">Simpan</button></form>
@endsection
