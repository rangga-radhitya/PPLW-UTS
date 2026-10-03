{{-- GET /profil (customer)  |  variabel: $user --}}
@extends('layouts.customer')
@section('title', 'Profil')

@section('content')
  <div class="d-flex align-items-center gap-3 mb-4">
    <x-avatar :user="$user" :size="56" />
    <div>
      <h1 class="page-title mb-0">{{ $user->name }}</h1>
      <div class="text-muted small">{{ $user->email }}</div>
    </div>
  </div>

  <x-profile-forms :user="$user" :allow-delete="true" />

  <form method="POST" action="{{ route('logout') }}" class="mt-4 d-md-none">
    @csrf
    <button class="btn btn-outline-danger w-100"><i class="bi bi-box-arrow-right"></i> Keluar</button>
  </form>
@endsection
