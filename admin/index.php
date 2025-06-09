<?php
session_start();
if(!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}
header("Location: data_siswa.php");
?> 