<?php
include '../cek_session.php';
include '../koneksi.php';

if(!isset($_GET['table'])) {
    header("location:../index.php");
    exit();
}

function sanitize($input) {
    global $koneksi;
    return mysqli_real_escape_string($koneksi, trim($input));
}

if(isset($_POST['submit'])) {
    $table = sanitize($_POST['table']);
    
    // Dapatkan nama kolom ID berdasarkan tabel
    $id_column = "id_" . $table;
    
    // Cari ID terkecil yang tersedia
    $query = mysqli_query($koneksi, "SELECT t1.$id_column + 1 AS missing_id 
            FROM $table t1 
            LEFT JOIN $table t2 ON t1.$id_column + 1 = t2.$id_column 
            WHERE t2.$id_column IS NULL 
            ORDER BY t1.$id_column LIMIT 1");
            
    $next_id = mysqli_fetch_assoc($query);
    
    if($next_id) {
        // Set auto increment ke ID yang tersedia
        mysqli_query($koneksi, "ALTER TABLE $table AUTO_INCREMENT = " . $next_id['missing_id']);
    }
    
    if($table == 'admin') {
        $nama = sanitize($_POST['nama_lengkap']);
        $username = sanitize($_POST['username']);
        $password = password_hash(sanitize($_POST['password']), PASSWORD_DEFAULT);
        
        mysqli_query($koneksi, "INSERT INTO admin (nama_lengkap, username, password) 
                               VALUES ('$nama', '$username', '$password')");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: ../admin/data_".$table.".php?status=success&action=tambah");
            exit();
        } else {
            header("location: ../admin/data_".$table.".php?status=error&message=Gagal menambah data");
            exit();
        }
    }
    
    elseif($table == 'guru') {
        $nama = sanitize($_POST['nama_lengkap']);
        $username = sanitize($_POST['username']);
        $password = password_hash(sanitize($_POST['password']), PASSWORD_DEFAULT);
        $nip = sanitize($_POST['nip']);
        $mapel = sanitize($_POST['mapel']);
        
        mysqli_query($koneksi, "INSERT INTO guru (nama_lengkap, username, password, nip, mapel) 
                               VALUES ('$nama', '$username', '$password', '$nip', '$mapel')");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: ../admin/data_".$table.".php?status=success&action=tambah");
            exit();
        } else {
            header("location: ../admin/data_".$table.".php?status=error&message=Gagal menambah data");
            exit();
        }
    }
    
    elseif($table == 'siswa') {
        $nama = sanitize($_POST['nama_lengkap']);
        $id_kelas = sanitize($_POST['id_kelas']);
        $nisn = sanitize($_POST['nisn']);
        $jenis_kelamin = sanitize($_POST['jenis_kelamin']);
        $username = sanitize($_POST['username']);
        $password = password_hash(sanitize($_POST['password']), PASSWORD_DEFAULT);
        
        mysqli_query($koneksi, "INSERT INTO siswa (nama_lengkap, id_kelas, NISN, jenis_kelamin, username, password) 
                               VALUES ('$nama', '$id_kelas', '$nisn', '$jenis_kelamin', '$username', '$password')");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: ../admin/data_".$table.".php?status=success&action=tambah");
            exit();
        } else {
            header("location: ../admin/data_".$table.".php?status=error&message=Gagal menambah data");
            exit();
        }
    }
    
    elseif($table == 'mapel') {
        $nama_mapel = sanitize($_POST['nama_mapel']);
        
        mysqli_query($koneksi, "INSERT INTO mapel (nama_mapel) VALUES ('$nama_mapel')");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: ../admin/data_".$table.".php?status=success&action=tambah");
            exit();
        } else {
            header("location: ../admin/data_".$table.".php?status=error&message=Gagal menambah data");
            exit();
        }
    }
    
    elseif($table == 'kelas') {
        $tingkatan = sanitize($_POST['tingkatan']);
        $jurusan = sanitize($_POST['jurusan']);
        $kelas = sanitize($_POST['kelas']);
        
        mysqli_query($koneksi, "INSERT INTO kelas (tingkatan, jurusan, kelas) 
                               VALUES ('$tingkatan', '$jurusan', '$kelas')");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: ../admin/data_".$table.".php?status=success&action=tambah");
            exit();
        } else {
            header("location: ../admin/data_".$table.".php?status=error&message=Gagal menambah data");
            exit();
        }
    }
    
    elseif($table == 'jadwal') {
        $id_kelas = sanitize($_POST['id_kelas']);
        $id_mapel = sanitize($_POST['id_mapel']);
        $id_guru = sanitize($_POST['id_guru']);
        $hari = sanitize($_POST['hari']);
        $jam_mulai = sanitize($_POST['jam_mulai']);
        $jam_selesai = sanitize($_POST['jam_selesai']);
        
        mysqli_query($koneksi, "INSERT INTO jadwal (id_kelas, id_mapel, id_guru, hari, jam_mulai, jam_selesai) 
                               VALUES ('$id_kelas', '$id_mapel', '$id_guru', '$hari', '$jam_mulai', '$jam_selesai')");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: ../admin/data_".$table.".php?status=success&action=tambah");
            exit();
        } else {
            header("location: ../admin/data_".$table.".php?status=error&message=Gagal menambah data");
            exit();
        }
    }
    
    elseif($table == 'presensi') {
        $id_siswa = sanitize($_POST['id_siswa']);
        $tanggal = sanitize($_POST['tanggal']);
        $status = sanitize($_POST['status']);
        
        mysqli_query($koneksi, "INSERT INTO presensi (id_siswa, tanggal, status) 
                               VALUES ('$id_siswa', '$tanggal', '$status')");
        if(mysqli_affected_rows($koneksi) > 0) {
            unset($_SESSION['alert_shown']);
            header("location: ../admin/data_".$table.".php?status=success&action=tambah");
            exit();
        } else {
            header("location: ../admin/data_".$table.".php?status=error&message=Gagal menambah data");
            exit();
        }
    }
}

