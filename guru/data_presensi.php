<?php
include '../cek_session.php';
include '../koneksi.php';
$id_guru = $_SESSION['guru']['id_guru'];

// Ambil mapel guru
$query_mapel = mysqli_query($koneksi, "SELECT mapel FROM guru WHERE id_guru = '$id_guru'");
$mapel_guru = mysqli_fetch_assoc($query_mapel);

// Ambil id_mapel berdasarkan mapel guru
$query_mapel = "SELECT id_mapel FROM mapel WHERE nama_mapel = '$mapel_guru[mapel]'";
$result_mapel = mysqli_query($koneksi, $query_mapel);
$id_mapel = mysqli_fetch_assoc($result_mapel)['id_mapel'];

// Query untuk menampilkan semua siswa dan status presensi
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Query dasar untuk menampilkan data presensi
$query = "SELECT s.id_siswa, s.nama_lengkap, 
          CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) as nama_kelas,
          m.nama_mapel,
          p.tanggal,
          p.status,
          p.waktu_absen,
          p.id_presensi
          FROM siswa s 
          JOIN kelas k ON s.id_kelas = k.id_kelas
          JOIN jadwal j ON k.id_kelas = j.id_kelas
          JOIN mapel m ON j.id_mapel = m.id_mapel
          JOIN presensi p ON s.id_siswa = p.id_siswa 
          AND p.id_mapel = '$id_mapel'
          WHERE j.id_guru = '$id_guru'";

// Filter berdasarkan kelas
if(isset($_GET['kelas']) && !empty($_GET['kelas'])) {
    $kelas = mysqli_real_escape_string($koneksi, $_GET['kelas']);
    $query .= " AND k.id_kelas = '$kelas'";
}

// Filter berdasarkan status
if(isset($_GET['status']) && !empty($_GET['status'])) {
    $status = mysqli_real_escape_string($koneksi, $_GET['status']);
    $query .= " AND p.status = '$status'";
}

// Filter berdasarkan tanggal
if(isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
    $tgl = mysqli_real_escape_string($koneksi, $_GET['tanggal']);
    $query .= " AND DATE(p.tanggal) = '$tgl'";
}

$query .= " ORDER BY k.tingkatan, k.jurusan, k.kelas, s.nama_lengkap ASC";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi - Guru</title>
    <link rel="stylesheet" href="../style2.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <i class="fas fa-dashboard"></i> Dashboard Guru
        <div class="user-info">
            <i class="fas fa-user"></i> <?php echo $_SESSION['guru']['nama_lengkap']; ?>
            <a href="../logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </header>
    <nav>
        <a href="data_siswa.php"><i class="fas fa-user"></i> Siswa</a>
        <a href="data_presensi.php"><i class="fas fa-clipboard-check"></i> Presensi</a>
    </nav>
    <div class="container">
        <h1><i class="fas fa-clipboard-check"></i> Data Presensi</h1>
        
        <div class="action-container">
            <a href="../fungsi/tambah.php?table=presensi" class="crud-button add-button">
                <i class="fas fa-plus"></i> Tambah Presensi
            </a>
            <a href="export_pdf.php?<?php echo http_build_query($_GET); ?>" class="crud-button export-button">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>

        <div class="filter-container">
            <form action="" method="GET" class="filter-form">
                <div class="filter-group">
                    <label>Kelas:</label>
                    <select name="kelas" class="filter-select">
                        <option value="">Semua Kelas</option>
                        <?php
                        $query_kelas = "SELECT DISTINCT k.id_kelas, CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) as nama_kelas 
                                       FROM kelas k 
                                       JOIN jadwal j ON k.id_kelas = j.id_kelas 
                                       WHERE j.id_guru = '$id_guru'
                                       ORDER BY k.tingkatan, k.jurusan, k.kelas";
                        $kelas = mysqli_query($koneksi, $query_kelas);
                        while($k = mysqli_fetch_array($kelas)) {
                            $selected = (isset($_GET['kelas']) && $_GET['kelas'] == $k['id_kelas']) ? 'selected' : '';
                            echo "<option value='".$k['id_kelas']."' $selected>".$k['nama_kelas']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Status:</label>
                    <select name="status" class="filter-select">
                        <option value="">Semua Status</option>
                        <option value="Hadir" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Hadir') ? 'selected' : ''; ?>>Hadir</option>
                        <option value="Sakit" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Sakit') ? 'selected' : ''; ?>>Sakit</option>
                        <option value="Izin" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Izin') ? 'selected' : ''; ?>>Izin</option>
                        <option value="Alpha" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Alpha') ? 'selected' : ''; ?>>Alpha</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Tanggal:</label>
                    <input type="date" name="tanggal" value="<?php date('Y-m-d'); ?>" class="filter-date">
                </div>
                <button type="submit" class="filter-button">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="data_presensi.php" class="reset-button">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            </form>
        </div>

        <table class="data-table">
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Waktu Absen</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
            
            $where = ["j.id_guru = '$id_guru'"];

            if(isset($_GET['kelas']) && !empty($_GET['kelas'])) {
                $where[] = "k.id_kelas = '".$_GET['kelas']."'";
            }

            if(isset($_GET['status']) && !empty($_GET['status'])) {
                $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                $where[] = "p.status = '$status'";
            }

            if(isset($_GET['tanggal']) && !empty($_GET['tanggal'])) {
                $where[] = "DATE(p.tanggal) = '".$_GET['tanggal']."'";
            }

            if(isset($_GET['search']) && !empty($_GET['search'])) {
                $where[] = "(s.nama_lengkap LIKE '%$search%'
                            OR CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) LIKE '%$search%'
                            OR DATE_FORMAT(p.tanggal, '%d-%m-%Y') LIKE '%$search%')";
            }

            $where_clause = implode(" AND ", $where);

            $query = "SELECT p.*, s.nama_lengkap, m.nama_mapel, 
                      CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) as nama_kelas 
                      FROM presensi p
                      JOIN siswa s ON p.id_siswa = s.id_siswa
                      JOIN mapel m ON p.id_mapel = m.id_mapel
                      JOIN kelas k ON s.id_kelas = k.id_kelas
                      JOIN jadwal j ON k.id_kelas = j.id_kelas
                      WHERE $where_clause
                      ORDER BY p.tanggal DESC, s.nama_lengkap ASC";
                     
            $data = mysqli_query($koneksi, $query);
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama_lengkap']; ?></td>
                <td><?php echo $d['nama_kelas']; ?></td>
                <td><?php echo $d['nama_mapel']; ?></td>
                <td><?php echo $d['tanggal'] ? date('d-m-Y', strtotime($d['tanggal'])) : '-'; ?></td>
                <td><?php echo $d['status']; ?></td>
                <td><?php echo $d['waktu_absen'] != '-' ? date('H:i:s', strtotime($d['waktu_absen'])) : '-'; ?></td>
                <td>
                    <?php if($d['id_presensi']): ?>
                    <a href="../fungsi/edit.php?table=presensi&id=<?php echo $d['id_presensi']; ?>" class="crud-button edit-button">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <?php else: ?>
                    <a href="../fungsi/tambah.php?table=presensi&siswa=<?php echo $d['id_siswa']; ?>&mapel=<?php echo $id_mapel; ?>" class="crud-button add-button">
                        <i class="fas fa-plus"></i> Absen
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <footer>
        <p><i class="far fa-copyright"></i> 2024 Muhammad Zidan Hikayatuloh XI PPLG A</p>
    </footer>
    <script src="../js/script.js"></script>
</body>
</html> 