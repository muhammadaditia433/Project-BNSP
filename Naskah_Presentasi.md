# NASKAH PRESENTASI - Aplikasi BookStore (Laravel)

Perkiraan durasi 8-10 menit presentasi + 5 menit demo. Ganti [Nama] dan [NIM] dengan milikmu.

---
## Pembuka (Slide 1 - Judul)
"Assalamualaikum / selamat pagi Bapak/Ibu penguji. Perkenalkan saya [Nama], NIM [NIM]. Pada kesempatan ini saya mempresentasikan projek **Aplikasi BookStore atau Toko Buku Online berbasis web**, yang saya bangun menggunakan framework Laravel dan database MySQL."

## Slide 2 - Introduction
"BookStore adalah aplikasi toko buku online. Ada dua aktor: **Admin** yang mengelola data buku, kategori, user, dan pesanan; dan **User** yang mencari buku, memasukkan ke keranjang, lalu membayar. Aplikasi ini memakai HTML dan CSS untuk tampilan, PHP lewat Laravel untuk logika, dan MySQL untuk penyimpanan data."

## Slide 3 - Problem
"Masalah yang ingin diselesaikan ada empat. Pertama, pencatatan buku dan stok secara manual rawan salah. Kedua, pembeli harus datang langsung ke toko. Ketiga, pembayaran belum terintegrasi. Keempat, admin sulit memantau pesanan dan siapa saja pelanggannya. Aplikasi ini menjawab keempatnya dalam satu sistem."

## Slide 4 - Tools (jawaban untuk "pakai apa saja")
"Tools yang saya gunakan:
- **PHP 8.2** sebagai bahasa pemrograman sisi server.
- **Laravel 12** sebagai framework, memakai pola MVC: Model untuk data, View untuk tampilan, Controller untuk logika.
- **MySQL** sebagai database, dikelola lewat **phpMyAdmin** di **XAMPP**.
- **Blade, HTML, dan CSS** untuk antarmuka.
- **Composer** untuk mengelola paket PHP.
- **Midtrans Snap (sandbox)** untuk pembayaran online.
- **VS Code** sebagai editor, **Git dan GitHub** untuk penyimpanan dan pengumpulan kode."

## Slide 5 - Rancangan Database
"Database memiliki tujuh tabel: users, categories, books, cart_items, orders, order_items, dan messages. Tabel users punya kolom **role** untuk membedakan admin dan user. Satu kategori punya banyak buku. Satu user punya banyak pesanan, dan setiap pesanan punya banyak item pesanan. Relasi memakai foreign key sehingga data konsisten."

## Slide 6 - Fitur
"Admin dapat menambah, mengubah, dan menghapus kategori dan buku, melihat daftar user, melihat dan mengubah status pesanan, serta membaca pesan masuk. User dapat registrasi, login, melihat About Us, mengirim pesan ke admin, mencari buku, memakai keranjang, dan membayar pesanan. Hak akses admin dilindungi **middleware**, jadi user biasa tidak bisa membuka halaman admin."

## Slide 7 - Alur Pembelian
"Alurnya: user mencari buku, menambah ke keranjang, checkout dengan mengisi alamat, sistem membuat pesanan dan mengurangi stok, user membayar lewat Midtrans, status berubah menjadi *paid*, lalu admin memproses menjadi *shipped* dan *done*. Pembayaran dilakukan **sebelum** buku dikirim."

## Slide 8 - Output (DEMO LANGSUNG, urutan disarankan)
1. Buka halaman utama, tunjukkan katalog dan **cari** satu judul.
2. **Register** user baru, lalu login.
3. Buka detail buku, **tambah ke keranjang**, buka keranjang, ubah jumlah.
4. **Checkout**, isi alamat, lalu **bayar** (Midtrans sandbox atau tombol simulasi). Status menjadi *paid*.
5. Kirim pesan di menu **Hubungi Admin**. Buka **About Us**.
6. **Logout**, login sebagai admin (admin@bookstore.test / password).
7. Tunjukkan **Dashboard**, **CRUD Kategori**, **CRUD Buku** (tambah satu buku dengan cover), **Daftar User**, **Pesanan** (ubah status ke shipped), dan **Pesan Masuk**.
8. Tunjukkan phpMyAdmin: tabel dan data ikut berubah.

## Slide 9 - Penutup
"Kesimpulannya, aplikasi BookStore sudah memenuhi seluruh fitur Admin dan User yang diminta. Kendala yang saya hadapi adalah konfigurasi lingkungan (PHP dan Composer) dan integrasi pembayaran Midtrans. Pengembangan selanjutnya bisa berupa ulasan buku, laporan penjualan, dan perhitungan ongkos kirim. Kode lengkap dan file database ada di GitHub pada link di slide ini. Terima kasih, saya siap menjawab pertanyaan."

---
## Antisipasi pertanyaan penguji
- **Apa itu MVC?** Model mengurus data/database, View tampilan (file Blade di `resources/views`), Controller logika yang menghubungkan keduanya.
- **Bagaimana membedakan admin dan user?** Kolom `role` di tabel users + `AdminMiddleware` yang memblokir akses non-admin (error 403).
- **Bagaimana password disimpan?** Di-hash (bcrypt) otomatis oleh Laravel, bukan teks biasa.
- **Bagaimana keamanan form?** Token CSRF (`@csrf`) di semua form dan validasi input di controller.
- **Di mana relasi tabel?** Di migration (`foreignId()->constrained()`) dan di model (`hasMany`, `belongsTo`).
- **Bagaimana pembayaran bekerja?** Server meminta Snap Token ke Midtrans, popup Snap muncul di browser, lalu status pesanan diperbarui lewat pengecekan status/notifikasi (callback) Midtrans yang diverifikasi dengan signature key.
- **Kenapa stok bisa tidak minus?** Saat checkout, stok dicek dalam database transaction (`lockForUpdate`) dan dikurangi; jika pesanan dibatalkan, stok dikembalikan.
- **Apa bedanya migration dan seeder?** Migration membuat struktur tabel, seeder mengisi data awal.
