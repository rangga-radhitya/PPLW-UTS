{{-- Halaman awal "/" (Figma: Welcome & Entry) --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BowlMate - Rice Bowl &amp; Dine-in</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-bowlmate.png') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
  <main class="welcome">
    <div class="welcome__logo"><img src="{{ asset('images/logo/logo-bowlmate.png') }}" alt="BowlMate"></div>

    <div class="welcome__photo">
      <x-menu-image name="Chicken Katsu Bowl" />
      <span class="welcome__chip welcome__chip--top"><i class="bi bi-shop"></i> Pesan dari meja</span>
      <span class="welcome__chip welcome__chip--bottom"><i></i> Dine-in &bull; Dibuat segar</span>
    </div>

    <span class="welcome__tag"><i class="bi bi-stars"></i> Pengalaman makan dine-in</span>
    <h1 class="welcome__title">Rice Bowl Segar, Dipesan Langsung dari Mejamu</h1>
    <p class="welcome__text">Tanpa antre di kasir. Pilih outlet, pilih nomor mejamu, lalu nikmati donburi hangat yang diantar ke tempat dudukmu.</p>

    <div class="welcome__perks">
      <span><i class="bi bi-lightning-charge-fill"></i> Diantar ke meja</span>
      <span><i class="bi bi-egg-fried"></i> Dibuat saat dipesan</span>
      <span><i class="bi bi-mortarboard-fill"></i> Ramah mahasiswa</span>
    </div>

    <div class="welcome__actions">
      @auth
        <a href="{{ auth()->user()->role === 'staff' ? url('/staff/pilih-outlet') : url('/outlets') }}" class="btn btn-primary btn-xl">Lanjut ke aplikasi <i class="bi bi-arrow-right"></i></a>
      @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-xl"><i class="bi bi-box-arrow-in-right"></i> Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-white btn-xl"><i class="bi bi-person-check"></i> Buat Akun Gratis</a>
      @endauth
    </div>
    <p class="welcome__foot"><i></i> BowlMate &bull; Rice bowl &amp; dine-in</p>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
