-- Database: sakomart
CREATE DATABASE IF NOT EXISTS sakomart;
USE sakomart;

-- Tabel users (untuk login)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel barang
CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel pelanggan
CREATE TABLE IF NOT EXISTS pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    no_telp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel transaksi
CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT,
    id_user INT,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_harga DECIMAL(10,2) NOT NULL,
    bayar DECIMAL(10,2) NOT NULL,
    kembalian DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id),
    FOREIGN KEY (id_user) REFERENCES users(id)
);

-- Tabel detail transaksi
CREATE TABLE IF NOT EXISTS detail_transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_barang INT,
    nama_barang VARCHAR(100),
    harga DECIMAL(10,2),
    jumlah INT,
    subtotal DECIMAL(10,2),
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (id_barang) REFERENCES barang(id)
);

-- Insert data user default (username: admin, password: admin)
INSERT INTO users (username, password, nama_lengkap) VALUES 
('admin', MD5('admin'), 'Administrator');

-- Insert data barang contoh
INSERT INTO barang (nama_barang, harga, stok) VALUES 
('Indomie Goreng', 3500.00, 100),
('Aqua 600ml', 3000.00, 50),
('Teh Botol Sosro', 4000.00, 75),
('Kopi Kapal Api', 2000.00, 200),
('Susu Ultra Milk', 8000.00, 40);

-- Insert data pelanggan contoh
INSERT INTO pelanggan (nama, alamat, no_telp) VALUES 
('Umum', '-', '-'),
('Budi Santoso', 'Jl. Merdeka No. 10', '081234567890'),
('Siti Aminah', 'Jl. Sudirman No. 25', '082345678901');
