-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Sep 2026 pada 03.15
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
-- Database: `db_peminjamanbuku2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `nama_buku` varchar(150) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `nama_buku`, `id_kategori`, `stok`, `gambar`) VALUES
(1, 'Risa Saraswati', 1, 25, '1789605544_6aab36a83e6d0.jpeg'),
(2, 'Matematika XII', 2, 130, '1789605371_6aab35fb5a234.png'),
(3, 'Si Kancil', 3, 25, '1787992637_6a929a3d94012.png'),
(5, 'Bahasa indonesia XII', 2, 493, '1789605109_6aab34f56ca3d.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Novel'),
(2, 'Mapel'),
(3, 'Cerita Fiksi'),
(4, 'Sejarah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `tgl_pinjam` date NOT NULL,
  `tanggal_kembali_rencana` date DEFAULT NULL,
  `tanggal_dikembalikan` date DEFAULT NULL,
  `tgl_kembali` date NOT NULL,
  `status` enum('menunggu','dipinjam','selesai','ditolak') DEFAULT 'menunggu',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_user`, `id_buku`, `jumlah`, `tgl_pinjam`, `tanggal_kembali_rencana`, `tanggal_dikembalikan`, `tgl_kembali`, `status`, `denda`) VALUES
(1, 3, 3, 4, '2026-08-28', NULL, NULL, '2026-08-29', 'selesai', 0),
(2, 3, 2, 1, '2026-08-28', NULL, NULL, '2026-08-29', 'selesai', 0),
(3, 3, 1, 2, '2026-08-28', NULL, NULL, '2026-08-29', 'selesai', 0),
(4, 3, 2, 3, '2026-08-29', NULL, NULL, '2026-08-30', 'ditolak', 0),
(5, 3, 3, 1, '2026-08-29', NULL, NULL, '2026-08-30', 'selesai', 0),
(6, 3, 3, 1, '2026-08-29', NULL, NULL, '2026-08-22', 'ditolak', 0),
(7, 3, 3, 1, '2026-08-29', NULL, NULL, '2026-08-30', 'selesai', 0),
(8, 3, 3, 1, '2026-08-30', NULL, NULL, '2026-08-31', 'selesai', 0),
(9, 3, 5, 1, '2026-08-31', NULL, NULL, '2026-09-02', 'selesai', 0),
(10, 3, 5, 7, '2026-09-04', NULL, NULL, '2026-09-05', 'selesai', 120000),
(11, 3, 1, 7, '2026-09-04', NULL, NULL, '2026-09-05', 'selesai', 0),
(12, 3, 2, 50, '2026-09-04', NULL, NULL, '2026-09-05', 'selesai', 10000),
(13, 9, 3, 18, '2026-09-04', NULL, NULL, '2026-09-05', 'selesai', 0),
(15, 10, 3, 2, '2026-09-14', NULL, NULL, '2026-09-24', 'selesai', 0),
(16, 11, 1, 25, '2026-09-17', NULL, NULL, '2026-09-18', 'dipinjam', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `nis`, `kelas`, `password`, `role`) VALUES
(1, 'Agus', 'admin@perpus.com', '82424567', 'xii rpl 4', '$2y$10$LkjCZstRvRErj9Rb/NEbk.IcDSiUMMkAflJ1BqeTffXfjqM0V6.KS', 'siswa'),
(2, 'Rahul', 'rahul@gmail.com', '865321', 'xii rpl 4', '$2y$10$pec5wLkyoK9tT.g.G024euFnyJoghbcI31KCjauz/szy7TnEtOb4i', 'siswa'),
(3, 'jainal', 'jain@gmail.com', '873434', 'xi br 4', '$2y$10$QaQx0m/KYFmuVEbaVFV1GO5/Zz90DkwdUg/wY4V83lvSJ6J8BOtIG', 'siswa'),
(4, 'ibaladmin', 'ibal@gmail.com', NULL, NULL, '$2y$10$iLuthBzQ/YN0wa7ADTp2Q.hTBw4SbYfkmzq4Gkoyzoup6cjKPruXu', 'admin'),
(5, 'albani', 'albani@gmail.com', '813845724', 'xii ips 3', '$2y$10$rdQjPzsE7R5VfW3NE4lauunyRzOB6CYBYg4UbeZPwryAwFciZXleK', 'siswa'),
(6, 'adminbuku', 'adminbku@gmail.com', NULL, NULL, '$2y$10$XkQnWznl2sCI8ySB1SLT.uVwO3LmVPDVp06Z0O9o9DMN/bn8mcxz2', 'admin'),
(7, 'noordin', 'noordin@gmail.com', '29449414', 'xi rpl 4', '$2y$10$HS9I8VgLqvNGJOhHgdK/EuNt4HwgUcv5GV3UoPxuxcPhe4xndj07i', 'siswa'),
(9, 'samsudin', 'samsudin@gmail.com', '92383838', 'xi br 3', '$2y$10$hWwrkTAp/gaOd4N2MY25quNAqYDOG98XNnPLurFnfkvHaKO2n24DO', 'siswa'),
(10, 'nayla', 'nayla@gmail.com', '832592599', 'XII RPL 4', '$2y$10$wTHnyc0GCE.2/mrKTWHcnOSQGiBSx/fnUylgEa/2GJPdqmNM4NWhu', 'siswa'),
(11, 'aswan123', 'aswan@gmail.com', '12976416', 'XII RPL 7', '$2y$10$S8Xe/7heYW/C0KssnL2ZQuJfDKANMjZ0Oc36/5OWObNdCbdHoyFBG', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
