@extends('layouts.customer')
@section('title', 'Status Pesanan - BowlMate')
@section('content')
@php($status = data_get($order,'status','pending'))
<div class="page-heading"><span class="text-muted small">Order #{{ data_get($order,'id','—') }}</span><h1>Status Pesanan</h1></div>
<div class="status-hero"><x-status-badge :status="$status" /><h2 id="status-text" class="h4 mt-3">{{ str($status)->headline() }}</h2><p class="text-muted">Status pesanan akan diperbarui otomatis.</p></div>
<div class="timeline">
@foreach(['pending'=>'Pesanan dibuat','confirmed'=>'Dikonfirmasi staff','processing'=>'Sedang diproses','ready'=>'Siap diantar','done'=>'Selesai'] as $key=>$label)
    <div class="timeline-item {{ array_search($key,['pending','confirmed','processing','ready','done']) <= array_search($status,['pending','confirmed','processing','ready','done']) ? 'done' : '' }}"><span class="timeline-dot"></span><div><strong>{{ $label }}</strong><div class="small text-muted">{{ $key }}</div></div></div>
@endforeach
</div>
@endsection
@push('scripts')
<script>window.BowlMateOrderId = @json(data_get($order,'id'));</script>
<script src="{{ asset('js/status.js') }}"></script>
@endpush
