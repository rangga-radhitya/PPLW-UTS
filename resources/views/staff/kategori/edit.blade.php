@extends('layouts.staff')
@section('title', 'Edit Kategori')
@section('content')
<div class="staff-page-heading"><h1>Edit Kategori</h1></div><form method="POST" action="{{ url('/staff/kategori/' . data_get($category,'id')) }}" class="card p-4 form-card">@csrf @method('PUT')<label class="form-label">Nama Kategori</label><input name="name" value="{{ data_get($category,'name') }}" class="form-control mb-3" required><button class="btn btn-bowlmate">Update</button></form>
@endsection
