-- ===========================================================
-- Database BookStore (MySQL / MariaDB)
-- Import lewat phpMyAdmin: tab Import -> pilih file ini -> Go
-- Akun demo (password semua: password)
--   Admin : admin@bookstore.test
--   User  : user@bookstore.test
-- ===========================================================
CREATE DATABASE IF NOT EXISTS `bookstore` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bookstore`;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `messages`, `order_items`, `orders`, `cart_items`, `books`, `categories`, `users`;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL DEFAULT 'user',
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `books` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` BIGINT UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) NOT NULL,
  `price` INT UNSIGNED NOT NULL,
  `stock` INT UNSIGNED NOT NULL DEFAULT 0,
  `description` TEXT NULL,
  `cover` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `books_category_id_foreign` (`category_id`),
  CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cart_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `book_id` BIGINT UNSIGNED NOT NULL,
  `qty` INT UNSIGNED NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cart_items_user_id_book_id_unique` (`user_id`,`book_id`),
  CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `orders` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `code` VARCHAR(255) NOT NULL,
  `total` INT UNSIGNED NOT NULL,
  `address` TEXT NOT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'pending',
  `snap_token` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_code_unique` (`code`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `order_items` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` BIGINT UNSIGNED NOT NULL,
  `book_id` BIGINT UNSIGNED NOT NULL,
  `price` INT UNSIGNED NOT NULL,
  `qty` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `messages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `subject` VARCHAR(255) NOT NULL,
  `body` TEXT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------- DATA CONTOH ----------------
INSERT INTO `users` (`id`,`name`,`email`,`password`,`role`,`created_at`,`updated_at`) VALUES
(1,'Admin BookStore','admin@bookstore.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin',NOW(),NOW()),
(2,'Budi Santoso','user@bookstore.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','user',NOW(),NOW());

INSERT INTO `categories` (`id`,`name`,`created_at`,`updated_at`) VALUES
(1,'Novel',NOW(),NOW()),(2,'Teknologi',NOW(),NOW()),(3,'Pendidikan',NOW(),NOW()),(4,'Anak-anak',NOW(),NOW());

INSERT INTO `books` (`id`,`category_id`,`title`,`author`,`price`,`stock`,`description`,`created_at`,`updated_at`) VALUES
(1,1,'Laskar Pelangi','Andrea Hirata',89000,19,'Kisah sepuluh anak Belitung yang berjuang menempuh pendidikan.',NOW(),NOW()),
(2,1,'Bumi Manusia','Pramoedya Ananta Toer',110000,15,'Novel sejarah pertama dari Tetralogi Buru.',NOW(),NOW()),
(3,1,'Pulang','Tere Liye',85000,12,'Perjalanan Bujang mencari jati diri dan keluarga.',NOW(),NOW()),
(4,2,'Belajar Laravel untuk Pemula','Tim Pustaka Kode',120000,9,'Panduan membuat aplikasi web dengan Laravel dari nol.',NOW(),NOW()),
(5,2,'Dasar-dasar MySQL','Rina Wulandari',95000,8,'Perancangan database, query, dan relasi tabel.',NOW(),NOW()),
(6,3,'Atomic Habits (Edisi Indonesia)','James Clear',105000,23,'Cara membangun kebiasaan baik dan meninggalkan yang buruk.',NOW(),NOW()),
(7,4,'Kumpulan Dongeng Nusantara','Tim Redaksi',65000,30,'Dongeng rakyat dari berbagai daerah di Indonesia.',NOW(),NOW()),
(8,4,'Ensiklopedia Hewan','A. Pratama',78000,18,'Mengenal hewan dari seluruh dunia dengan gambar menarik.',NOW(),NOW());

INSERT INTO `orders` (`id`,`user_id`,`code`,`total`,`address`,`status`,`created_at`,`updated_at`) VALUES
(1,2,'BK-DEMO0001',299000,'Jl. Merdeka No. 10, Sumbawa Besar, NTB','paid',NOW(),NOW()),
(2,2,'BK-DEMO0002',120000,'Jl. Merdeka No. 10, Sumbawa Besar, NTB','pending',NOW(),NOW());

INSERT INTO `order_items` (`order_id`,`book_id`,`price`,`qty`,`created_at`,`updated_at`) VALUES
(1,1,89000,1,NOW(),NOW()),(1,6,105000,2,NOW(),NOW()),(2,4,120000,1,NOW(),NOW());

INSERT INTO `messages` (`user_id`,`subject`,`body`,`created_at`,`updated_at`) VALUES
(2,'Tanya ketersediaan buku','Halo admin, apakah buku Bumi Manusia akan di-restock bulan depan?',NOW(),NOW());
