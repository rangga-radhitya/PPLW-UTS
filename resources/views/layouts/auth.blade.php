<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Masuk') - BowlMate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/logo/logo-bowlmate.png') }}">
</head>
<body>
  <div class="auth-wrap">
    <div class="auth-card">
      <div class="auth-top">
        <a href="{{ url('/') }}" class="bm-back" aria-label="Kembali"><i class="bi bi-arrow-left"></i></a>
        <a class="brand" href="{{ url('/') }}" aria-label="BowlMate"><img src="{{ asset('images/logo/logo-bowlmate.png') }}" alt="BowlMate" class="brand-logo"></a>
        <span class="auth-top__spacer"></span>
      </div>
      <x-flash-alert />
      @yield('content')
    </div>
  </div>
  @include('partials.overlays')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
