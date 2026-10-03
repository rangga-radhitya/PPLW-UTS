{{-- GET /profil (staff)  |  variabel: $user (name, email, phone, role, outlet) --}}
@extends('layouts.staff')
@section('title', 'Profil')

@section('content')
  <div class="d-flex align-items-center gap-3 mb-4">
    <x-avatar :user="$user" :size="56" />
    <div>
      <h1 class="page-title mb-1">{{ $user->name }}</h1>
      <span class="bm-badge bm-status-confirmed">Staff</span>
      @if(optional($user->outlet)->name)
        <span class="text-muted small ms-1"><i class="bi bi-geo-alt"></i> {{ $user->outlet->name }}</span>
      @endif
    </div>
  </div>

  <x-profile-forms :user="$user" />
@endsection