// Form tambah data sesuai tabel
$table = $_GET['table'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data <?php echo ucfirst($table); ?></title>
    <link rel="stylesheet" href="../form.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Tambah Data <?php echo ucfirst($table); ?></h2>
        <form method="POST" action="">
            <input type="hidden" name="table" value="<?php echo $table; ?>">
            
            <?php if($table == 'admin'): ?>
                <div>
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" required>
                </div>
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
            
            <?php elseif($table == 'guru'): ?>
                <div>
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" required>
                </div>
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div>
                    <label>NIP:</label>
                    <input type="text" name="nip" required>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
                <div>
                    <label>Mapel:</label>
                    <select name="mapel" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM mapel");
                        while($m = mysqli_fetch_array($query)){
                            echo "<option value='".$m['nama_mapel']."'>".$m['nama_mapel']."</option>";
                        }
                        ?>
                    </select>
                </div>
            
            <?php elseif($table == 'siswa'): ?>
                <div>
                    <label>Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" required>
                </div>
                <div>
                    <label>Kelas:</label>
                    <select name="id_kelas" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while($k = mysqli_fetch_array($query)){
                            echo "<option value='".$k['id_kelas']."'>".$k['tingkatan']." ".$k['jurusan']." ".$k['kelas']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>NISN:</label>
                    <input type="text" name="nisn" required>
                </div>
                <div>
                    <label>Jenis Kelamin:</label>
                    <select name="jenis_kelamin" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label>Username:</label>
                    <input type="text" name="username" required>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" name="password" required>
                </div>
            
            <?php elseif($table == 'mapel'): ?>
                <div>
                    <label>Nama Mapel:</label>
                    <input type="text" name="nama_mapel" required>
                </div>
            
            <?php elseif($table == 'kelas'): ?>
                <div>
                    <label>Tingkatan:</label>
                    <select name="tingkatan" required>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                    </select>
                </div>
                <div>
                    <label>Jurusan:</label>
                    <select name="jurusan" required>
                        <option value="PPLG">PPLG</option>
                        <option value="BR">BR</option>
                        <option value="TJKT">TJKT</option>
                        <option value="TKI">TKI</option>
                        <option value="TEI">TEI</option>
                        <option value="ATPH">ATPH</option>
                        <option value="ORACLE">ORACLE</option>
                        <option value="AXIOO">AXIOO</option>
                    </select>
                </div>
                <div>
                    <label>Kelas:</label>
                    <select name="kelas" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
            
            <?php elseif($table == 'jadwal'): ?>
                <div>
                    <label>Kelas:</label>
                    <select name="id_kelas" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while($k = mysqli_fetch_array($query)){
                            echo "<option value='".$k['id_kelas']."'>".$k['tingkatan']." ".$k['jurusan']." ".$k['kelas']."</option>";
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
                            echo "<option value='".$m['id_mapel']."'>".$m['nama_mapel']."</option>";
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
                            echo "<option value='".$g['id_guru']."'>".$g['nama_lengkap']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Hari:</label>
                    <select name="hari" required>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>
                <div>
                    <label>Jam Mulai:</label>
                    <input type="time" name="jam_mulai" required>
                </div>
                <div>
                    <label>Jam Selesai:</label>
                    <input type="time" name="jam_selesai" required>
                </div>
            
            <?php elseif($table == 'presensi'): ?>
                <div>
                    <label>Siswa:</label>
                    <select name="id_siswa" required>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM siswa");
                        while($s = mysqli_fetch_array($query)){
                            echo "<option value='".$s['id_siswa']."'>".$s['nama_lengkap']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label>Tanggal:</label>
                    <input type="date" name="tanggal" required>
                </div>
                <div>
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="Hadir">Hadir</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Izin">Izin</option>
                        <option value="Alfa">Alfa</option>
                    </select>
                </div>
            
            <?php endif; ?>
            
            <div class="form-buttons">
                <button type="submit" name="submit">Tambah</button>
                <a href="../admin/data_<?php echo $table; ?>.php">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>