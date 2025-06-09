<?php
include '../cek_session.php';
include '../koneksi.php';
$id_siswa = $_SESSION['siswa']['id_siswa'];

// Ambil data kelas siswa
$query_siswa = mysqli_query($koneksi, "SELECT id_kelas FROM siswa WHERE id_siswa='$id_siswa'");
$data_siswa = mysqli_fetch_assoc($query_siswa);
$id_kelas = $data_siswa['id_kelas'];

// Ambil jadwal hari ini
$hari_indo = [
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$hari = $hari_indo[date('l')];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi - Siswa</title>
    <link rel="stylesheet" href="../style2.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <i class="fas fa-dashboard"></i> Dashboard Siswa
        <div class="user-info">
            <i class="fas fa-user"></i> <?php echo $_SESSION['siswa']['nama_lengkap']; ?>
            <a href="../logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </header>
    <div class="container">
        <h1><i class="fas fa-clipboard-check"></i> Data Presensi</h1>
        
        <?php if(isset($_GET['status'])): ?>
            <?php 
            $status_class = $_GET['status'] === 'success' ? 'alert-success' : 'alert-error';
            ?>
            <div class="alert <?php echo $status_class; ?>">
                <?php 
                if($_GET['status'] === 'success') {
                    echo '<i class="fas fa-check-circle"></i> ';
                } else {
                    echo '<i class="fas fa-exclamation-circle"></i> ';
                }
                echo $_GET['message']; 
                ?>
            </div>
        <?php endif; ?>
        
        <?php
        $today = date('Y-m-d');
        $check = mysqli_query($koneksi, "SELECT * FROM presensi WHERE id_siswa='$id_siswa' AND DATE(tanggal)='$today'");
        if(mysqli_num_rows($check) == 0 && date('H:i:s') <= '07:30:00') {
            echo '<form action="proses_presensi.php" method="post">';
            echo '<div class="radio-group">';
            echo '<label><input type="radio" name="status" value="Hadir" required checked> Hadir</label>';
            echo '<label><input type="radio" name="status" value="Sakit" required> Sakit</label>';
            echo '<label><input type="radio" name="status" value="Izin" required> Izin</label>';
            echo '</div>';
            echo '<button type="submit" name="presensi" class="presensi-btn">Submit Presensi</button>';
            echo '</form>';
        } elseif(mysqli_num_rows($check) == 0) {
            echo '<form action="proses_presensi.php" method="post">';
            echo '<button type="submit" name="presensi" class="presensi-btn">Submit Presensi</button>';
            echo '</form>';
        }
        ?>

        <table class="data-table">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Status</th>
            </tr>
            <?php
            $query = mysqli_query($koneksi, "SELECT p.*, m.nama_mapel 
                                            FROM presensi p
                                            JOIN mapel m ON p.id_mapel = m.id_mapel 
                                            WHERE p.id_siswa='$id_siswa' 
                                            ORDER BY p.tanggal DESC, p.waktu_absen DESC");
            $no = 1;
            while($data = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td>".$no++."</td>";
                echo "<td>".date('d-m-Y', strtotime($data['tanggal']))."</td>";
                echo "<td>".date('H:i:s', strtotime($data['waktu_absen']))."</td>";
                echo "<td><span class='status-info status-{$data['status']}'>{$data['status']}</span></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <footer>
        <p><i class="far fa-copyright"></i> 2024 Muhammad Zidan Hikayatuloh XI PPLG A</p>
    </footer>
</body>
</html> 