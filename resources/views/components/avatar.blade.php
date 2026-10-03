{{-- Foto profil bulat. Jika user belum punya foto (atau kolom photo belum ada), tampil huruf pertama nama.
     Pakai: <x-avatar :user="auth()->user()" :size="32" /> --}}
@props(['user', 'size' => 40])
@php
  $photo   = data_get($user, 'photo');
  $url     = $photo && is_file(public_path('storage/'.$photo))
              ? asset('storage/'.implode('/', array_map('rawurlencode', explode('/', $photo)))) : null;
  $initial = strtoupper(mb_substr(trim((string) data_get($user, 'name', '?')), 0, 1));
  $style   = 'width:'.$size.'px;height:'.$size.'px;';
@endphp
@if($url)
  <img src="{{ $url }}" alt="Foto {{ data_get($user, 'name') }}" style="{{ $style }}" {{ $attributes->merge(['class' => 'avatar']) }}>
@else
  <span style="{{ $style }}font-size:{{ round($size * .45) }}px" aria-hidden="true" {{ $attributes->merge(['class' => 'avatar avatar--initial']) }}>{{ $initial }}</span>
@endif
