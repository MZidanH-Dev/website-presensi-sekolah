<?php
session_start();
include '../koneksi.php';

if(!isset($_GET['table']) || !isset($_GET['aksi'])) {
    header("location:../index.php");
    exit();
}

$table = $_GET['table'];
$aksi = $_GET['aksi'];

if($aksi == 'hapus') {
    $id = $_GET['id'];
    $id_column = "id_" . $table;
    
    if(mysqli_query($koneksi, "DELETE FROM $table WHERE $id_column='$id'")) {
        $result = mysqli_query($koneksi, "SELECT MAX($id_column) as max_id FROM $table");
        $row = mysqli_fetch_assoc($result);
        $next_id = ($row['max_id']) ? $row['max_id'] + 1 : 1;
        
        mysqli_query($koneksi, "ALTER TABLE $table AUTO_INCREMENT = $next_id");
        
        unset($_SESSION['alert_shown']);
        header("location: ../admin/data_".$table.".php?status=success&action=hapus");
        exit();
    }
}
elseif($aksi == 'edit') {
    header("location:edit.php?table=".$table."&id=".$_GET['id']);
}
elseif($aksi == 'tambah') {
    header("location:tambah.php?table=".$table);
}
?>