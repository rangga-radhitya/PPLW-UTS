# BowlMate Frontend Lengkap

Bundle Front End untuk project Laravel BowlMate berdasarkan Panduan Struktur Project BowlMate.

## Area Front End
- `resources/views/`
- `public/css/style.css`
- `public/js/`
- `public/images/`

## Kontrak variabel utama
Customer:
- `/outlets` -> `$outlets`
- `/outlets/{id}/meja` -> `$outlet`, `$tables`
- `/menu` -> `$menus`, `$categories`
- `/menu/{id}` -> `$menu`
- `/keranjang` -> `$cart`, `$total`
- `/checkout` -> `$cart`, `$total`
- `/pesanan/{id}` -> `$order`
- `/riwayat` -> `$orders`
- `/profil` -> `$user`

Staff:
- `/staff/pilih-outlet` -> `$outlets`
- `/staff/pesanan` -> `$orders`
- `/staff/pesanan/{id}` -> `$order`
- `/staff/transaksi` -> `$payments`

Bundle ini sengaja tidak mengubah `routes/web.php`, controller, migration, model, middleware, atau database. Setelah clone/pull project Laravel, salin isi bundle ini ke project dan sesuaikan bila ada perbedaan implementasi backend.
