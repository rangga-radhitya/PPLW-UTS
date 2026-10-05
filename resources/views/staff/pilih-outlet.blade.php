{{-- GET /staff/pilih-outlet  |  variabel: $outlets  (Figma: Select Outlet)
     Form mengirim POST /staff/pilih-outlet dengan field outlet_id (cek dengan Back End) --}}
@extends('layouts.staff')
@section('title', 'Pilih outlet')

@section('content')
  <div class="mx-auto" style="max-width:520px">
    <span class="step-chip"><i class="bi bi-shop"></i> Langkah awal shift</span>
    <h1 class="page-title mt-2">Pilih Outlet</h1>
    <p class="text-muted mb-4">Pesanan, meja, dan transaksi akan ditampilkan sesuai outlet yang kamu pilih.</p>

    <form method="POST" action="{{ url('/staff/pilih-outlet') }}" class="outlet-list">
      @csrf
      @php $current = (string) old('outlet_id', session('outlet_id', auth()->user()->outlet_id)); @endphp
      @foreach($outlets as $outlet)
        <label class="outlet-card outlet-card--select">
          <input class="visually-hidden" type="radio" name="outlet_id" value="{{ $outlet->id }}" {{ $current === (string) $outlet->id ? 'checked' : '' }} required>
          <span class="outlet-card__icon"><i class="bi bi-egg-fried"></i></span>
          <div class="outlet-card__body"><h3>{{ $outlet->name }}</h3><div class="outlet-card__addr">{{ $outlet->address }}</div>
            @if($outlet->open_hours)<div class="outlet-card__chips"><span><i class="bi bi-clock"></i> {{ $outlet->open_hours }}</span></div>@endif</div>
          <span class="outlet-card__radio"><i class="bi bi-check-lg"></i></span>
        </label>
      @endforeach
      <button class="btn btn-primary btn-xl w-100 mt-2">Masuk ke outlet ini <i class="bi bi-arrow-right"></i></button>
    </form>
  </div>
@endsection
