@extends('layouts.staff')
@section('title', 'Pesanan Masuk')
@section('content')
<div class="staff-page-heading d-flex justify-content-between align-items-center"><div><h1>Pesanan Masuk</h1><p>Kelola pesanan yang masih aktif.</p></div><span class="live-pill">● Live</span></div>
<div id="staff-order-list" class="table-responsive card"><table class="table align-middle mb-0"><thead><tr><th>Order</th><th>Meja</th><th>Total</th><th>Pembayaran</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($orders ?? [] as $order)
<tr><td>#{{ data_get($order,'id') }}</td><td>{{ data_get($order,'table.table_number') }}</td><td>Rp{{ number_format((float)data_get($order,'total',0),0,',','.') }}</td><td>{{ strtoupper(data_get($order,'payment.method','-')) }}</td><td><x-status-badge :status="data_get($order,'status','pending')" /></td><td><a class="btn btn-sm btn-outline-primary" href="{{ url('/staff/pesanan/' . data_get($order,'id')) }}">Detail</a></td></tr>
@empty
<tr><td colspan="6" class="text-center py-5">Belum ada pesanan masuk.</td></tr>
@endforelse
</tbody></table></div>
@endsection
@push('scripts')<script>window.staffOrderPollingUrl='{{ url('/staff/pesanan/data') }}';</script>@endpush
