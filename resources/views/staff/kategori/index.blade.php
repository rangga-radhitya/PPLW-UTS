@extends('layouts.staff')
@section('title', 'Kelola Kategori')
@section('content')
<div class="staff-page-heading d-flex justify-content-between"><div><h1>Kelola Kategori</h1></div><a href="{{ url('/staff/kategori/create') }}" class="btn btn-bowlmate">+ Tambah</a></div>
<div class="table-responsive card"><table class="table align-middle mb-0"><thead><tr><th>Nama</th><th>Aksi</th></tr></thead><tbody>@forelse($categories ?? [] as $category)<tr><td>{{ data_get($category,'name') }}</td><td class="d-flex gap-2"><a href="{{ url('/staff/kategori/' . data_get($category,'id') . '/edit') }}" class="btn btn-sm btn-outline-primary">Edit</a><form method="POST" action="{{ url('/staff/kategori/' . data_get($category,'id')) }}" onsubmit="return confirmDelete('kategori ini')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr>@empty<tr><td colspan="2" class="text-center py-5">Belum ada kategori.</td></tr>@endforelse</tbody></table></div>
@endsection
