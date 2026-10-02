@extends('layouts.customer')
@section('title', 'Menu - BowlMate')
@section('content')
<div class="menu-header-block">
    <div><span class="text-muted small">Outlet</span><h1 class="h4 mb-1">{{ session('outlet_name', 'BowlMate Kampus A UNAIR') }}</h1><span class="small text-muted">Meja {{ session('table_number', request('meja', '—')) }}</span></div>
</div>
<form method="GET" action="{{ url('/menu') }}" class="search-box mb-3"><input type="search" name="cari" value="{{ request('cari') }}" class="form-control" placeholder="Cari menu..."><button class="btn btn-bowlmate">Cari</button></form>
<div class="category-tabs mb-4">
    @foreach($categories ?? [] as $category)
        <a class="category-tab {{ (string)request('kategori') === (string)data_get($category,'id') ? 'active' : '' }}" href="{{ url('/menu?kategori=' . data_get($category,'id')) }}">{{ data_get($category,'name') }}</a>
    @endforeach
</div>
<div class="row g-3">
@forelse($menus ?? [] as $menu)
    <div class="col-6"><x-menu-card :menu="$menu" /></div>
@empty
    @foreach([
        ['id'=>1,'name'=>'Chicken Katsu Bowl','price'=>25000,'is_available'=>true],
        ['id'=>2,'name'=>'Beef Yakiniku Bowl','price'=>27000,'is_available'=>true],
        ['id'=>3,'name'=>'Chicken Teriyaki Bowl','price'=>25000,'is_available'=>true],
        ['id'=>4,'name'=>'Spicy Karaage Bowl','price'=>26000,'is_available'=>true],
        ['id'=>5,'name'=>'Ebi Furai Bowl','price'=>28000,'is_available'=>true],
        ['id'=>6,'name'=>'Gyoza','price'=>15000,'is_available'=>true],
        ['id'=>7,'name'=>'Karaage Bites','price'=>16000,'is_available'=>true],
        ['id'=>8,'name'=>'Takoyaki','price'=>14000,'is_available'=>true],
        ['id'=>9,'name'=>'Ocha Tea','price'=>8000,'is_available'=>true],
        ['id'=>10,'name'=>'Japanese Lychee Tea','price'=>12000,'is_available'=>true],
        ['id'=>11,'name'=>'Matcha Latte','price'=>18000,'is_available'=>true]
    ] as $menu)
       <div class="col-6"><x-menu-card :menu="$menu" /></div>
    @endforeach
@endforelse
</div>
@endsection
