<?php
include '../cek_session.php';
include '../koneksi.php';

if(!isset($_GET['table']) || !isset($_GET['id'])) {
    header("location:../index.php");
    exit();
}

// Pindahkan deklarasi $table ke atas sebelum digunakan
$table = $_GET['table'];
$id = $_GET['id'];

// Fungsi helper untuk menentukan redirect path
function getRedirectPath($table) {
    // Cek path asal request
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    
    if(strpos($referer, '/admin/') !== false) {
        return "../admin/data_" . $table . ".php";
    } elseif(strpos($referer, '/guru/') !== false) {
        return "../guru/data_presensi.php";
    }
    
    // Fallback berdasarkan session jika referer tidak tersedia
    if(isset($_SESSION['admin'])) {
        return "../admin/data_" . $table . ".php";
    } elseif(isset($_SESSION['guru'])) {
        return "../guru/data_presensi.php";
    }
    
    return "../index.php";
}

// Untuk GET request (tombol kembali)
$redirect_path = getRedirectPath($table);

if(isset($_POST['submit'])) {
    $table = mysqli_real_escape_string($koneksi, $_POST['table']);
    $redirect_path = getRedirectPath($table);
    
    if($table == 'admin') {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        
        if(!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            mysqli_query($koneksi, "UPDATE admin SET 
                nama_lengkap='$nama', 
                username='$username', 
                password='$password' 
                WHERE id_admin='$id'");
        } else {
            mysqli_query($koneksi, "UPDATE admin SET 
                nama_lengkap='$nama', 
                username='$username' 
                WHERE id_admin='$id'");
        }
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: " . $redirect_path . "?status=success&action=edit");
            exit();
        } else {
            header("location: " . $redirect_path . "?status=error&message=Tidak ada perubahan data");
            exit();
        }
    }
    
    elseif($table == 'guru') {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
        $mapel = mysqli_real_escape_string($koneksi, $_POST['mapel']);
        
        if(!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            mysqli_query($koneksi, "UPDATE guru SET 
                nama_lengkap='$nama', 
                username='$username', 
                nip='$nip',
                password='$password',
                mapel='$mapel' 
                WHERE id_guru='$id'");
        } else {
            mysqli_query($koneksi, "UPDATE guru SET 
                nama_lengkap='$nama', 
                username='$username', 
                nip='$nip',
                mapel='$mapel' 
                WHERE id_guru='$id'");
        }
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: " . $redirect_path . "?status=success&action=edit");
            exit();
        } else {
            header("location: " . $redirect_path . "?status=error&message=Tidak ada perubahan data");
            exit();
        }
    }
    
    elseif($table == 'siswa') {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
        $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
        $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
        $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
        $username = mysqli_real_escape_string($koneksi, $_POST['username']);
        
        if(!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            mysqli_query($koneksi, "UPDATE siswa SET 
                nama_lengkap='$nama', 
                id_kelas='$id_kelas', 
                NISN='$nisn',
                jenis_kelamin='$jenis_kelamin',
                username='$username',
                password='$password' 
                WHERE id_siswa='$id'");
        } else {
            mysqli_query($koneksi, "UPDATE siswa SET 
                nama_lengkap='$nama', 
                id_kelas='$id_kelas', 
                NISN='$nisn',
                jenis_kelamin='$jenis_kelamin',
                username='$username' 
                WHERE id_siswa='$id'");
        }
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: " . $redirect_path . "?status=success&action=edit");
            exit();
        } else {
            header("location: " . $redirect_path . "?status=error&message=Tidak ada perubahan data");
            exit();
        }
    }
    
    elseif($table == 'mapel') {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
        
        mysqli_query($koneksi, "UPDATE mapel SET 
            nama_mapel='$nama_mapel' 
            WHERE id_mapel='$id'");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: " . $redirect_path . "?status=success&action=edit");
            exit();
        } else {
            header("location: " . $redirect_path . "?status=error&message=Tidak ada perubahan data");
            exit();
        }
    }
    
    elseif($table == 'kelas') {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $tingkatan = mysqli_real_escape_string($koneksi, $_POST['tingkatan']);
        $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
        $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
        
        mysqli_query($koneksi, "UPDATE kelas SET 
            tingkatan='$tingkatan',
            jurusan='$jurusan',
            kelas='$kelas' 
            WHERE id_kelas='$id'");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: " . $redirect_path . "?status=success&action=edit");
            exit();
        } else {
            header("location: " . $redirect_path . "?status=error&message=Tidak ada perubahan data");
            exit();
        }
    }
    
    elseif($table == 'jadwal') {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
        $id_mapel = mysqli_real_escape_string($koneksi, $_POST['id_mapel']);
        $id_guru = mysqli_real_escape_string($koneksi, $_POST['id_guru']);
        $hari = mysqli_real_escape_string($koneksi, $_POST['hari']);
        $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
        $jam_selesai = mysqli_real_escape_string($koneksi, $_POST['jam_selesai']);
        
        mysqli_query($koneksi, "UPDATE jadwal SET 
            id_kelas='$id_kelas',
            id_mapel='$id_mapel',
            id_guru='$id_guru',
            hari='$hari',
            jam_mulai='$jam_mulai',
            jam_selesai='$jam_selesai' 
            WHERE id_jadwal='$id'");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: " . $redirect_path . "?status=success&action=edit");
            exit();
        } else {
            header("location: " . $redirect_path . "?status=error&message=Tidak ada perubahan data");
            exit();
        }
    }
    
    elseif($table == 'presensi') {
        $id = mysqli_real_escape_string($koneksi, $_POST['id']);
        $id_siswa = mysqli_real_escape_string($koneksi, $_POST['id_siswa']);
        $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
        $status = mysqli_real_escape_string($koneksi, $_POST['status']);
        
        // Validasi input sebelum update
        if(!preg_match("/^\d{4}-\d{2}-\d{2}$/", $tanggal)) {
            header("location: " . $redirect_path . "?status=error&message=Format tanggal tidak valid");
            exit();
        }
        // Validasi status
        if(!in_array($status, ['Hadir','Sakit','Izin','Alfa'])) {
            header("location: " . $redirect_path . "?status=error&message=Status tidak valid");
            exit();
        }
        
        mysqli_query($koneksi, "UPDATE presensi SET 
            id_siswa='$id_siswa',
            tanggal='$tanggal',
            status='$status' 
            WHERE id_presensi='$id'");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: " . $redirect_path . "?status=success&action=edit");
            exit();
        } else {
            header("location: " . $redirect_path . "?status=error&message=Tidak ada perubahan data");
            exit();
        }
    }
}

