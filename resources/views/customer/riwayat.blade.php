@extends('layouts.customer')
@section('title', 'Riwayat Pesanan - BowlMate')
@section('content')
<div class="page-heading"><h1>Riwayat Pesanan</h1><p>Semua pesananmu.</p></div>
<div class="stack-list">
@forelse($orders ?? [] as $order)
    <a href="{{ url('/pesanan/' . data_get($order,'id')) }}" class="history-card text-decoration-none"><div><strong>#{{ data_get($order,'id') }}</strong><div class="small text-muted">{{ data_get($order,'created_at') }}</div><div class="small">Meja {{ data_get($order,'table.table_number') }}</div></div><div class="text-end"><x-status-badge :status="data_get($order,'status','pending')" /><div class="fw-semibold mt-2">Rp{{ number_format((float)data_get($order,'total',0),0,',','.') }}</div></div></a>
@empty
    <div class="empty-state"><div class="empty-icon">🧾</div><h2 class="h5">Belum ada riwayat</h2><p class="text-muted">Pesanan yang sudah dibuat akan muncul di sini.</p></div>
@endforelse
</div>
@endsection
