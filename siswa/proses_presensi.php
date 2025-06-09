<?php
include '../cek_session.php';
include '../koneksi.php';

if(isset($_POST['presensi'])) {
    $id_siswa = $_SESSION['siswa']['id_siswa'];
    $tanggal = date('Y-m-d');
    $waktu_absen = date('H:i:s');
    
    // Tambahkan validasi hari kerja
    $hari = date('l');
    $hari_indo = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];
    $hari = $hari_indo[date('l')];
    
    // Dapatkan id_kelas siswa
    $query_siswa = mysqli_query($koneksi, "SELECT id_kelas FROM siswa WHERE id_siswa='$id_siswa'");
    $data_siswa = mysqli_fetch_assoc($query_siswa);
    $id_kelas = $data_siswa['id_kelas'];
    
    // Cek jadwal pelajaran hari ini
    $query_jadwal = mysqli_query($koneksi, "SELECT * FROM jadwal 
                                           WHERE id_kelas='$id_kelas' 
                                           AND hari='$hari' 
                                           AND '$waktu_absen' BETWEEN 
                                           DATE_SUB(jam_mulai, INTERVAL 30 MINUTE) 
                                           AND DATE_ADD(jam_mulai, INTERVAL 30 MINUTE)");
    
    if(mysqli_num_rows($query_jadwal) == 0) {
        header("Location: data_presensi.php?status=error&message=Tidak ada jadwal pelajaran saat ini");
        exit();
    }
    
    $jadwal = mysqli_fetch_assoc($query_jadwal);
    $id_mapel = $jadwal['id_mapel'];
    
    // Cek apakah sudah presensi untuk mapel ini hari ini
    $check = mysqli_query($koneksi, "SELECT * FROM presensi 
                                    WHERE id_siswa='$id_siswa' 
                                    AND DATE(tanggal)='$tanggal'
                                    AND id_mapel='$id_mapel'");
    
    if(mysqli_num_rows($check) == 0) {
        // Tentukan status berdasarkan waktu
        if($waktu_absen <= date('H:i:s', strtotime($jadwal['jam_mulai']))) {
            if(!isset($_POST['status'])) {
                header("Location: data_presensi.php?status=error&message=Pilih status presensi");
                exit();
            }
            $status = mysqli_real_escape_string($koneksi, $_POST['status']);
            if(!in_array($status, ['Hadir', 'Sakit', 'Izin'])) {
                header("Location: data_presensi.php?status=error&message=Status tidak valid");
                exit();
            }
        } 
        elseif($waktu_absen > date('H:i:s', strtotime('+30 minutes', strtotime($jadwal['jam_mulai'])))) {
            $status = 'Alfa';
        }
        else {
            $status = 'Hadir';
        }
        
        mysqli_query($koneksi, "INSERT INTO presensi (id_siswa, id_mapel, tanggal, status, waktu_absen) 
                               VALUES ('$id_siswa', '$id_mapel', '$tanggal', '$status', NOW())");
        
        if(mysqli_affected_rows($koneksi) > 0) {
            // Reset auto increment jika ada data yang dihapus
            mysqli_query($koneksi, "ALTER TABLE presensi AUTO_INCREMENT = 1");
            
            // Reorder auto increment berdasarkan ID yang ada
            $result = mysqli_query($koneksi, "SELECT id_presensi FROM presensi ORDER BY id_presensi");
            $i = 1;
            while($row = mysqli_fetch_assoc($result)) {
                mysqli_query($koneksi, "UPDATE presensi SET id_presensi = $i 
                                      WHERE id_presensi = {$row['id_presensi']}");
                $i++;
            }
            mysqli_query($koneksi, "ALTER TABLE presensi AUTO_INCREMENT = $i");
            
            header("Location: data_presensi.php?status=success&message=Presensi berhasil");
        } else {
            header("Location: data_presensi.php?status=error&message=Presensi gagal");
        }
    } else {
        header("Location: data_presensi.php?status=error&message=Anda sudah presensi untuk mata pelajaran ini");
    }
    exit();
}
?>

<!-- Form HTML untuk memilih status -->
<form method="POST">
    <?php if(date('H:i:s') <= '07:30:00'): ?>
    <select name="status" required>
        <option value="Hadir">Hadir</option>
        <option value="Sakit">Sakit</option>
        <option value="Izin">Izin</option>
    </select>
    <?php endif; ?>
    <button type="submit" name="presensi">Presensi</button>
</form> 