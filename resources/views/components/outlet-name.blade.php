{{-- Mengeluarkan nama outlet yang dipilih customer (dari session), atau kosong. --}}
@php
  $found = null;
  foreach (session()->all() as $k => $v) {
      if (stripos((string) $k, 'outlet') !== false) { $found = $v; break; }
  }
  $name = null;
  if (is_object($found)) { $name = $found->name ?? null; }
  elseif (is_array($found)) { $name = $found['name'] ?? null; }
  elseif (is_numeric($found) && class_exists(\App\Models\Outlet::class)) { $name = optional(\App\Models\Outlet::find($found))->name; }
  elseif (is_string($found) && $found !== '') { $name = $found; }
@endphp
{{ $name }}
