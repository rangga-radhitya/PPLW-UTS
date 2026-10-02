@extends('layouts.customer')
@section('title', 'Checkout - BowlMate')
@section('content')
<div class="page-heading"><h1>Checkout</h1><p>Periksa pesanan dan pilih metode pembayaran.</p></div>
<div class="summary-card mb-3"><div class="summary-row"><span>Outlet</span><strong>{{ session('outlet_name','BowlMate Kampus A UNAIR') }}</strong></div><div class="summary-row"><span>Meja</span><strong>{{ session('table_number', request('meja','—')) }}</strong></div></div>
<div class="summary-card mb-3"><h2 class="h6">Pesanan</h2>@foreach($cart ?? [] as $item)<div class="summary-row"><span>{{ data_get($item,'name') ?? data_get($item,'menu.name') }} × {{ data_get($item,'quantity',1) }}</span><span>Rp{{ number_format((float)((data_get($item,'price') ?? data_get($item,'menu.price') ?? 0) * data_get($item,'quantity',1)),0,',','.') }}</span></div>@endforeach<hr><div class="summary-row"><span>Total</span><strong>Rp{{ number_format((float)($total ?? 0),0,',','.') }}</strong></div></div>
<form method="POST" action="{{ url('/pesanan') }}" class="summary-card">@csrf
<h2 class="h6">Metode Pembayaran</h2>
<label class="payment-option"><input type="radio" name="method" value="qris" checked><span><strong>QRIS</strong><small>Bayar melalui QR</small></span></label>
<label class="payment-option"><input type="radio" name="method" value="cash"><span><strong>Tunai</strong><small>Bayar di kasir</small></span></label>
<button class="btn btn-bowlmate w-100 mt-3">Buat Pesanan</button>
</form>
@endsection
