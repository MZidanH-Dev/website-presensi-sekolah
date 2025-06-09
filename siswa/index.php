<?php
session_start();
if(!isset($_SESSION['siswa'])) {
    header("Location: ../login.php");
    exit();
}
header("Location: data_presensi.php");
?>