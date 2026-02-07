<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

requireLogin();

// Set header untuk download Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Riwayat_Penjualan_" . date('Y-m-d') . ".xls");

// Ambil semua transaksi
$query = "SELECT t.*, p.nama as nama_pelanggan, u.nama_lengkap as nama_kasir 
          FROM transaksi t 
          LEFT JOIN pelanggan p ON t.id_pelanggan = p.id 
          LEFT JOIN users u ON t.id_user = u.id 
          ORDER BY t.tanggal DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Penjualan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4472C4;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>RIWAYAT PENJUALAN SAKOMART</h2>
    <p>Tanggal Export: <?php echo date('d/m/Y H:i:s'); ?></p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Kasir</th>
                <th>Total Harga</th>
                <th>Bayar</th>
                <th>Kembalian</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_penjualan = 0;
            while ($row = mysqli_fetch_assoc($result)): 
                $total_penjualan += $row['total_harga'];
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                <td><?php echo $row['nama_pelanggan']; ?></td>
                <td><?php echo $row['nama_kasir']; ?></td>
                <td style="text-align: right;">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td style="text-align: right;">Rp <?php echo number_format($row['bayar'], 0, ',', '.'); ?></td>
                <td style="text-align: right;">Rp <?php echo number_format($row['kembalian'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL PENJUALAN:</td>
                <td style="text-align: right; font-weight: bold;">Rp <?php echo number_format($total_penjualan, 0, ',', '.'); ?></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
    
    <br>
    <p><strong>Detail Transaksi</strong></p>
    
    <?php
    // Reset pointer result
    mysqli_data_seek($result, 0);
    
    while ($transaksi = mysqli_fetch_assoc($result)):
        // Ambil detail transaksi
        $id_transaksi = $transaksi['id'];
        $query_detail = "SELECT * FROM detail_transaksi WHERE id_transaksi = '$id_transaksi'";
        $result_detail = mysqli_query($conn, $query_detail);
    ?>
    
    <h4>Transaksi #<?php echo $transaksi['id']; ?> - <?php echo date('d/m/Y H:i', strtotime($transaksi['tanggal'])); ?></h4>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($detail = mysqli_fetch_assoc($result_detail)): ?>
            <tr>
                <td><?php echo $detail['nama_barang']; ?></td>
                <td style="text-align: right;">Rp <?php echo number_format($detail['harga'], 0, ',', '.'); ?></td>
                <td style="text-align: center;"><?php echo $detail['jumlah']; ?></td>
                <td style="text-align: right;">Rp <?php echo number_format($detail['subtotal'], 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br>
    
    <?php endwhile; ?>
</body>
</html>
