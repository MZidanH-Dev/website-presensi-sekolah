<?php 
$koneksi = mysqli_connect("localhost","root","","presensi_zidan");
 
if (mysqli_connect_errno()){
    die("Koneksi database gagal : " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8");
?>