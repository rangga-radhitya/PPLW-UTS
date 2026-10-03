{{-- Foto menu. Urutan pencarian file:
     1) public/images/menu/{isi kolom image}      -> foto bawaan (contoh: "Gyoza.png")
     2) public/storage/{isi kolom image}          -> hasil upload staff (contoh: "menus/abc.jpg")
     3) cocokkan nama file di public/images/menu dengan isi kolom image ATAU nama menu,
        tanpa peduli huruf besar/kecil, spasi, tanda hubung, dan ekstensi
        (contoh: menu "Chicken Katsu Bowl" cocok dengan "Chicken-Katsu-Bowl.png")
     4) placeholder mangkuk --}}
@props(['image' => null, 'name' => ''])
@php
  $placeholder = asset('images/placeholder.svg');
  $norm = fn ($v) => strtolower(preg_replace('/[^a-z0-9]/i', '', pathinfo((string) $v, PATHINFO_FILENAME)));
  $enc  = fn ($f) => implode('/', array_map('rawurlencode', explode('/', $f)));
  $src  = null;

  if ($image && is_file(public_path('images/menu/'.$image))) {
      $src = asset('images/menu/'.$enc($image));
  } elseif ($image && str_contains($image, '/') && is_file(public_path('storage/'.$image))) {
      $src = asset('storage/'.$enc($image));
  } else {
      $map = [];
      foreach (glob(public_path('images/menu/*.*')) ?: [] as $path) {
          $map[$norm(basename($path))] = basename($path);
      }
      $file = ($image ? ($map[$norm(basename((string) $image))] ?? null) : null) ?? ($name ? ($map[$norm($name)] ?? null) : null);
      if ($file) $src = asset('images/menu/'.$enc($file));
  }
  $src = $src ?? $placeholder;
@endphp
<img src="{{ $src }}" alt="{{ $name }}" loading="lazy" onerror="this.onerror=null;this.src='{{ $placeholder }}'" {{ $attributes }}>
