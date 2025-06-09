<?php
session_start();
$current_time = time();

// Jika session timeout belum diset, set waktu sekarang
if (!isset($_SESSION['timeout'])) {
    $_SESSION['timeout'] = $current_time;
}

// Set batas waktu session (25 menit)
$session_timeout = 25 * 60; // 25 menit dalam detik

// Cek apakah sudah melewati batas waktu
if ($current_time - $_SESSION['timeout'] > $session_timeout) {
    session_destroy();
    header("Location: ../login.php?message=Session expired");
    exit();
}

// Update waktu timeout
$_SESSION['timeout'] = $current_time;

// Cek role dan redirect sesuai role
if (basename(dirname($_SERVER['PHP_SELF'])) === 'admin' && !isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
} elseif (basename(dirname($_SERVER['PHP_SELF'])) === 'guru' && !isset($_SESSION['guru'])) {
    header("Location: ../login.php");
    exit();
} elseif (basename(dirname($_SERVER['PHP_SELF'])) === 'siswa' && !isset($_SESSION['siswa'])) {
    header("Location: ../login.php");
    exit();
}
?> 