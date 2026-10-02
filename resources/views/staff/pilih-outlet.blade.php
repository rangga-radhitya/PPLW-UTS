{{-- GET /staff/pilih-outlet  |  variabel: $outlets
     Form mengirim POST /staff/pilih-outlet dengan field outlet_id (cek dengan Back End) --}}
@extends('layouts.staff')
@section('title', 'Pilih outlet')

@section('content')
  <div class="mx-auto" style="max-width:480px">
    <h1 class="page-title">Kamu bertugas di outlet mana?</h1>
    <p class="text-muted mb-4">Pesanan, meja, dan transaksi akan ditampilkan sesuai outlet yang kamu pilih.</p>

    <form method="POST" action="{{ url('/staff/pilih-outlet') }}" class="panel">
      @csrf
      <label for="outlet_id" class="form-label fw-semibold">Outlet</label>
      <select id="outlet_id" name="outlet_id" class="form-select mb-3" required>
        @foreach($outlets as $outlet)
          <option value="{{ $outlet->id }}" {{ (string) old('outlet_id', session('outlet_id', auth()->user()->outlet_id)) === (string) $outlet->id ? 'selected' : '' }}>{{ $outlet->name }}</option>
        @endforeach
      </select>
      <button class="btn btn-primary w-100">Masuk ke outlet ini</button>
    </form>
  </div>
@endsection
