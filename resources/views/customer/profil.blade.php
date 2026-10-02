@extends('layouts.customer')
@section('title', 'Profil - BowlMate')
@section('content')
<div class="page-heading"><h1>Profil</h1><p>Kelola data akunmu.</p></div>
<div class="profile-card"><div class="profile-avatar">{{ strtoupper(substr(data_get($user,'name','U'),0,1)) }}</div><h2 class="h5 mt-3">{{ data_get($user,'name','User') }}</h2><p class="text-muted mb-0">{{ data_get($user,'email','-') }}</p></div>
<div class="stack-list mt-3"><a href="#" class="setting-row">Edit Profil <span>›</span></a><a href="#" class="setting-row">Ganti Password <span>›</span></a><form method="POST" action="{{ url('/logout') }}">@csrf<button class="setting-row w-100 text-start border-0 bg-white text-danger">Logout <span>›</span></button></form></div>
@endsection
