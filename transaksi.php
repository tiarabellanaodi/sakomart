<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

$page_title = 'Transaksi';

// Proses simpan transaksi
if (isset($_POST['simpan_transaksi'])) {
    $id_pelanggan = sanitize($_POST['id_pelanggan']);
    $total_harga = sanitize($_POST['total_harga']);
    $bayar = sanitize($_POST['bayar']);
    $kembalian = sanitize($_POST['kembalian']);
    $id_user = $_SESSION['user_id'];
    
    // Simpan transaksi
    $query = "INSERT INTO transaksi (id_pelanggan, id_user, total_harga, bayar, kembalian) 
              VALUES ('$id_pelanggan', '$id_user', '$total_harga', '$bayar', '$kembalian')";
    
    if (mysqli_query($conn, $query)) {
        $id_transaksi = mysqli_insert_id($conn);
        
        // Simpan detail transaksi
        $cart = json_decode($_POST['cart_data'], true);
        foreach ($cart as $item) {
            $id_barang = $item['id'];
            $nama_barang = $item['nama'];
            $harga = $item['harga'];
            $jumlah = $item['jumlah'];
            $subtotal = $item['subtotal'];
            
            $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_barang, nama_barang, harga, jumlah, subtotal) 
                           VALUES ('$id_transaksi', '$id_barang', '$nama_barang', '$harga', '$jumlah', '$subtotal')";
            mysqli_query($conn, $query_detail);
            
            // Update stok barang
            $query_update = "UPDATE barang SET stok = stok - $jumlah WHERE id = '$id_barang'";
            mysqli_query($conn, $query_update);
        }
        
        setAlert('success', 'Transaksi berhasil disimpan!');
        echo "<script>localStorage.removeItem('cart');</script>";
    } else {
        setAlert('danger', 'Gagal menyimpan transaksi!');
    }
    
    header('Location: transaksi.php');
    exit();
}

// Ambil data pelanggan
$query_pelanggan = "SELECT * FROM pelanggan ORDER BY nama ASC";
$result_pelanggan = mysqli_query($conn, $query_pelanggan);

// Ambil data barang
$query_barang = "SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang ASC";
$result_barang = mysqli_query($conn, $query_barang);

include 'includes/header.php';
?>

<div class="container-custom">
    <?php showAlert(); ?>
    
    <div class="row">
        <!-- Form Transaksi -->
        <div class="col-md-8">
            <div class="table-container">
                <h3><i class="fas fa-cash-register"></i> Transaksi Penjualan</h3>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Pelanggan</label>
                            <select class="form-control" id="pelanggan">
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php while ($pelanggan = mysqli_fetch_assoc($result_pelanggan)): ?>
                                <option value="<?php echo $pelanggan['id']; ?>" 
                                        data-nama="<?php echo $pelanggan['nama']; ?>"
                                        data-alamat="<?php echo $pelanggan['alamat']; ?>"
                                        data-telp="<?php echo $pelanggan['no_telp']; ?>">
                                    <?php echo $pelanggan['nama']; ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Barang</label>
                            <select class="form-control" id="barang">
                                <option value="">-- Pilih Barang --</option>
                                <?php while ($barang = mysqli_fetch_assoc($result_barang)): ?>
                                <option value="<?php echo $barang['id']; ?>" 
                                        data-nama="<?php echo $barang['nama_barang']; ?>"
                                        data-harga="<?php echo $barang['harga']; ?>"
                                        data-stok="<?php echo $barang['stok']; ?>">
                                    <?php echo $barang['nama_barang']; ?> - <?php echo formatRupiah($barang['harga']); ?> (Stok: <?php echo $barang['stok']; ?>)
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <button class="btn btn-primary mt-2" onclick="tambahBarang()">
                    <i class="fas fa-plus"></i> Tambah Barang
                </button>
                
                <hr>
                
                <h5>Daftar Belanjaan</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="cart-items">
                            <tr>
                                <td colspan="5" class="text-center">Belum ada barang</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Summary -->
        <div class="col-md-4">
            <div class="table-container">
                <h5>Ringkasan</h5>
                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="text" class="form-control" id="total_harga" readonly value="Rp 0">
                </div>
                <div class="form-group">
                    <label>Bayar</label>
                    <input type="number" class="form-control" id="bayar" onkeyup="hitungKembalian()">
                </div>
                <div class="form-group">
                    <label>Kembalian</label>
                    <input type="text" class="form-control" id="kembalian" readonly value="Rp 0">
                </div>
                
                <button class="btn btn-success w-100 mt-3" onclick="simpanTransaksi()">
                    <i class="fas fa-save"></i> Simpan Transaksi
                </button>
                <button class="btn btn-danger w-100 mt-2" onclick="resetTransaksi()">
                    <i class="fas fa-times"></i> Reset
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Form Hidden untuk submit -->
<form id="formTransaksi" method="POST" style="display:none;">
    <input type="hidden" name="id_pelanggan" id="hidden_pelanggan">
    <input type="hidden" name="total_harga" id="hidden_total">
    <input type="hidden" name="bayar" id="hidden_bayar">
    <input type="hidden" name="kembalian" id="hidden_kembalian">
    <input type="hidden" name="cart_data" id="hidden_cart">
    <input type="hidden" name="simpan_transaksi" value="1">
