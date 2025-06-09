-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2024 pada 14.41
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi_zidan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_lengkap`, `username`, `password`) VALUES
(1, 'Admin Sekolah', 'admin1', '$2y$10$PEi.YBDJl52fnwRt4VKUOujUzPp91m32CaSG.zB.8GgM0rGrwomwu'),
(2, 'Admin Akun', 'admin2', '$2y$10$JVhK14GqJA6AMtBw8mfWi.79AZDAqSfITnZ9eJttBe318sKGKfhZa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id_guru` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mapel` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_lengkap`, `username`, `nip`, `password`, `mapel`) VALUES
(1, 'Kamaludin Rahman', 'kamal', 'NIP001', '$2y$10$JiBI8kwwD2U.vQ4.DuNqS.gKZirQpTq89itzW/um3I.kAfZa09owG', 'Matematika'),
(2, 'Lina Sari', 'lina', 'NIP002', '$2y$10$d/1fLjLk5F2rdrcd4hVvZe6soNpLChtjV5tuL/vRNsaZn/m3npn8.', 'Fisika'),
(3, 'Maya Sari', 'maya', 'NIP003', '$2y$10$8QZSnfM.9HPn1WFPZsHEYuBNY62KkOwlmSWF.Xt85nbydo74yFCBm', 'Kimia'),
(4, 'Nina Wulandari', 'nina', 'NIP004', '$2y$10$p.Cv4vQ40W0cptGJ9O1BteD8hFJUA.BhGFBT/Cz2Z1ihT5It2oloO', 'Biologi'),
(5, 'Omar Hidayat', 'omar', 'NIP005', '$2y$10$mOEKPOPdYgaC8zYeA3N5Re2XRQTkcTHesjdYZPKL.37cByJu1yN.6', 'Bahasa Inggris'),
(6, 'Putu Sari', 'putu', 'NIP006', '$2y$10$XNqSzKdNw5hPDdp0tYBeJ.HiS.p2A6ThR2o0AXqbQicROFN3rs1C6', 'Bahasa Indonesia'),
(7, 'Qori Aulia', 'qori', 'NIP007', '$2y$10$eDicrBwpaEyc8FNKGfa5neJK2lBgoIU2yCOQLym7UqDeaBixzkvci', 'Pendidikan Pancasila'),
(8, 'Rudi Hartono', 'rudi', 'NIP008', '$2y$10$6XB0l1iRybBEbbZekxYLCOgW6Wf7mKS0vwa.02bsHE7YbhO7uKPLa', 'Sejarah'),
(9, 'Siti Aminah', 'siti', 'NIP009', '$2y$10$d4nfLtOHAb/nlX2MCQ8./e/Cm4BBpPnbZ64MmjpJ8XDIPXPv1DQHe', 'Ekonomi'),
(10, 'Tina Melati', 'tina', 'NIP010', '$2y$10$UQOhZ54HnO13gRIWQkcq9ucsw6DoIewN8VBttE0EDIP7J.lA0MqMe', 'Seni Budaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_kelas`, `id_mapel`, `id_guru`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 1, 1, 1, 'Senin', '08:00:00', '09:30:00'),
(2, 1, 2, 2, 'Selasa', '08:00:00', '09:30:00'),
(3, 2, 3, 3, 'Rabu', '08:00:00', '09:30:00'),
(4, 2, 4, 4, 'Kamis', '08:00:00', '09:30:00'),
(5, 3, 5, 5, 'Jumat', '08:00:00', '09:30:00'),
(6, 3, 6, 6, 'Sabtu', '08:00:00', '09:30:00'),
(7, 4, 7, 7, 'Senin', '10:00:00', '11:30:00'),
(8, 4, 8, 8, 'Selasa', '10:00:00', '11:30:00'),
(9, 5, 9, 9, 'Rabu', '10:00:00', '11:30:00'),
(10, 5, 10, 10, 'Kamis', '10:00:00', '11:30:00'),
(11, 6, 1, 1, 'Jumat', '10:00:00', '11:30:00'),
(12, 6, 2, 2, 'Sabtu', '10:00:00', '11:30:00'),
(13, 7, 3, 3, 'Senin', '08:00:00', '09:30:00'),
(14, 7, 4, 4, 'Selasa', '08:00:00', '09:30:00'),
(15, 8, 5, 5, 'Rabu', '08:00:00', '09:30:00'),
(16, 8, 6, 6, 'Kamis', '08:00:00', '09:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `tingkatan` enum('X','XI','XII') NOT NULL,
  `jurusan` enum('PPLG','BR','TJKT','TKI','TEI','ATPH','ORACLE','AXIOO') NOT NULL,
  `kelas` enum('A','B','C') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `tingkatan`, `jurusan`, `kelas`) VALUES
(1, 'X', 'PPLG', 'A'),
(2, 'X', 'PPLG', 'B'),
(3, 'X', 'PPLG', 'C'),
(4, 'X', 'BR', 'A'),
(5, 'X', 'BR', 'B'),
(6, 'X', 'BR', 'C'),
(7, 'X', 'TJKT', 'A'),
(8, 'X', 'TJKT', 'B'),
(9, 'X', 'TJKT', 'C'),
(10, 'XI', 'TKI', 'A'),
(11, 'XI', 'TKI', 'B'),
(12, 'XI', 'TKI', 'C'),
(13, 'XI', 'TEI', 'A'),
(14, 'XI', 'TEI', 'B'),
(15, 'XI', 'TEI', 'C'),
(16, 'XI', 'ATPH', 'A'),
(17, 'XI', 'ATPH', 'B'),
(18, 'XI', 'ATPH', 'C'),
(19, 'XII', 'ORACLE', 'A'),
(20, 'XII', 'ORACLE', 'B'),
(21, 'XII', 'ORACLE', 'C'),
(22, 'XII', 'AXIOO', 'A'),
(23, 'XII', 'AXIOO', 'B'),
(24, 'XII', 'AXIOO', 'C');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int(11) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `nama_mapel`) VALUES
(1, 'Matematika'),
(2, 'Fisika'),
(3, 'Kimia'),
(4, 'Biologi'),
(5, 'Bahasa Inggris'),
(6, 'Bahasa Indonesia'),
(7, 'Pendidikan Pancasila'),
(8, 'Sejarah'),
(9, 'Ekonomi'),
(10, 'Seni Budaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensi`
--

CREATE TABLE `presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('Hadir','Sakit','Izin','Alfa') NOT NULL,
  `waktu_absen` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `presensi`
--

INSERT INTO `presensi` (`id_presensi`, `id_siswa`, `id_mapel`, `tanggal`, `status`, `waktu_absen`) VALUES
(1, 1, 1, '2024-01-03', 'Sakit', '2024-11-25 11:46:40'),
(2, 1, 1, '2024-01-04', 'Izin', '2024-11-25 11:46:40'),
(3, 1, 1, '2024-01-05', 'Alfa', '2024-11-25 11:46:40'),
(4, 2, 1, '2024-01-02', 'Hadir', '2024-11-25 11:46:40'),
(5, 2, 1, '2024-01-03', 'Hadir', '2024-11-25 11:46:40'),
(6, 2, 1, '2024-01-04', 'Sakit', '2024-11-25 11:46:40'),
(7, 2, 1, '2024-01-05', 'Izin', '2024-11-25 11:46:40'),
(8, 3, 1, '2024-01-02', 'Hadir', '2024-11-25 11:46:40'),
(9, 3, 1, '2024-01-04', 'Alfa', '2024-11-25 11:46:40'),
(10, 3, 1, '2024-01-05', 'Hadir', '2024-11-25 11:46:40'),
(11, 4, 1, '2024-01-02', 'Izin', '2024-11-25 11:46:40'),
(12, 4, 1, '2024-01-03', 'Hadir', '2024-11-25 11:46:40'),
(13, 4, 1, '2024-01-04', 'Hadir', '2024-11-25 11:46:40'),
(14, 4, 1, '2024-01-05', 'Sakit', '2024-11-25 11:46:40'),
(15, 5, 1, '2024-01-02', 'Hadir', '2024-11-25 11:46:40'),
(16, 5, 1, '2024-01-03', 'Alfa', '2024-11-25 11:46:40'),
(17, 5, 1, '2024-01-04', 'Hadir', '2024-11-25 11:46:40'),
(18, 5, 1, '2024-01-05', 'Izin', '2024-11-25 11:46:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `NISN` varchar(20) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama_lengkap`, `id_kelas`, `NISN`, `jenis_kelamin`, `username`, `password`) VALUES
(1, 'Andi Prasetyo', 1, '1234567890', 'L', 'andi', '$2y$10$NSMULPQuRRGNgYk.jRjMsOIMbMCh.f5Y9BaKCY0MeWtAogVsIJ/WG'),
(2, 'Budi Santoso', 2, '1234567891', 'L', 'budi', '$2y$10$QFsNSWSk/ajYqy3K.vh5..kOtiaFeJFq7/HJnMH99xADVhCvpCB.6'),
(3, 'Citra Dewi', 3, '1234567892', 'P', 'citra', '$2y$10$3FNyHDPyaYlewxc9wF5R3eius7H9zRqiTZNaihbn.1p1Sdh3s77iq'),
(4, 'Dewi Lestari', 4, '1234567893', 'P', 'dewi', '$2y$10$Ns8b25GtURdNdtBAyf6Mheg4NRLuvRRvA8bzFA91xG9LBe7tyLk8e'),
(5, 'Eko Supriyanto', 5, '1234567894', 'L', 'eko', '$2y$10$NRTNLM.1ol.f/1EXdjmSOOr5iVHmEbdFdxsypQIWL044GUmgm2K16'),
(6, 'Fani Rahmawati', 6, '1234567895', 'P', 'fani', '$2y$10$FXKxkqEu1KMnpsqLb64kyuVEc7T6bbJVbb/Fm/HRb7zLwgkxPD3zW'),
(7, 'Gilang Prabowo', 7, '1234567896', 'L', 'gilang', '$2y$10$sqAixDrPTI1oomKji5AscONprf2jqyBQEAozF4pKb5YQnrWif3WoS'),
(8, 'Hani Yulianti', 8, '1234567897', 'P', 'hani', '$2y$10$dtWH93Jk8KHzXktB7tV1HOHt6v9xyHoV6gadtgvnOmK9QRFz8RKjS'),
(9, 'Iwan Setiawan', 9, '1234567898', 'L', 'iwan', '$2y$10$1btn8vbuKW0V2jhTyVHH7OlcbHu2o3QsIdjh6UaGbUi/UvGsTix.O'),
(10, 'Jasmine Putri', 10, '1234567899', 'P', 'jasmine', '$2y$10$sVq8Btf4OJPloLlNgGI9Ru6kXVmU/NGZe7uqFp8pJ5XN7rD2e8Ilm');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_jadwal_lengkap`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_jadwal_lengkap` (
`id_jadwal` int(11)
,`id_kelas` int(11)
,`id_mapel` int(11)
,`id_guru` int(11)
,`hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')
,`jam_mulai` time
,`jam_selesai` time
,`nama_kelas` varchar(12)
,`nama_mapel` varchar(100)
,`nama_guru` varchar(100)
,`jam_mulai_format` varchar(10)
,`jam_selesai_format` varchar(10)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_presensi_detail`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_presensi_detail` (
`id_presensi` int(11)
,`id_siswa` int(11)
,`tanggal` date
,`status` enum('Hadir','Sakit','Izin','Alfa')
,`waktu_absen` timestamp
,`nama_lengkap` varchar(100)
,`nama_kelas` varchar(12)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `view_siswa_kelas`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `view_siswa_kelas` (
`id_siswa` int(11)
,`nama_lengkap` varchar(100)
,`id_kelas` int(11)
,`NISN` varchar(20)
,`jenis_kelamin` enum('L','P')
,`username` varchar(50)
,`password` varchar(255)
,`nama_kelas` varchar(12)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `view_jadwal_lengkap`
--
DROP TABLE IF EXISTS `view_jadwal_lengkap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_jadwal_lengkap`  AS SELECT `j`.`id_jadwal` AS `id_jadwal`, `j`.`id_kelas` AS `id_kelas`, `j`.`id_mapel` AS `id_mapel`, `j`.`id_guru` AS `id_guru`, `j`.`hari` AS `hari`, `j`.`jam_mulai` AS `jam_mulai`, `j`.`jam_selesai` AS `jam_selesai`, concat(`k`.`tingkatan`,' ',`k`.`jurusan`,' ',`k`.`kelas`) AS `nama_kelas`, `m`.`nama_mapel` AS `nama_mapel`, `g`.`nama_lengkap` AS `nama_guru`, time_format(`j`.`jam_mulai`,'%H:%i') AS `jam_mulai_format`, time_format(`j`.`jam_selesai`,'%H:%i') AS `jam_selesai_format` FROM (((`jadwal` `j` join `kelas` `k` on(`j`.`id_kelas` = `k`.`id_kelas`)) join `mapel` `m` on(`j`.`id_mapel` = `m`.`id_mapel`)) join `guru` `g` on(`j`.`id_guru` = `g`.`id_guru`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_presensi_detail`
--
DROP TABLE IF EXISTS `view_presensi_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_presensi_detail`  AS SELECT `p`.`id_presensi` AS `id_presensi`, `p`.`id_siswa` AS `id_siswa`, `p`.`tanggal` AS `tanggal`, `p`.`status` AS `status`, `p`.`waktu_absen` AS `waktu_absen`, `s`.`nama_lengkap` AS `nama_lengkap`, concat(`k`.`tingkatan`,' ',`k`.`jurusan`,' ',`k`.`kelas`) AS `nama_kelas` FROM ((`presensi` `p` join `siswa` `s` on(`p`.`id_siswa` = `s`.`id_siswa`)) join `kelas` `k` on(`s`.`id_kelas` = `k`.`id_kelas`)) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `view_siswa_kelas`
--
DROP TABLE IF EXISTS `view_siswa_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_siswa_kelas`  AS SELECT `s`.`id_siswa` AS `id_siswa`, `s`.`nama_lengkap` AS `nama_lengkap`, `s`.`id_kelas` AS `id_kelas`, `s`.`NISN` AS `NISN`, `s`.`jenis_kelamin` AS `jenis_kelamin`, `s`.`username` AS `username`, `s`.`password` AS `password`, concat(`k`.`tingkatan`,' ',`k`.`jurusan`,' ',`k`.`kelas`) AS `nama_kelas` FROM (`siswa` `s` join `kelas` `k` on(`s`.`id_kelas` = `k`.`id_kelas`)) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indeks untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `fk_presensi_mapel` (`id_mapel`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD UNIQUE KEY `NISN` (`NISN`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `presensi`
--
ALTER TABLE `presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_ibfk_3` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensi`
--
ALTER TABLE `presensi`
  ADD CONSTRAINT `fk_presensi_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `presensi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
