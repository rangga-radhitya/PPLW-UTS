@extends('layouts.customer')
@section('title', 'Pilih Outlet - BowlMate')
@section('content')
<div class="page-heading"><h1>Pilih Outlet</h1><p>Silakan pilih outlet BowlMate yang kamu kunjungi.</p></div>
<div class="stack-list">
@forelse($outlets ?? [] as $outlet)
    <a class="outlet-card text-decoration-none" href="{{ url('/outlets/' . data_get($outlet,'id') . '/meja') }}">
        <div><h3>{{ data_get($outlet,'name') }}</h3><p>{{ data_get($outlet,'address') }}</p><small>{{ data_get($outlet,'open_hours') }}</small></div><span>›</span>
    </a>
@empty
    @foreach(['BowlMate Kampus A UNAIR','BowlMate Kampus B UNAIR','BowlMate Kampus C UNAIR'] as $name)
        <div class="outlet-card"><div><h3>{{ $name }}</h3><p>Alamat outlet akan tampil dari database.</p></div><span>›</span></div>
    @endforeach
@endforelse
</div>
@endsection
