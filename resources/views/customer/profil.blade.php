{{-- GET /profil (customer)  |  variabel: $user  (Figma: My Account) --}}
@extends('layouts.customer')
@section('title', 'Profil')

@section('content')
  <section class="profile-card">
    <div class="profile-card__avatar"><x-avatar :user="$user" :size="86" /></div>
    <h1>{{ $user->name }}</h1>
    <div class="profile-card__mail">{{ $user->email }}</div>
    @if($user->phone)<div class="profile-card__phone">{{ $user->phone }}</div>@endif
  </section>

  <x-profile-forms :user="$user" :allow-delete="true" :collapsible="true" />

  <p class="list-label">PESANAN</p>
  <div class="menu-list-card">
    <a href="{{ url('/riwayat') }}" class="menu-row">
      <span class="menu-row__icon"><i class="bi bi-receipt"></i></span>
      <span class="menu-row__text"><b>Riwayat Pesanan</b><small>Lihat pesanan dan struk sebelumnya</small></span>
      <i class="bi bi-chevron-right menu-row__go"></i>
    </a>
    <form method="POST" action="{{ route('logout') }}"
          data-confirm="Kamu akan keluar dari sesi ini di perangkat ini." data-confirm-title="Keluar dari akun?" data-confirm-ok="Keluar" data-confirm-danger>
      @csrf
      <button class="menu-row menu-row--logout">
        <span class="menu-row__icon menu-row__icon--rust"><i class="bi bi-box-arrow-right"></i></span>
        <span class="menu-row__text"><b>Keluar</b><small>Akhiri sesi di perangkat ini</small></span>
        <i class="bi bi-arrow-right menu-row__go text-rust"></i>
      </button>
    </form>
  </div>
@endsection