</form>

<script>
let cart = [];

// Load cart dari localStorage
function loadCart() {
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCart();
    }
}

// Simpan cart ke localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// Tambah barang ke cart
function tambahBarang() {
    const selectBarang = document.getElementById('barang');
    const selectedOption = selectBarang.options[selectBarang.selectedIndex];
    
    if (!selectedOption.value) {
        alert('Pilih barang terlebih dahulu!');
        return;
    }
    
    const id = selectedOption.value;
    const nama = selectedOption.dataset.nama;
    const harga = parseFloat(selectedOption.dataset.harga);
    const stok = parseInt(selectedOption.dataset.stok);
    
    // Cek apakah barang sudah ada di cart
    const existingItem = cart.find(item => item.id == id);
    
    if (existingItem) {
        if (existingItem.jumlah < stok) {
            existingItem.jumlah++;
            existingItem.subtotal = existingItem.harga * existingItem.jumlah;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    } else {
        cart.push({
            id: id,
            nama: nama,
            harga: harga,
            jumlah: 1,
            subtotal: harga
        });
    }
    
    saveCart();
    updateCart();
    selectBarang.value = '';
}

// Update tampilan cart
function updateCart() {
    const cartItems = document.getElementById('cart-items');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<tr><td colspan="5" class="text-center">Belum ada barang</td></tr>';
        document.getElementById('total_harga').value = 'Rp 0';
        return;
    }
    
    let html = '';
    let total = 0;
    
    cart.forEach((item, index) => {
        total += item.subtotal;
        html += `
            <tr>
                <td>${item.nama}</td>
                <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                <td>
                    <button class="btn btn-sm btn-secondary" onclick="kurangiJumlah(${index})">-</button>
                    ${item.jumlah}
                    <button class="btn btn-sm btn-secondary" onclick="tambahJumlah(${index})">+</button>
                </td>
                <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="hapusItem(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
    
    cartItems.innerHTML = html;
    document.getElementById('total_harga').value = 'Rp ' + total.toLocaleString('id-ID');
    hitungKembalian();
}

// Tambah jumlah item
function tambahJumlah(index) {
    cart[index].jumlah++;
    cart[index].subtotal = cart[index].harga * cart[index].jumlah;
    saveCart();
    updateCart();
}

// Kurangi jumlah item
function kurangiJumlah(index) {
    if (cart[index].jumlah > 1) {
        cart[index].jumlah--;
        cart[index].subtotal = cart[index].harga * cart[index].jumlah;
        saveCart();
        updateCart();
    }
}

// Hapus item
function hapusItem(index) {
    cart.splice(index, 1);
    saveCart();
    updateCart();
}

// Hitung kembalian
function hitungKembalian() {
    const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
    const bayar = parseFloat(document.getElementById('bayar').value) || 0;
    const kembalian = bayar - total;
    
    document.getElementById('kembalian').value = kembalian >= 0 ? 'Rp ' + kembalian.toLocaleString('id-ID') : 'Rp 0';
}

// Simpan transaksi
function simpanTransaksi() {
    const pelanggan = document.getElementById('pelanggan').value;
    const bayar = parseFloat(document.getElementById('bayar').value) || 0;
    const total = cart.reduce((sum, item) => sum + item.subtotal, 0);
    
    if (!pelanggan) {
        alert('Pilih pelanggan terlebih dahulu!');
        return;
    }
    
    if (cart.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }
    
    if (bayar < total) {
        alert('Uang bayar kurang!');
        return;
    }
    
    const kembalian = bayar - total;
    
    document.getElementById('hidden_pelanggan').value = pelanggan;
    document.getElementById('hidden_total').value = total;
    document.getElementById('hidden_bayar').value = bayar;
    document.getElementById('hidden_kembalian').value = kembalian;
    document.getElementById('hidden_cart').value = JSON.stringify(cart);
    
    if (confirm('Simpan transaksi ini?')) {
        document.getElementById('formTransaksi').submit();
    }
}

// Reset transaksi
function resetTransaksi() {
    if (confirm('Reset transaksi?')) {
        cart = [];
        saveCart();
        updateCart();
        document.getElementById('pelanggan').value = '';
        document.getElementById('bayar').value = '';
        document.getElementById('kembalian').value = 'Rp 0';
    }
}

// Load cart saat halaman dimuat
document.addEventListener('DOMContentLoaded', loadCart);
</script>

<?php include 'includes/footer.php'; ?>
