<a class="staff-logo" href="{{ url('/staff/pesanan') }}" aria-label="BowlMate Staff">
  <span class="staff-logo__icon"><i class="bi bi-egg-fried"></i></span>
  <span><b>BowlMate Staff</b><small>Operational Hub</small></span>
</a>
<nav class="nav flex-column gap-1">
  @foreach($links as [$href, $pattern, $icon, $label])
    <a class="nav-link {{ request()->is($pattern) ? 'active' : '' }}" href="{{ url($href) }}"><i class="bi {{ $icon }}"></i> {{ $label }}</a>
  @endforeach
</nav>
<div class="staff-side__bottom">
  <a class="staff-side__btn" href="{{ url('/staff/pilih-outlet') }}"><i class="bi bi-arrow-left-right"></i> Ganti Outlet</a>
  <a class="nav-link {{ request()->is('profil') ? 'active' : '' }}" href="{{ url('/profil') }}"><x-avatar :user="auth()->user()" :size="24" /> Profil Staf</a>
  <form method="POST" action="{{ route('logout') }}"
        data-confirm="Kamu akan keluar dari sesi staff di perangkat ini." data-confirm-title="Keluar dari akun?" data-confirm-ok="Keluar" data-confirm-danger>
    @csrf
    <button class="nav-link nav-link--danger w-100 border-0 bg-transparent text-start"><i class="bi bi-box-arrow-right"></i> Keluar</button>
  </form>
</div>
