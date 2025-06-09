<?php
include '../cek_session.php';
include '../koneksi.php';
if(!isset($_GET['table'])) {
    $table = 'presensi';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Presensi - Admin</title>
    <link rel="stylesheet" href="../style2.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <i class="fas fa-dashboard"></i> Dashboard Admin
        <div class="user-info">
        <i class="fas fa-user"></i> <?php echo $_SESSION['admin']['nama_lengkap']; ?>
        <a href="../logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </header>
    <nav>
        <a href="data_siswa.php"><i class="fas fa-user"></i> Siswa</a>
        <a href="data_guru.php"><i class="fas fa-chalkboard-teacher"></i> Guru</a>
        <a href="data_admin.php"><i class="fas fa-user-shield"></i> Admin</a>
        <a href="data_mapel.php"><i class="fas fa-book"></i> Mapel</a>
        <a href="data_kelas.php"><i class="fas fa-school"></i> Kelas</a>
        <a href="data_jadwal.php"><i class="fas fa-calendar-alt"></i> Jadwal</a>
        <a href="data_presensi.php"><i class="fas fa-clipboard-check"></i> Presensi</a>
    </nav>
    <div class="container">
        <h1><i class="fas fa-clipboard-check"></i> Data Presensi</h1>
        
        <div class="action-container">
            <a href="../fungsi/proses.php?table=presensi&aksi=tambah" class="crud-button add-button">
                <i class="fas fa-plus"></i> Tambah Presensi
            </a>
            <div class="search-container">
                <form action="" method="GET" class="search-form">
                    <input type="text" name="search" placeholder="Cari presensi berdasarkan nama siswa, kelas, status atau tanggal..." 
                           value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="search-input">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </form>
            </div>
        </div>
        <table class="data-table">
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Waktu Absen</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
            $query = "SELECT * FROM view_presensi_detail
                      WHERE nama_lengkap LIKE '%$search%'
                      OR nama_kelas LIKE '%$search%'
                      OR tanggal LIKE '%$search%'
                      OR DATE_FORMAT(tanggal, '%d-%m-%Y') LIKE '%$search%'
                      OR status LIKE '%$search%'
                      ORDER BY id_presensi DESC";
            $data = mysqli_query($koneksi, $query);
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama_lengkap']; ?></td>
                <td><?php echo $d['nama_kelas']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($d['tanggal'])); ?></td>
                <td><?php echo $d['status']; ?></td>
                <td><?php echo date('H:i:s', strtotime($d['waktu_absen'])); ?></td>
                <td>
                    <a href="../fungsi/proses.php?table=presensi&aksi=edit&id=<?php echo $d['id_presensi']; ?>" class="crud-button edit-button">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="../fungsi/proses.php?table=presensi&aksi=hapus&id=<?php echo $d['id_presensi']; ?>" class="crud-button delete-button" 
                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
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