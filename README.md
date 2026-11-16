# BookStore - Aplikasi Toko Buku (Laravel + MySQL)

Aplikasi toko buku dengan 2 aktor (Admin dan User). Dibuat dengan Laravel 12 (kompatibel Laravel 11), PHP 8.2, MySQL, HTML/CSS (Blade), dan Midtrans Snap (sandbox).

## Fitur
**Admin**: CRUD Kategori, CRUD Buku (upload cover), daftar user terdaftar, daftar pesanan + ubah status, pesan masuk, dashboard ringkasan.
**User**: registrasi, login, About Us, hubungi admin, pencarian buku (judul/penulis/kategori), keranjang, checkout, pembayaran via Midtrans (bayar dulu sebelum dikirim), riwayat pesanan.

## Cara Instalasi (Windows + XAMPP)

Syarat: PHP 8.2+, Composer, MySQL berjalan (XAMPP > Start MySQL).

1. Buat projek Laravel kosong:
   ```
   cd C:\xampp_baru\htdocs\BNSP
   composer create-project laravel/laravel:^12.0 bookstore
   ```
2. **Salin SEMUA isi** folder `bookstore_kode` (folder `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, file `setup.ps1`, `bookstore.sql`) ke dalam folder `bookstore`. Jika ditanya, pilih **Replace / timpa**.
3. Buat database kosong `bookstore` di http://localhost/phpmyadmin (atau lewati: langkah 4 akan dibuat otomatis jika memakai opsi B).
4. Pilih salah satu:

   **Opsi A - Migrasi Laravel (disarankan)**
   ```
   cd bookstore
   powershell -ExecutionPolicy Bypass -File setup.ps1
   ```
   Script ini mengatur `.env`, membuat tabel, mengisi data awal, dan `storage:link`.

   **Opsi B - Import SQL**: di phpMyAdmin tab *Import*, pilih `bookstore.sql`. Lalu atur `.env` secara manual (lihat bawah) dan jalankan `php artisan key:generate` dan `php artisan storage:link`.

5. Jalankan: `php artisan serve` lalu buka http://127.0.0.1:8000

### Pengaturan `.env` manual (Opsi B)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookstore
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
```

## Akun demo (password: `password`)
| Peran | Email |
|---|---|
| Admin | admin@bookstore.test |
| User  | user@bookstore.test |

## Midtrans (opsional)
Tanpa key, aplikasi berjalan **mode demo**: tombol "Simulasi Pembayaran" muncul di halaman pesanan.
Untuk Midtrans sungguhan (sandbox): daftar di https://dashboard.sandbox.midtrans.com, ambil Server Key dan Client Key (Settings > Access Keys), isi di `.env`, lalu `php artisan config:clear`. Setelah membayar di popup Snap, status otomatis dicek lewat tombol/redirect "Cek Status Pembayaran". Untuk notifikasi otomatis (webhook) jalankan `ngrok http 8000` dan isi `https://xxxx.ngrok-free.app/midtrans/callback` di Settings > Payment > Notification URL.
Kartu uji sandbox: 4811 1111 1111 1114, CVV 123, OTP 112233.

## Struktur penting
```
routes/web.php                      semua route
app/Http/Controllers/               AuthController, HomeController, CartController, CheckoutController, ContactController
app/Http/Controllers/Admin/         Dashboard, Category, Book, User, Order, Message
app/Http/Middleware/AdminMiddleware.php
app/Models/                         User, Category, Book, CartItem, Order, OrderItem, Message
database/migrations/                skema database
database/seeders/DatabaseSeeder.php data awal
resources/views/                    tampilan Blade (HTML)
public/css/style.css                CSS
bookstore.sql                       export database
```

## Upload ke GitHub
```
cd bookstore
git init
git add .
git commit -m "BookStore Laravel"
git branch -M main
git remote add origin https://github.com/USERNAME/bookstore.git
git push -u origin main
```
(`vendor` dan `.env` otomatis diabaikan oleh `.gitignore`.) Jangan lupa sertakan `bookstore.sql` di repo.

## Portofolio
https://muhammadaditia433.github.io/muhamadaditia/
