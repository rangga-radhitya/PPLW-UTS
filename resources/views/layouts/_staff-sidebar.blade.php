<a class="brand" href="{{ url('/staff/pesanan') }}"><i class="bi bi-bowl-hot-fill"></i> BowlMate</a>
@if($outletName)<div class="small mb-3 opacity-75"><i class="bi bi-geo-alt"></i> {{ $outletName }}</div>@endif
<nav class="nav flex-column gap-1">
  @foreach($links as [$href, $pattern, $icon, $label])
    <a class="nav-link {{ request()->is($pattern) ? 'active' : '' }}" href="{{ url($href) }}"><i class="bi {{ $icon }}"></i> {{ $label }}</a>
  @endforeach
</nav>
<div class="mt-auto pt-4">
  <a class="nav-link" href="{{ url('/staff/pilih-outlet') }}"><i class="bi bi-arrow-left-right"></i> Ganti outlet</a>
  <form method="POST" action="{{ route('logout') }}">@csrf
    <button class="nav-link w-100 border-0 bg-transparent text-start"><i class="bi bi-box-arrow-right"></i> Keluar</button>
  </form>
</div>
