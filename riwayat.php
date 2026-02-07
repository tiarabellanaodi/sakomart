<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Riwayat Penjualan';

// Ambil semua transaksi
$query = "SELECT t.*, p.nama as nama_pelanggan, u.nama_lengkap as nama_kasir 
          FROM transaksi t 
          LEFT JOIN pelanggan p ON t.id_pelanggan = p.id 
          LEFT JOIN users u ON t.id_user = u.id 
          ORDER BY t.tanggal DESC";
$result = mysqli_query($conn, $query);

include 'includes/header.php';
?>

<div class="container-custom">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fas fa-history"></i> Riwayat Penjualan</h3>
            <a href="export_excel.php" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export ke Excel
            </a>
        </div>
        
        <?php showAlert(); ?>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal'])); ?></td>
                        <td><?php echo $row['nama_pelanggan']; ?></td>
                        <td><?php echo $row['nama_kasir']; ?></td>
                        <td><?php echo formatRupiah($row['total_harga']); ?></td>
                        <td><?php echo formatRupiah($row['bayar']); ?></td>
                        <td><?php echo formatRupiah($row['kembalian']); ?></td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="lihatDetail(<?php echo $row['id']; ?>)">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detail-content">
                <div class="text-center">
                    <i class="fas fa-spinner fa-spin"></i> Loading...
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function lihatDetail(id) {
    const modal = new bootstrap.Modal(document.getElementById('modalDetail'));
    modal.show();
    
    // Load detail via AJAX
    fetch('get_detail_transaksi.php?id=' + id)
        .then(response => response.text())
        .then(data => {
            document.getElementById('detail-content').innerHTML = data;
        });
}
</script>

<?php include 'includes/footer.php'; ?>
