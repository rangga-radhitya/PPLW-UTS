# Catatan Front End BowlMate

Salin folder `public/` dan `resources/views/` ke root project Laravel (gabungkan, jangan hapus file Breeze lain).
`auth/login.blade.php` dan `auth/register.blade.php` akan menimpa versi Breeze.

Branch saran: feature/fe-layout (layouts, komponen, css, js, auth), lalu feature/fe-customer-*, feature/fe-staff-*.

## Hal yang perlu dicocokkan dengan Back End (kontrak)
1. Nama field form: keranjang `menu_id` + `quantity`; checkout `payment_method` (qris/cash);
   pilih outlet staff `outlet_id` (POST /staff/pilih-outlet); ketersediaan menu `is_available` (0/1);
   ubah status `status`.
2. Bentuk `$cart`: [menu_id => ['name','price','quantity','image']]. Kunci session keranjang diasumsikan `cart`.
3. Variabel halaman resource staff: menu `$menus/$menu/$categories`, kategori `$categories/$category`, meja `$tables/$table`.
4. Relasi model yang dipakai view: Order->items (atau orderItems), payment, table, outlet, user; OrderItem->menu; Menu->category.
5. JSON polling customer: `{ "status": "...", "payment_status": "..." }` (payment_status opsional).
6. Polling staff mengambil ulang halaman /staff/pesanan, jadi tidak tergantung bentuk JSON /staff/pesanan/data.
7. Semua link/form memakai url('/...') sesuai bagian 6 panduan. Kalau BE sudah memberi nama route, boleh diganti ke route('nama').
