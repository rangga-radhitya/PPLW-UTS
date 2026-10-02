@props(['status'])
@php
    $labels = ['pending'=>'Pending','confirmed'=>'Confirmed','processing'=>'Processing','ready'=>'Ready','done'=>'Done','paid'=>'Paid'];
@endphp
<span class="status-badge status-{{ $status }}">{{ $labels[$status] ?? ucfirst($status) }}</span>
