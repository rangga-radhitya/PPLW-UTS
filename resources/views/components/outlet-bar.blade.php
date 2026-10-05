@php $name = trim(\Illuminate\Support\Facades\Blade::render('<x-outlet-name />')); @endphp
@if($name !== '')
  <div class="outlet-bar">
    <span class="outlet-bar__icon"><i class="bi bi-geo-alt-fill"></i></span>
    <div><div class="outlet-bar__label">OUTLET</div><div class="outlet-bar__name">{{ $name }}</div></div>
    <a href="{{ url('/outlets') }}" class="outlet-bar__btn">Ganti <i class="bi bi-chevron-down"></i></a>
  </div>
@endif
