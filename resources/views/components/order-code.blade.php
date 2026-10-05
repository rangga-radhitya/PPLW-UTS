{{-- Kode pesanan seperti di Figma. Pakai: <x-order-code :id="$order->id" /> -> #BM-0004 --}}
@props(['id'])
#BM-{{ str_pad((string) $id, 4, '0', STR_PAD_LEFT) }}
