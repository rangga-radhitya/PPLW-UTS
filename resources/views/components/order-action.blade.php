{{-- Tombol staff untuk menaikkan status ke tahap berikutnya (PATCH /staff/pesanan/{id}/status).
     Pakai: <x-order-action :order="$order" :block="true" /> --}}
@props(['order', 'block' => false])
@php
  $next = [
    'pending'    => ['confirmed',  'Terima pesanan', 'btn-primary', 'Terima pesanan?', 'Pesanan akan diteruskan ke dapur dan pembayaran ditandai lunas.', 'bi-check-circle-fill'],
    'confirmed'  => ['processing', 'Mulai dibuat',   'btn-primary', null, null, 'bi-fire'],
    'processing' => ['ready',      'Siap diantar',   'btn-primary', null, null, 'bi-bell-fill'],
    'ready'      => ['done',       'Selesaikan',     'btn-primary', 'Selesaikan pesanan?', 'Pesanan akan dipindahkan ke daftar pesanan selesai.', 'bi-check2-all'],
  ][$order->status] ?? null;
@endphp
@if($next)
  <form method="POST" action="{{ url('/staff/pesanan/'.$order->id.'/status') }}" class="{{ $block ? 'd-block' : 'd-inline' }}"
        @if($next[3]) data-confirm="{{ $next[4] }}" data-confirm-title="{{ $next[3] }}" data-confirm-ok="{{ $next[1] }}" @endif>
    @csrf @method('PATCH')
    <input type="hidden" name="status" value="{{ $next[0] }}">
    <button class="btn btn-sm {{ $next[2] }} {{ $block ? 'w-100 btn-lg-action' : '' }}"><i class="bi {{ $next[5] }}"></i> {{ $next[1] }}</button>
  </form>
@endif
