# BookStore - Toko Buku Online (Laravel 12 + MySQL)

Aplikasi toko buku dengan dua role (Admin dan User). Tampilan modern dengan CSS manual (tanpa framework CSS).

## Fitur
**User**: registrasi (setelah daftar diarahkan ke login), login, profil (ubah data dan password), About Us, hubungi admin, cari dan filter buku, keranjang, checkout (QRIS atau COD), upload bukti bayar, riwayat pesanan.
**Admin**: dashboard, CRUD kategori, CRUD buku (upload cover), daftar user, daftar pesanan + cek bukti bayar + ubah status, pesan masuk.

## Instalasi (Windows + XAMPP)
1. Nyalakan **MySQL** di XAMPP. Pastikan `php -v` dan `composer -V` berjalan.
2. Buat projek Laravel kosong:
   ```
   cd C:\xampp_baru\htdocs\BNSP
   composer create-project laravel/laravel:^12.0 bookstore-app
   ```
3. Salin **semua isi** folder `bookstore_kode` (app, bootstrap, database, public, resources, routes, setup.ps1, bookstore.sql) ke `bookstore-app`. Pilih **Replace** jika ditanya.
   - Jika kamu sudah punya `public/images/qris.png` sendiri, file itu tidak ditimpa (zip hanya berisi `qris-contoh.png`).
4. Jalankan:
   ```
   cd bookstore-app
   powershell -ExecutionPolicy Bypass -File setup.ps1
   php artisan serve
   ```
   `setup.ps1` mengatur `.env`, membuat tabel, mengisi data awal, dan `storage:link`. Perintahnya menghapus data lama di database `bookstore`.
5. Buka http://127.0.0.1:8000

Alternatif tanpa `setup.ps1`: import `bookstore.sql` lewat phpMyAdmin, atur `.env` (lihat bawah), lalu `php artisan key:generate` dan `php artisan storage:link`.

### `.env` penting
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
```

## Akun demo (password: `password`)
| Role | Email |
|---|---|
| Admin | admin@bookstore.test |
| User | user@bookstore.test |

## Pembayaran
- **QRIS**: user scan, bayar, lalu unggah foto bukti di halaman pesanan. Status menjadi `verifying`, lalu admin memeriksa bukti dan mengubah status ke `paid`, `shipped`, `done`.
- **COD**: bayar tunai ke kurir saat buku diterima. Admin memproses ke `shipped` dan `done`.
- Pasang gambar QRIS milikmu di `public/images/qris.png`. Jika belum ada, aplikasi menampilkan gambar contoh.

## Mengganti cover buku
Admin: menu Buku, Edit, pilih file di kolom Cover, Simpan. Cover bawaan ada di `public/images/books`.

## Struktur penting
```
routes/web.php
app/Http/Controllers/       AuthController, ProfileController, HomeController, CartController, CheckoutController, ContactController
app/Http/Controllers/Admin/ Dashboard, Category, Book, User, Order, Message
app/Http/Middleware/AdminMiddleware.php
app/Models/                 User, Category, Book, CartItem, Order, OrderItem, Message
database/migrations/        skema database
database/seeders/           data awal
resources/views/            tampilan Blade
public/css/style.css        tema
bookstore.sql               ekspor database
```

<<<<<<< HEAD
## Menambah admin
Admin tidak bisa dibuat lewat registrasi. Daftarkan akun biasa, lalu ubah kolom `role` menjadi `admin` di phpMyAdmin (tabel `users`).
=======
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
>>>>>>> 3f2c9f419b65da47f20355b5ab140a2696da210a
