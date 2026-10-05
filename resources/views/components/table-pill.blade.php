@php $no = trim(\Illuminate\Support\Facades\Blade::render('<x-table-no />')); @endphp
@if($no !== '')
  <span class="table-pill"><i></i> Meja {{ $no }} &bull; Dine In</span>
@endif
