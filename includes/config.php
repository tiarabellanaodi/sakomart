<?php
// Konfigurasi database
define('DB_HOST', 'localhost');
define('DB_USER', 'sakg3244_sakomart');
define('DB_PASS', 'Lkjhgfdsa123');
define('DB_NAME', 'sakg3244_sakomart');

// Koneksi ke database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset
mysqli_set_charset($conn, "utf8");
?>
