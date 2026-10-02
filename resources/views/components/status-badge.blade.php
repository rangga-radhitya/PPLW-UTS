{{-- Badge status pesanan. Pakai: <x-status-badge :status="$order->status" /> --}}
@props(['status', 'id' => null])
@php
  $labels = [
    'pending' => 'Menunggu konfirmasi', 'confirmed' => 'Dikonfirmasi', 'processing' => 'Sedang dibuat',
    'ready' => 'Siap diantar', 'done' => 'Selesai',
  ];
@endphp
<span @if($id) id="{{ $id }}" @endif {{ $attributes->merge(['class' => 'bm-badge bm-status-'.$status]) }}>{{ $labels[$status] ?? ucfirst($status) }}</span>
