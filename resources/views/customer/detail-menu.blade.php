@extends('layouts.customer')
@section('title', data_get($menu,'name','Detail Menu'))
@section('content')
@php($available = (bool)data_get($menu,'is_available',true))
<div class="detail-card">
    @if(data_get($menu,'image'))<img src="{{ asset('images/menu/' . data_get($menu,'image')) }}" class="detail-image" alt="{{ data_get($menu,'name') }}">@else<div class="detail-image placeholder-image">Food Photo</div>@endif
    <div class="pt-3"><span class="small text-muted">{{ data_get($menu,'category.name') ?? data_get($menu,'category','Menu') }}</span><h1 class="h3">{{ data_get($menu,'name','Menu') }}</h1><div class="menu-price fs-5">Rp{{ number_format((float)data_get($menu,'price',0),0,',','.') }}</div><p class="text-muted mt-3">{{ data_get($menu,'description','Deskripsi menu akan ditampilkan dari database.') }}</p></div>
    @if($available)
    <form method="POST" action="{{ url('/keranjang') }}" class="mt-3">@csrf<input type="hidden" name="menu_id" value="{{ data_get($menu,'id') }}"><input type="hidden" name="quantity" value="1"><button class="btn btn-bowlmate w-100">+ Tambahkan ke Keranjang</button></form>
    @else <button class="btn btn-secondary w-100" disabled>Menu Habis</button>@endif
</div>
@endsection
