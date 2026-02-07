<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan";
    exit();
}

$id = sanitize($_GET['id']);

// Ambil data transaksi
$query = "SELECT t.*, p.nama as nama_pelanggan, p.alamat, p.no_telp, u.nama_lengkap as nama_kasir 
          FROM transaksi t 
          LEFT JOIN pelanggan p ON t.id_pelanggan = p.id 
          LEFT JOIN users u ON t.id_user = u.id 
          WHERE t.id = '$id'";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_assoc($result);

// Ambil detail barang
$query_detail = "SELECT * FROM detail_transaksi WHERE id_transaksi = '$id'";
$result_detail = mysqli_query($conn, $query_detail);
?>

<div class="row">
    <div class="col-md-6">
        <h6>Informasi Transaksi</h6>
        <table class="table table-sm">
            <tr>
                <td width="150">ID Transaksi</td>
                <td>: <?php echo $transaksi['id']; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?php echo date('d/m/Y H:i:s', strtotime($transaksi['tanggal'])); ?></td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td>: <?php echo $transaksi['nama_kasir']; ?></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <h6>Informasi Pelanggan</h6>
        <table class="table table-sm">
            <tr>
                <td width="150">Nama</td>
                <td>: <?php echo $transaksi['nama_pelanggan']; ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?php echo $transaksi['alamat']; ?></td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>: <?php echo $transaksi['no_telp']; ?></td>
            </tr>
        </table>
    </div>
</div>

<hr>

<h6>Detail Barang</h6>
<table class="table table-sm">
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
            <td><?php echo formatRupiah($detail['harga']); ?></td>
            <td><?php echo $detail['jumlah']; ?></td>
            <td><?php echo formatRupiah($detail['subtotal']); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end">Total:</th>
            <th><?php echo formatRupiah($transaksi['total_harga']); ?></th>
        </tr>
        <tr>
            <th colspan="3" class="text-end">Bayar:</th>
            <th><?php echo formatRupiah($transaksi['bayar']); ?></th>
        </tr>
        <tr>
            <th colspan="3" class="text-end">Kembalian:</th>
            <th><?php echo formatRupiah($transaksi['kembalian']); ?></th>
        </tr>
    </tfoot>
</table>
