{{-- Foto menu. Kolom image bisa berisi nama file di public/images (contoh: "katsu.jpg")
     atau path hasil upload di storage (contoh: "menus/abc.jpg"). Jika kosong/rusak, tampil placeholder. --}}
@props(['image' => null, 'name' => ''])
@php
  $placeholder = asset('images/placeholder.svg');
  $src = ! $image ? $placeholder : (str_contains($image, '/') ? asset('storage/'.$image) : asset('images/'.$image));
@endphp
<img src="{{ $src }}" alt="{{ $name }}" loading="lazy" onerror="this.onerror=null;this.src='{{ $placeholder }}'" {{ $attributes }}>
