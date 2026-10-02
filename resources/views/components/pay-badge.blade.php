{{-- Badge status pembayaran. Pakai: <x-pay-badge :status="$order->payment->status" /> --}}
@props(['status', 'id' => null])
<span @if($id) id="{{ $id }}" @endif {{ $attributes->merge(['class' => 'bm-badge bm-pay-'.$status]) }}>{{ $status === 'paid' ? 'Lunas' : 'Belum dibayar' }}</span>
