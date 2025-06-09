<?php
require('fpdf/fpdf.php');
include '../cek_session.php';
include '../koneksi.php';

$id_guru = $_SESSION['guru']['id_guru'];

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Rekap Presensi', 0, 1, 'C');
        $this->Ln(10);
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

// Ambil parameter filter
$where = ["j.id_guru = '$id_guru'"];

if(isset($_GET['kelas']) && !empty($_GET['kelas'])) {
    $where[] = "k.id_kelas = '".$_GET['kelas']."'";
}

if(isset($_GET['mapel']) && !empty($_GET['mapel'])) {
    $where[] = "m.id_mapel = '".$_GET['mapel']."'";
}

if(isset($_GET['tanggal_mulai']) && !empty($_GET['tanggal_mulai'])) {
    $where[] = "p.tanggal >= '".$_GET['tanggal_mulai']."'";
}

if(isset($_GET['tanggal_akhir']) && !empty($_GET['tanggal_akhir'])) {
    $where[] = "p.tanggal <= '".$_GET['tanggal_akhir']."'";
}

if(isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
    $where[] = "DATE(p.tanggal) = '".$_GET['tanggal']."'";
}

$where_clause = implode(" AND ", $where);

// Query dengan filter
$query = "SELECT p.*, s.nama_lengkap, m.nama_mapel,
          CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) as nama_kelas 
          FROM presensi p
          JOIN siswa s ON p.id_siswa = s.id_siswa
          JOIN mapel m ON p.id_mapel = m.id_mapel
          JOIN kelas k ON s.id_kelas = k.id_kelas
          JOIN jadwal j ON k.id_kelas = j.id_kelas
          WHERE $where_clause
          ORDER BY p.tanggal DESC, s.nama_lengkap ASC";

$result = mysqli_query($koneksi, $query);

// Header tabel
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 7, 'No', 1);
$pdf->Cell(50, 7, 'Nama Siswa', 1);
$pdf->Cell(30, 7, 'Kelas', 1);
$pdf->Cell(30, 7, 'Mapel', 1);
$pdf->Cell(25, 7, 'Tanggal', 1);
$pdf->Cell(20, 7, 'Status', 1);
$pdf->Cell(25, 7, 'Waktu', 1);
$pdf->Ln();

// Isi tabel
$no = 1;
while($row = mysqli_fetch_array($result)) {
    $pdf->Cell(10, 7, $no++, 1);
    $pdf->Cell(50, 7, $row['nama_lengkap'], 1);
    $pdf->Cell(30, 7, $row['nama_kelas'], 1);
    $pdf->Cell(30, 7, $row['nama_mapel'], 1);
    $pdf->Cell(25, 7, date('d-m-Y', strtotime($row['tanggal'])), 1);
    $pdf->Cell(20, 7, $row['status'], 1);
    $pdf->Cell(25, 7, date('H:i', strtotime($row['waktu_absen'])), 1);
    $pdf->Ln();
}

$pdf->Output();
?> 