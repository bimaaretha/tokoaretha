-- Struktur database sesuai kode toko_online
-- Jalankan di phpMyAdmin (tab SQL) kalau database belum ada.
CREATE DATABASE IF NOT EXISTS toko_db;
USE toko_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    harga INT NOT NULL,
    gambar VARCHAR(255)
);
