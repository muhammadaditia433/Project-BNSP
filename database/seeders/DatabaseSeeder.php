<?php

namespace Database\Seeders;

use App\Models\{Book, Category, User};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Admin BookStore', 'email' => 'admin@bookstore.test', 'password' => 'password', 'role' => 'admin']);
        User::create(['name' => 'Budi Santoso', 'email' => 'user@bookstore.test', 'password' => 'password', 'role' => 'user']);

        $cats = collect(['Novel', 'Teknologi', 'Pendidikan', 'Anak-anak'])
            ->mapWithKeys(fn ($n) => [$n => Category::create(['name' => $n])->id]);

        // [kategori, judul, penulis, harga, stok, deskripsi, file cover di public/images/books]
        $books = [
            ['Novel', 'Laskar Pelangi', 'Andrea Hirata', 89000, 20, 'Kisah sepuluh anak Belitung yang berjuang menempuh pendidikan.', 'laskar-pelangi'],
            ['Novel', 'Bumi Manusia', 'Pramoedya Ananta Toer', 110000, 15, 'Novel sejarah pertama dari Tetralogi Buru.', 'bumi-manusia'],
            ['Novel', 'Pulang', 'Tere Liye', 85000, 12, 'Perjalanan Bujang mencari jati diri dan keluarga.', 'pulang'],
            ['Teknologi', 'Belajar Laravel untuk Pemula', 'Tim Pustaka Kode', 120000, 10, 'Panduan membuat aplikasi web dengan Laravel dari nol.', 'belajar-laravel'],
            ['Teknologi', 'Dasar-dasar MySQL', 'Rina Wulandari', 95000, 8, 'Perancangan database, query, dan relasi tabel.', 'dasar-mysql'],
            ['Pendidikan', 'Atomic Habits (Edisi Indonesia)', 'James Clear', 105000, 25, 'Cara membangun kebiasaan baik dan meninggalkan yang buruk.', 'atomic-habits'],
            ['Anak-anak', 'Kumpulan Dongeng Nusantara', 'Tim Redaksi', 65000, 30, 'Dongeng rakyat dari berbagai daerah di Indonesia.', 'dongeng-nusantara'],
            ['Anak-anak', 'Ensiklopedia Hewan', 'A. Pratama', 78000, 18, 'Mengenal hewan dari seluruh dunia dengan gambar menarik.', 'ensiklopedia-hewan'],
        ];

        foreach ($books as [$cat, $title, $author, $price, $stock, $desc, $img]) {
            Book::create([
                'category_id' => $cats[$cat], 'title' => $title, 'author' => $author,
                'price' => $price, 'stock' => $stock, 'description' => $desc,
                'cover' => "images/books/$img.png",
            ]);
        }
    }
}
