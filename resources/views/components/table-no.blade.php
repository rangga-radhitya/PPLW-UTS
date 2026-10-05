{{-- Mengeluarkan nomor meja yang dipilih customer (dibaca dari session yang disimpan BE), atau kosong. --}}
@php
  $no = null;
  foreach (session()->all() as $k => $v) {
      if (! preg_match('/table|meja/i', (string) $k)) continue;
      if (is_object($v)) { $no = $v->table_number ?? null; }
      elseif (is_array($v)) { $no = $v['table_number'] ?? ($v['number'] ?? null); }
      elseif (is_scalar($v) && $v !== '') {
          $no = $v;
          if (preg_match('/id$/i', (string) $k) && is_numeric($v) && class_exists(\App\Models\Table::class)) {
              $t = \App\Models\Table::find($v);
              $no = $t->table_number ?? $v;
          }
      }
      if ($no !== null) break;
  }
@endphp
{{ $no }}
