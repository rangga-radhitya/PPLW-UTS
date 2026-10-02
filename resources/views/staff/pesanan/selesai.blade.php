@extends('layouts.staff')
@section('title', 'Pesanan Selesai')
@section('content')
<div class="staff-page-heading"><h1>Pesanan Selesai</h1><p>Riwayat pesanan yang sudah selesai.</p></div>
<div class="table-responsive card"><table class="table align-middle mb-0"><thead><tr><th>Order</th><th>Meja</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead><tbody>@forelse($orders ?? [] as $order)<tr><td>#{{ data_get($order,'id') }}</td><td>{{ data_get($order,'table.table_number') }}</td><td>Rp{{ number_format((float)data_get($order,'total',0),0,',','.') }}</td><td><x-status-badge status="done" /></td><td><a href="{{ url('/staff/pesanan/' . data_get($order,'id')) }}" class="btn btn-sm btn-outline-primary">Detail</a></td></tr>@empty<tr><td colspan="5" class="text-center py-5">Belum ada pesanan selesai.</td></tr>@endforelse</tbody></table></div>
@endsection
