@extends('layouts.staff')
@section('title', 'Kelola Meja')
@section('content')
<div class="staff-page-heading d-flex justify-content-between"><div><h1>Kelola Meja</h1></div><a href="{{ url('/staff/meja/create') }}" class="btn btn-bowlmate">+ Tambah</a></div>
<div class="table-responsive card"><table class="table align-middle mb-0"><thead><tr><th>Outlet</th><th>Nomor Meja</th><th>Aksi</th></tr></thead><tbody>@forelse($tables ?? [] as $table)<tr><td>{{ data_get($table,'outlet.name') }}</td><td>Meja {{ data_get($table,'table_number') }}</td><td class="d-flex gap-2"><a href="{{ url('/staff/meja/' . data_get($table,'id') . '/edit') }}" class="btn btn-sm btn-outline-primary">Edit</a><form method="POST" action="{{ url('/staff/meja/' . data_get($table,'id')) }}" onsubmit="return confirmDelete('meja ini')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></td></tr>@empty<tr><td colspan="3" class="text-center py-5">Belum ada meja.</td></tr>@endforelse</tbody></table></div>
@endsection
