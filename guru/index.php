<?php
session_start();
if(!isset($_SESSION['guru'])) {
    header("Location: ../login.php");
    exit();
}
header("Location: data_siswa.php");
?>