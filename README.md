# SAKOMART - APLIKASI KASIR

Aplikasi kasir modern berbasis web menggunakan PHP Native, MySQL, HTML, CSS, JavaScript, dan Bootstrap.

## FITUR APLIKASI

1. **Login System** - Autentikasi user dengan username dan password
2. **Homepage** - Dashboard dengan menu navigasi
3. **Transaksi** - Sistem kasir untuk mencatat penjualan
4. **Kelola Barang** - CRUD (Create, Read, Update, Delete) data barang
5. **Kelola Pelanggan** - CRUD data pelanggan
6. **Riwayat Penjualan** - Melihat dan export riwayat transaksi ke Excel

## TEKNOLOGI YANG DIGUNAKAN

- HTML5
- CSS3
- JavaScript (ES6)
- Bootstrap 5.3
- Font Awesome 6.4
- jQuery 3.6
- PHP 7.4+ (Native)
- MySQL 5.7+

## CARA INSTALASI

### 1. Persiapan Server Lokal

Pastikan Anda sudah menginstall:
- XAMPP / WAMP / LAMP / MAMP
- PHP versi 7.4 atau lebih tinggi
- MySQL / MariaDB

### 2. Extract File

Extract folder `sakomart` ke dalam folder:
- `C:/xampp/htdocs/` (untuk XAMPP)
- `C:/wamp64/www/` (untuk WAMP)
- `/var/www/html/` (untuk Linux)

### 3. Membuat Database

1. Buka browser dan akses `http://localhost/phpmyadmin`
2. Klik tab "New" atau "Baru" untuk membuat database baru
3. Beri nama database: `sakomart`
4. Klik tab "Import" atau "Impor"
5. Pilih file `database.sql` yang ada di folder sakomart
6. Klik "Go" atau "Kirim"

**ATAU** jalankan query SQL berikut di phpMyAdmin:

```sql
CREATE DATABASE sakomart;
```

Kemudian import file `database.sql`

### 4. Konfigurasi Database

Buka file `includes/config.php` dan sesuaikan konfigurasi:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Sesuaikan username MySQL
define('DB_PASS', '');              // Sesuaikan password MySQL
define('DB_NAME', 'sakomart');
```

### 5. Menjalankan Aplikasi

1. Start Apache dan MySQL dari XAMPP Control Panel
2. Buka browser dan akses: `http://localhost/sakomart`
3. Login dengan kredensial default:
   - **Username**: admin
   - **Password**: admin

## STRUKTUR FOLDER

```
sakomart/
│
├── css/
│   └── style.css                 # Custom CSS
│
├── js/
│   └── script.js                 # Custom JavaScript
│
├── includes/
│   ├── config.php                # Konfigurasi database
│   ├── functions.php             # Fungsi-fungsi PHP
│   ├── header.php                # Header template
│   └── footer.php                # Footer template
│
├── exports/                       # Folder untuk file export
│
├── database.sql                   # File SQL database
├── login.php                      # Halaman login
├── logout.php                     # Proses logout
├── index.php                      # Homepage
├── transaksi.php                  # Halaman transaksi
├── kelola_barang.php             # Halaman kelola barang
├── kelola_pelanggan.php          # Halaman kelola pelanggan
├── riwayat.php                   # Halaman riwayat penjualan
├── get_detail_transaksi.php      # AJAX get detail transaksi
├── export_excel.php              # Export data ke Excel
└── README.md                      # File dokumentasi
```

## CARA MENGGUNAKAN

### Login
1. Akses `http://localhost/sakomart`
2. Masukkan username dan password
3. Klik tombol "Login"

### Transaksi Penjualan
1. Klik menu "Transaksi"
2. Pilih pelanggan dari dropdown
3. Pilih barang yang akan dibeli
4. Klik "Tambah Barang"
5. Atur jumlah barang dengan tombol + dan -
6. Masukkan jumlah uang bayar
7. Kembalian akan dihitung otomatis
8. Klik "Simpan Transaksi"

### Kelola Barang
1. Klik menu "Kelola Barang"
2. Untuk menambah: Klik tombol "Tambah Barang"
3. Untuk edit: Klik tombol "Edit" pada baris barang
4. Untuk hapus: Klik tombol "Hapus" pada baris barang

### Kelola Pelanggan
1. Klik menu "Kelola Pelanggan"
2. Untuk menambah: Klik tombol "Tambah Pelanggan"
3. Untuk edit: Klik tombol "Edit" pada baris pelanggan
4. Untuk hapus: Klik tombol "Hapus" pada baris pelanggan

### Riwayat Penjualan
1. Klik menu "Riwayat Penjualan"
2. Lihat semua transaksi yang telah dilakukan
3. Klik "Detail" untuk melihat detail transaksi
4. Klik "Export ke Excel" untuk download laporan

## DATA DEFAULT

### User
- Username: admin
- Password: admin

### Barang
- Indomie Goreng - Rp 3.500 (Stok: 100)
- Aqua 600ml - Rp 3.000 (Stok: 50)
- Teh Botol Sosro - Rp 4.000 (Stok: 75)
- Kopi Kapal Api - Rp 2.000 (Stok: 200)
- Susu Ultra Milk - Rp 8.000 (Stok: 40)

### Pelanggan
- Umum
- Budi Santoso
- Siti Aminah

## TROUBLESHOOTING

### Error: Database Connection Failed
- Pastikan MySQL sudah running
- Cek konfigurasi di `includes/config.php`
- Pastikan database `sakomart` sudah dibuat

### Error: Page Not Found
- Pastikan folder sakomart sudah di htdocs
- Akses dengan URL yang benar: `http://localhost/sakomart`

### Error: Call to undefined function
- Pastikan PHP extension yang dibutuhkan sudah aktif
- Cek php.ini dan aktifkan extension mysqli

### Tidak bisa login
- Pastikan database sudah di-import
- Cek tabel users sudah ada data
- Gunakan kredensial: admin / admin

## FITUR TAMBAHAN

- Responsive design (mobile friendly)
- Alert notification
- Modal popup
- LocalStorage untuk keranjang belanja
- Auto calculate total, bayar, kembalian
- Export to Excel

## KEAMANAN

- Input sanitization
- SQL injection prevention
- Session management
- Password encryption (MD5)

**Catatan**: Untuk production, disarankan menggunakan password hashing yang lebih kuat seperti `password_hash()` dan `password_verify()`.

## PENGEMBANGAN LEBIH LANJUT

Aplikasi ini masih bisa dikembangkan dengan fitur:
- Laporan grafik penjualan
- Multi level user (admin, kasir)
- Print struk transaksi
- Barcode scanner
- Notifikasi stok barang habis
- Backup database otomatis

## LISENSI

Free to use for educational purposes.

## KONTAK

Untuk pertanyaan dan saran, silakan hubungi developer.

---

© 2024 SakoMart - Sistem Aplikasi Kasir
