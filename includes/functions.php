<?php
// Memulai session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fungsi untuk cek login
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Fungsi untuk redirect jika belum login
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Fungsi untuk logout
function logout() {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Fungsi untuk format rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Fungsi untuk sanitasi input
function sanitize($data) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($data)));
}

// Fungsi untuk alert
function setAlert($type, $message) {
    $_SESSION['alert_type'] = $type;
    $_SESSION['alert_message'] = $message;
}

function showAlert() {
    if (isset($_SESSION['alert_message'])) {
        $type = $_SESSION['alert_type'];
        $message = $_SESSION['alert_message'];
        echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
                $message
                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
              </div>";
        unset($_SESSION['alert_type']);
        unset($_SESSION['alert_message']);
    }
}
?>
