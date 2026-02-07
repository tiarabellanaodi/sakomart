<?php
requireLogin();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>SakoMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="header-left">
            <h2><i class="fas fa-shopping-cart"></i> SakoMart</h2>
        </div>
        <div class="header-right">
            <div class="user-info">
                <div class="username"><?php echo $_SESSION['nama_lengkap']; ?></div>
                <div class="role">Kasir</div>
            </div>
            <a href="logout.php" class="btn btn-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav class="main-nav">
        <ul class="nav-menu">
            <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Home
            </a></li>
            <li><a href="transaksi.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active' : ''; ?>">
                <i class="fas fa-cash-register"></i> Transaksi
            </a></li>
            <li><a href="kelola_barang.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'kelola_barang.php' ? 'active' : ''; ?>">
                <i class="fas fa-boxes"></i> Kelola Barang
            </a></li>
            <li><a href="kelola_pelanggan.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'kelola_pelanggan.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Kelola Pelanggan
            </a></li>
            <li><a href="riwayat.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'active' : ''; ?>">
                <i class="fas fa-history"></i> Riwayat Penjualan
            </a></li>
        </ul>
    </nav>
