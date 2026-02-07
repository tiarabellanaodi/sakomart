<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Kelola Barang';

// Proses tambah barang
if (isset($_POST['tambah'])) {
    $nama = sanitize($_POST['nama_barang']);
    $harga = sanitize($_POST['harga']);
    $stok = sanitize($_POST['stok']);
    
    $query = "INSERT INTO barang (nama_barang, harga, stok) VALUES ('$nama', '$harga', '$stok')";
    if (mysqli_query($conn, $query)) {
        setAlert('success', 'Barang berhasil ditambahkan!');
    } else {
        setAlert('danger', 'Gagal menambahkan barang!');
    }
    header('Location: kelola_barang.php');
    exit();
}

// Proses edit barang
if (isset($_POST['edit'])) {
    $id = sanitize($_POST['id']);
    $nama = sanitize($_POST['nama_barang']);
    $harga = sanitize($_POST['harga']);
    $stok = sanitize($_POST['stok']);
    
    $query = "UPDATE barang SET nama_barang='$nama', harga='$harga', stok='$stok' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        setAlert('success', 'Barang berhasil diupdate!');
    } else {
        setAlert('danger', 'Gagal mengupdate barang!');
    }
    header('Location: kelola_barang.php');
    exit();
}

// Proses hapus barang
if (isset($_GET['hapus'])) {
    $id = sanitize($_GET['hapus']);
    $query = "DELETE FROM barang WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        setAlert('success', 'Barang berhasil dihapus!');
    } else {
        setAlert('danger', 'Gagal menghapus barang!');
    }
    header('Location: kelola_barang.php');
    exit();
}

// Ambil semua barang
$query = "SELECT * FROM barang ORDER BY id DESC";
$result = mysqli_query($conn, $query);

include 'includes/header.php';
?>

<div class="container-custom">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fas fa-boxes"></i> Kelola Barang</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Barang
            </button>
        </div>
        
        <?php showAlert(); ?>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama_barang']; ?></td>
                        <td><?php echo formatRupiah($row['harga']); ?></td>
                        <td><?php echo $row['stok']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editBarang(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <a href="?hapus=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" name="stok" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" id="edit_nama" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" name="harga" id="edit_harga" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" name="stok" id="edit_stok" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="edit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editBarang(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_nama').value = data.nama_barang;
    document.getElementById('edit_harga').value = data.harga;
    document.getElementById('edit_stok').value = data.stok;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?php include 'includes/footer.php'; ?>
