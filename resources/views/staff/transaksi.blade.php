@extends('layouts.staff')
@section('title', 'Transaksi')
@section('content')
<div class="staff-page-heading"><h1>Transaksi</h1><p>Data pembayaran dari outlet yang sedang dipilih.</p></div>
<div class="table-responsive card"><table class="table align-middle mb-0"><thead><tr><th>Payment</th><th>Order</th><th>Metode</th><th>Status</th><th>Total</th><th>Waktu</th></tr></thead><tbody>@forelse($payments ?? [] as $payment)<tr><td>#{{ data_get($payment,'id') }}</td><td>#{{ data_get($payment,'order_id') }}</td><td>{{ strtoupper(data_get($payment,'method')) }}</td><td><span class="badge text-bg-success">{{ ucfirst(data_get($payment,'status','pending')) }}</span></td><td>Rp{{ number_format((float)data_get($payment,'order.total',0),0,',','.') }}</td><td>{{ data_get($payment,'paid_at') ?? '-' }}</td></tr>@empty<tr><td colspan="6" class="text-center py-5">Belum ada transaksi.</td></tr>@endforelse</tbody></table></div>
@endsection
