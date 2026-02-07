// Format angka ke Rupiah
function formatRupiah(angka) {
    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Auto close alert setelah 3 detik
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 3000);
});

// Konfirmasi sebelum hapus
function confirmDelete() {
    return confirm('Apakah Anda yakin ingin menghapus data ini?');
}

// Print struk
function printStruk(id) {
    window.open('print_struk.php?id=' + id, '_blank', 'width=300,height=600');
}
