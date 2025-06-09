<?php
include '../cek_session.php';
include '../koneksi.php';
$id_guru = $_SESSION['guru']['id_guru'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - Guru</title>
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
        <h1><i class="fas fa-user"></i> Data Siswa</h1>
        <div class="search-container">
            <form action="" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Cari siswa..." 
                       value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="search-input">
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
        </div>

        <table class="data-table">
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>NISN</th>
                <th>Jenis Kelamin</th>
            </tr>
            <?php
            $no = 1;
            $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
            
            $where = ["j.id_guru = '$id_guru'"];

            if(isset($_GET['kelas']) && !empty($_GET['kelas'])) {
                $where[] = "k.id_kelas = '".$_GET['kelas']."'";
            }

            if(isset($_GET['search']) && !empty($_GET['search'])) {
                $where[] = "(s.nama_lengkap LIKE '%$search%'
                            OR s.NISN LIKE '%$search%'
                            OR CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) LIKE '%$search%')";
            }

            $where_clause = implode(" AND ", $where);

            $query = "SELECT DISTINCT s.*, CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) as nama_kelas 
                      FROM siswa s 
                      JOIN kelas k ON s.id_kelas = k.id_kelas 
                      JOIN jadwal j ON k.id_kelas = j.id_kelas 
                      WHERE j.id_guru = '$id_guru'";

            if(isset($_GET['search']) && !empty($_GET['search'])) {
                $search = mysqli_real_escape_string($koneksi, $_GET['search']);
                $query .= " AND (s.nama_lengkap LIKE '%$search%' 
                            OR s.NISN LIKE '%$search%'
                            OR CONCAT(k.tingkatan, ' ', k.jurusan, ' ', k.kelas) LIKE '%$search%')";
            }

            if(isset($_GET['kelas']) && !empty($_GET['kelas'])) {
                $kelas = mysqli_real_escape_string($koneksi, $_GET['kelas']);
                $query .= " AND k.id_kelas = '$kelas'";
            }

            $query .= " ORDER BY s.nama_lengkap ASC";

            $data = mysqli_query($koneksi, $query);
            while($d = mysqli_fetch_array($data)){
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d['nama_lengkap']; ?></td>
                <td><?php echo $d['nama_kelas']; ?></td>
                <td><?php echo $d['NISN']; ?></td>
                <td><?php echo $d['jenis_kelamin']; ?></td>
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