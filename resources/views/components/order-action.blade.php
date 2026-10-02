{{-- Tombol staff untuk menaikkan status ke tahap berikutnya.
     Pakai: <x-order-action :order="$order" />  -> PATCH /staff/pesanan/{id}/status (field: status) --}}
@props(['order'])
@php
  $next = [
    'pending'    => ['confirmed',  'Terima pesanan', 'btn-yolk'],
    'confirmed'  => ['processing', 'Mulai dibuat',   'btn-primary'],
    'processing' => ['ready',      'Siap diantar',   'btn-primary'],
    'ready'      => ['done',       'Selesaikan',     'btn-primary'],
  ][$order->status] ?? null;
@endphp
@if($next)
  <form method="POST" action="{{ url('/staff/pesanan/'.$order->id.'/status') }}" class="d-inline">
    @csrf @method('PATCH')
    <input type="hidden" name="status" value="{{ $next[0] }}">
    <button class="btn btn-sm {{ $next[2] }}">{{ $next[1] }}</button>
  </form>
@endif