// Ambil data yang akan diedit
if($table == 'admin') {
    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id'");
    $data = mysqli_fetch_array($query);
}
elseif($table == 'guru') {
    $query = mysqli_query($koneksi, "SELECT * FROM guru WHERE id_guru='$id'");
    $data = mysqli_fetch_array($query);
}
elseif($table == 'siswa') {
    $query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa='$id'");
    $data = mysqli_fetch_array($query);
}
elseif($table == 'mapel') {
    $query = mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_mapel='$id'");
    $data = mysqli_fetch_array($query);
}
elseif($table == 'kelas') {
    $query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$id'");
    $data = mysqli_fetch_array($query);
}
elseif($table == 'jadwal') {
    $query = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE id_jadwal='$id'");
    $data = mysqli_fetch_array($query);
}
elseif($table == 'presensi') {
    $query = mysqli_query($koneksi, "SELECT * FROM presensi WHERE id_presensi='$id'");
    $data = mysqli_fetch_array($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data <?php echo ucfirst($table); ?></title>
    <link rel="stylesheet" href="../form.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Edit Data <?php echo ucfirst($table); ?></h2>
        <form method="POST" action="">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            
            <?php if($table == 'admin'): ?>
                <div>
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" required>
                </div>
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" value="<?php echo $data['username']; ?>" required>
                </div>
                <div>
                    <label>Password: (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password">
                </div>
            
            <?php elseif($table == 'guru'): ?>
                <div>
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" required>
                </div>
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" value="<?php echo $data['username']; ?>" required>
                </div>
                <div>
                    <label>NIP:</label>
                    <input type="text" name="nip" value="<?php echo $data['nip']; ?>" required>
                </div>
                <div>
                    <label>Password: (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password">
                </div>
                <div>
                    <label>Mapel:</label>
                    <select name="mapel" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM mapel");
                        while($m = mysqli_fetch_array($query)){
                            $selected = ($m['nama_mapel'] == $data['mapel']) ? 'selected' : '';
                            echo "<option value='".$m['nama_mapel']."' ".$selected.">".$m['nama_mapel']."</option>";
                        }
                        ?>
                    </select>
                </div>
            
            <?php elseif($table == 'siswa'): ?>
                <div>
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" value="<?php echo $data['nama_lengkap']; ?>" required>
                </div>
                <div>
                    <label>Kelas:</label>
                    <select name="id_kelas" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while($k = mysqli_fetch_array($query)){
                            $selected = ($k['id_kelas'] == $data['id_kelas']) ? 'selected' : '';
                            echo "<option value='".$k['id_kelas']."' ".$selected.">".$k['tingkatan']." ".$k['jurusan']." ".$k['kelas']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>NISN:</label>
                    <input type="text" name="nisn" value="<?php echo $data['NISN']; ?>" required>
                </div>
                <div>
                    <label>Jenis Kelamin:</label>
                    <select name="jenis_kelamin" required>
                        <option value="L" <?php echo ($data['jenis_kelamin'] == 'L') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?php echo ($data['jenis_kelamin'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" value="<?php echo $data['username']; ?>" required>
                </div>
                <div>
                    <label>Password: (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" name="password">
                </div>
            
            <?php elseif($table == 'mapel'): ?>
                <div>
                    <label>Nama Mapel:</label>
                    <input type="text" name="nama_mapel" value="<?php echo $data['nama_mapel']; ?>" required>
                </div>
            
            <?php elseif($table == 'kelas'): ?>
                <div>
                    <label>Tingkatan:</label>
                    <select name="tingkatan" required>
                        <option value="X" <?php echo ($data['tingkatan'] == 'X') ? 'selected' : ''; ?>>X</option>
                        <option value="XI" <?php echo ($data['tingkatan'] == 'XI') ? 'selected' : ''; ?>>XI</option>
                        <option value="XII" <?php echo ($data['tingkatan'] == 'XII') ? 'selected' : ''; ?>>XII</option>
                    </select>
                </div>
                <div>
                    <label>Jurusan:</label>
                    <select name="jurusan" required>
                        <option value="PPLG" <?php echo ($data['jurusan'] == 'PPLG') ? 'selected' : ''; ?>>PPLG</option>
                        <option value="BR" <?php echo ($data['jurusan'] == 'BR') ? 'selected' : ''; ?>>BR</option>
                        <option value="TJKT" <?php echo ($data['jurusan'] == 'TJKT') ? 'selected' : ''; ?>>TJKT</option>
                        <option value="TKI" <?php echo ($data['jurusan'] == 'TKI') ? 'selected' : ''; ?>>TKI</option>
                        <option value="TEI" <?php echo ($data['jurusan'] == 'TEI') ? 'selected' : ''; ?>>TEI</option>
                        <option value="ATPH" <?php echo ($data['jurusan'] == 'ATPH') ? 'selected' : ''; ?>>ATPH</option>
                        <option value="ORACLE" <?php echo ($data['jurusan'] == 'ORACLE') ? 'selected' : ''; ?>>ORACLE</option>
                        <option value="AXIOO" <?php echo ($data['jurusan'] == 'AXIOO') ? 'selected' : ''; ?>>AXIOO</option>
                    </select>
                </div>
                <div>
                    <label>Kelas:</label>
                    <select name="kelas" required>
                        <option value="A" <?php echo ($data['kelas'] == 'A') ? 'selected' : ''; ?>>A</option>
                        <option value="B" <?php echo ($data['kelas'] == 'B') ? 'selected' : ''; ?>>B</option>
                        <option value="C" <?php echo ($data['kelas'] == 'C') ? 'selected' : ''; ?>>C</option>
                    </select>
                </div>
            
            <?php elseif($table == 'jadwal'): ?>
                <div>
                    <label>Kelas:</label>
                    <select name="id_kelas" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while($k = mysqli_fetch_array($query)){
                            $selected = ($k['id_kelas'] == $data['id_kelas']) ? 'selected' : '';
                            echo "<option value='".$k['id_kelas']."' ".$selected.">".$k['tingkatan']." ".$k['jurusan']." ".$k['kelas']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Mapel:</label>
                    <select name="id_mapel" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM mapel");
                        while($m = mysqli_fetch_array($query)){
                            $selected = ($m['id_mapel'] == $data['id_mapel']) ? 'selected' : '';
                            echo "<option value='".$m['id_mapel']."' ".$selected.">".$m['nama_mapel']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Guru:</label>
                    <select name="id_guru" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM guru");
                        while($g = mysqli_fetch_array($query)){
                            $selected = ($g['id_guru'] == $data['id_guru']) ? 'selected' : '';
                            echo "<option value='".$g['id_guru']."' ".$selected.">".$g['nama_lengkap']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Hari:</label>
                    <select name="hari" required>
                        <option value="Senin" <?php echo ($data['hari'] == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                        <option value="Selasa" <?php echo ($data['hari'] == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                        <option value="Rabu" <?php echo ($data['hari'] == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                        <option value="Kamis" <?php echo ($data['hari'] == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                        <option value="Jumat" <?php echo ($data['hari'] == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                        <option value="Sabtu" <?php echo ($data['hari'] == 'Sabtu') ? 'selected' : ''; ?>>Sabtu</option>
                    </select>
                </div>
                <div>
                    <label>Jam Mulai:</label>
                    <input type="time" name="jam_mulai" value="<?php echo $data['jam_mulai']; ?>" required>
                </div>
                <div>
                    <label>Jam Selesai:</label>
                    <input type="time" name="jam_selesai" value="<?php echo $data['jam_selesai']; ?>" required>
                </div>
            
            <?php elseif($table == 'presensi'): ?>
                <div>
                    <label>Siswa:</label>
                    <select name="id_siswa" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM siswa");
                        while($s = mysqli_fetch_array($query)){
                            $selected = ($s['id_siswa'] == $data['id_siswa']) ? 'selected' : '';
                            echo "<option value='".$s['id_siswa']."' ".$selected.">".$s['nama_lengkap']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Tanggal:</label>
                    <input type="date" name="tanggal" value="<?php echo $data['tanggal']; ?>" required>
                </div>
                <div>
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="Hadir" <?php echo ($data['status'] == 'Hadir') ? 'selected' : ''; ?>>Hadir</option>
                        <option value="Sakit" <?php echo ($data['status'] == 'Sakit') ? 'selected' : ''; ?>>Sakit</option>
                        <option value="Izin" <?php echo ($data['status'] == 'Izin') ? 'selected' : ''; ?>>Izin</option>
                        <option value="Alfa" <?php echo ($data['status'] == 'Alfa') ? 'selected' : ''; ?>>Alfa</option>
                    </select>
                </div>
            <?php endif; ?>
            
            <div class="form-buttons">
                <button type="submit" name="submit">Simpan</button>
                <a href="<?php echo $redirect_path; ?>">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>