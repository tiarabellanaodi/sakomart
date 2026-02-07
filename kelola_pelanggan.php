<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Kelola Pelanggan';

// Proses tambah pelanggan
if (isset($_POST['tambah'])) {
    $nama = sanitize($_POST['nama']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp']);
    
    $query = "INSERT INTO pelanggan (nama, alamat, no_telp) VALUES ('$nama', '$alamat', '$no_telp')";
    if (mysqli_query($conn, $query)) {
        setAlert('success', 'Pelanggan berhasil ditambahkan!');
    } else {
        setAlert('danger', 'Gagal menambahkan pelanggan!');
    }
    header('Location: kelola_pelanggan.php');
    exit();
}

// Proses edit pelanggan
if (isset($_POST['edit'])) {
    $id = sanitize($_POST['id']);
    $nama = sanitize($_POST['nama']);
    $alamat = sanitize($_POST['alamat']);
    $no_telp = sanitize($_POST['no_telp']);
    
    $query = "UPDATE pelanggan SET nama='$nama', alamat='$alamat', no_telp='$no_telp' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        setAlert('success', 'Pelanggan berhasil diupdate!');
    } else {
        setAlert('danger', 'Gagal mengupdate pelanggan!');
    }
    header('Location: kelola_pelanggan.php');
    exit();
}

// Proses hapus pelanggan
if (isset($_GET['hapus'])) {
    $id = sanitize($_GET['hapus']);
    $query = "DELETE FROM pelanggan WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        setAlert('success', 'Pelanggan berhasil dihapus!');
    } else {
        setAlert('danger', 'Gagal menghapus pelanggan!');
    }
    header('Location: kelola_pelanggan.php');
    exit();
}

// Ambil semua pelanggan
$query = "SELECT * FROM pelanggan ORDER BY id DESC";
$result = mysqli_query($conn, $query);

include 'includes/header.php';
?>

<div class="container-custom">
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="fas fa-users"></i> Kelola Pelanggan</h3>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus"></i> Tambah Pelanggan
            </button>
        </div>
        
        <?php showAlert(); ?>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['no_telp']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editPelanggan(<?php echo htmlspecialchars(json_encode($row)); ?>)">
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
                <h5 class="modal-title">Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control" name="no_telp" required>
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
                <h5 class="modal-title">Edit Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" id="edit_nama" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat" id="edit_alamat" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control" name="no_telp" id="edit_no_telp" required>
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
function editPelanggan(data) {
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_nama').value = data.nama;
    document.getElementById('edit_alamat').value = data.alamat;
    document.getElementById('edit_no_telp').value = data.no_telp;
    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

<?php include 'includes/footer.php'; ?>
