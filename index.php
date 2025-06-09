<?php
session_start();

// Jika mengakses halaman utama (root), destroy session dan arahkan ke login
session_destroy();
session_start(); // Start fresh session

// Cek session dan arahkan sesuai role
if(isset($_SESSION['admin'])) {
    header("Location: admin/data_siswa.php");
} elseif(isset($_SESSION['guru'])) {
    header("Location: guru/data_siswa.php");
} elseif(isset($_SESSION['siswa'])) {
    header("Location: siswa/data_presensi.php");
} else {
    // Jika tidak ada session, arahkan ke login
    header("Location: login.php");
}
exit();
?>