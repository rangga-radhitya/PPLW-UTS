@extends('layouts.customer')
@section('title', 'Keranjang - BowlMate')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><div><span class="text-muted small">BowlMate</span><h1 class="h4 mb-0">Keranjang</h1></div></div>
@php($items = $cart ?? [])
@if(count($items))
    <div class="stack-list mb-3">@foreach($items as $item)<x-cart-item :item="$item" />@endforeach</div>
    <div class="summary-card"><div class="summary-row"><span>Total</span><strong>Rp{{ number_format((float)($total ?? 0),0,',','.') }}</strong></div><a href="{{ url('/checkout') }}" class="btn btn-bowlmate w-100 mt-3">Lanjut Checkout</a></div>
@else
    <div class="empty-state"><div class="empty-icon">🛒</div><h2 class="h5">Keranjang masih kosong</h2><p class="text-muted">Pilih menu favoritmu untuk mulai memesan.</p><a href="{{ url('/menu') }}" class="btn btn-bowlmate">Lihat Menu</a></div>
@endif
@endsection
