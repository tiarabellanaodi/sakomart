<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Home';
include 'includes/header.php';
?>

<div class="container-custom">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1>Selamat Datang di SakoMart</h1>
        <p>Sistem Aplikasi Kasir Modern untuk Kemudahan Transaksi Anda</p>
    </div>
    
    <!-- Feature Cards -->
    <div class="feature-cards">
        <a href="transaksi.php" class="feature-card">
            <i class="fas fa-cash-register"></i>
            <h3>Transaksi</h3>
            <p>Kelola transaksi penjualan dengan cepat dan mudah</p>
        </a>
        
        <a href="kelola_barang.php" class="feature-card">
            <i class="fas fa-boxes"></i>
            <h3>Kelola Barang</h3>
            <p>Atur dan kelola data barang yang tersedia</p>
        </a>
        
        <a href="kelola_pelanggan.php" class="feature-card">
            <i class="fas fa-users"></i>
            <h3>Kelola Pelanggan</h3>
            <p>Manajemen data pelanggan dengan efisien</p>
        </a>
        
        <a href="riwayat.php" class="feature-card">
            <i class="fas fa-history"></i>
            <h3>Riwayat Penjualan</h3>
            <p>Lihat dan export riwayat transaksi penjualan</p>
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
