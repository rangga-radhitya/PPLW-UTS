@extends('layouts.staff')
@section('title', 'Pilih Outlet Staff')
@section('content')
<div class="staff-page-heading"><h1>Pilih Outlet</h1><p>Pilih outlet yang sedang kamu kelola.</p></div>
<div class="row g-3">
@foreach($outlets ?? [] as $outlet)
    <a href="{{ url('/staff/pesanan?outlet=' . data_get($outlet,'id')) }}" class="col-md-4 text-decoration-none"><div class="card p-4 h-100 staff-hover"><h2 class="h5">{{ data_get($outlet,'name') }}</h2><p class="text-muted">{{ data_get($outlet,'address') }}</p></div></a>
@endforeach
</div>
@endsection
