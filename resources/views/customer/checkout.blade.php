{{-- GET /checkout -> POST /pesanan  |  variabel: $cart, $total --}}
@extends('layouts.customer')
@section('title', 'Checkout')

@section('content')
  <a href="{{ url('/keranjang') }}" class="text-decoration-none small"><i class="bi bi-chevron-left"></i> Kembali ke keranjang</a>
  <h1 class="page-title mt-2 mb-4">Checkout</h1>

  <form method="POST" action="{{ url('/pesanan') }}">
    @csrf
    <div class="row g-4">
      <div class="col-lg-7">
        <h2 class="h5 mb-3">Pilih cara bayar</h2>

        <label class="pay-option">
          <input class="form-check-input mt-0" type="radio" name="payment_method" value="qris" {{ old('payment_method', 'qris') === 'qris' ? 'checked' : '' }}>
          <i class="bi bi-qr-code"></i>
          <span><strong>QRIS</strong><br><small class="text-muted">Bayar non-tunai dari aplikasi e-wallet atau mobile banking</small></span>
        </label>
        <label class="pay-option">
          <input class="form-check-input mt-0" type="radio" name="payment_method" value="cash" {{ old('payment_method') === 'cash' ? 'checked' : '' }}>
          <i class="bi bi-cash-stack"></i>
          <span><strong>Tunai</strong><br><small class="text-muted">Bayar langsung ke staff di meja</small></span>
        </label>

        <div class="alert alert-light border small mt-3" data-pay-hint="qris">Setelah memesan, tunjukkan bukti pembayaran QRIS ke staff agar pesananmu dikonfirmasi.</div>
        <div class="alert alert-light border small mt-3 d-none" data-pay-hint="cash">Siapkan uang pas atau kembalian akan diberikan oleh staff.</div>
      </div>

      <div class="col-lg-5">
        <div class="summary-box">
          <h2 class="h5 mb-3">Pesananmu</h2>
          @foreach($cart as $item)
            <div class="d-flex justify-content-between small mb-2">
              <span>{{ data_get($item, 'quantity') }} &times; {{ data_get($item, 'name') }}</span>
              <span>Rp {{ number_format(data_get($item, 'price', 0) * data_get($item, 'quantity', 1), 0, ',', '.') }}</span>
            </div>
          @endforeach
          <hr>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <strong>Total</strong><span class="price-lg">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>
          <button class="btn btn-primary w-100">Pesan sekarang</button>
        </div>
      </div>
    </div>
  </form>
@endsection
