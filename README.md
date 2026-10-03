# BowlMate

BowlMate adalah aplikasi web pemesanan makanan untuk restoran rice bowl dengan konsep dine-in. Pelanggan memilih outlet dan nomor meja, memesan menu dari meja mereka, lalu memantau status pesanan secara langsung. Staff outlet menerima dan memproses pesanan, mengelola menu, serta melihat transaksi.

Proyek ini dibuat sebagai tugas kelompok mata kuliah PPLW (UTS).

## Anggota Kelompok

1. Leora Shieny Nethania
2. Rangga Radhitya
3. Yuri Nifa Aulia

## Fitur

**Customer**
- Registrasi, login, dan logout
- Memilih outlet dan nomor meja (bisa lewat scan QR dengan `?no=`)
- Melihat daftar menu, pencarian, filter kategori, dan detail menu
- Keranjang belanja (tambah, ubah jumlah, hapus)
- Checkout dengan pembayaran QRIS atau tunai
- Memantau status pesanan secara otomatis dan melihat riwayat pesanan
- Profil: ubah data diri, foto profil, dan password, serta hapus akun

**Staff**
- Memilih outlet yang dikelola
- Daftar pesanan aktif dengan pembaruan otomatis, detail pesanan, dan pesanan selesai
- Mengubah status pesanan: Terima pesanan, Mulai dibuat, Siap diantar, Selesaikan
- Pembayaran tercatat lunas saat pesanan diterima
- Kelola menu (tambah, ubah, hapus, foto, dan tandai Tersedia atau Habis), kategori, dan meja
- Ubah informasi outlet
- Melihat daftar transaksi
- Profil dan foto profil

## Teknologi

- PHP 8.5 dan Laravel 13
- MySQL (bawaan Laragon)
- Blade, Bootstrap, dan JavaScript biasa untuk tampilan
- Composer untuk dependensi PHP

Proyek ini dikembangkan dan diuji dengan PHP 8.5.9, Laravel 13.34.0, dan Composer 2.10 di Laragon (Windows).

## Cara Menjalankan

Kebutuhan: PHP, Composer, dan MySQL (paling mudah memakai [Laragon](https://laragon.org)).

1. Clone repo dan masuk ke foldernya.

   ```powershell
   git clone https://github.com/rangga-radhitya/PPLW-UTS.git
   cd PPLW-UTS
   ```

2. Pasang dependensi.

   ```powershell
   composer install
   ```

3. Salin file environment lalu buat application key.

   ```powershell
   copy .env.example .env
   php artisan key:generate
   ```

4. Buat database kosong bernama `bowlmate` (lewat phpMyAdmin atau HeidiSQL di Laragon), lalu atur koneksinya di `.env`.

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bowlmate
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan pengaturan MySQL di komputermu.

5. Buat tabel dan isi data awal.

   ```powershell
   php artisan migrate:fresh --seed
   ```

6. Hubungkan folder penyimpanan agar foto menu dan foto profil tampil.

   ```powershell
   php artisan storage:link
   ```

7. Jalankan server.

   ```powershell
   php artisan serve
   ```

   Buka http://127.0.0.1:8000 di browser.

## Akun Tes

Dibuat otomatis oleh seeder. Password semua akun: `password`

| Peran | Email |
|---|---|
| Customer | customer@bowlmate.test |
| Staff | staff.a@bowlmate.test |

Akun staff lain per outlet juga dibuat oleh seeder. Daftar lengkapnya bisa dilihat dengan:

```powershell
php artisan tinker --execute="dump(App\Models\User::select('email','role')->get()->toArray());"
```

Akun ini hanya untuk demo. Jangan memakai password yang sama untuk akun pribadi.

## Alur Singkat untuk Demo

1. **Customer:** login, pilih outlet, klik nomor meja, tambah menu ke keranjang, lalu checkout.
2. **Staff:** login di jendela lain (misalnya Incognito), pilih outlet yang sama, buka halaman Pesanan, lalu tekan tombol status sampai Selesaikan.
3. **Customer:** status pesanan berubah otomatis, dan pembayaran tercatat lunas setelah pesanan diterima.
4. **Staff:** pesanan yang selesai muncul di Pesanan Selesai dan Transaksi.

## Struktur Singkat

```
app/Http/Controllers/
  Customer/      Menu, Outlet, Cart, Order
  Staff/         Order, Outlet, Menu, Category, Table, Transaksi
  ProfileController.php
app/Http/Middleware/RoleMiddleware.php     pembatas akses customer dan staff
app/Models/                                User, Outlet, Menu, Category, Table, Order, OrderItem, Payment
database/migrations/                       struktur tabel
database/seeders/                          data awal (outlet, menu, meja, akun)
resources/views/                           tampilan Blade (customer, staff, layouts, components)
routes/web.php                             seluruh route aplikasi
public/                                    CSS, JS, logo, dan foto menu
```

## Alur Kerja Git

- `main`: kode stabil yang siap dikumpulkan.
- `develop`: tempat semua pekerjaan digabung.
- `feature/*`: branch tiap tugas, dibuat dari `develop`.
- Semua perubahan masuk lewat Pull Request, tanpa push langsung ke `develop` atau `main`.

## Catatan

- Menghapus akun customer ikut menghapus riwayat pesanannya.
- Akun staff tidak bisa dihapus lewat halaman profil.
- Jangan commit file `.env`. Gunakan `.env.example` sebagai acuan.
