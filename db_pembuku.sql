-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Nov 2026 pada 15.44
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
-- Database: `db_pembuku`
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
(1, 'Jurnal Risa', 1, 57, '1793871629_6aec4f0da9c6a.jpeg'),
(2, 'Matematik XII', 2, 50, '1793863254_6aec2e56585d1.webp'),
(3, 'Si Kancil', 3, 45, '1787992637_6a929a3d94012.png'),
(5, 'Bahasa indonesia XII', 2, 489, '1793871370_6aec4e0a997ac.png'),
(6, 'Sejakala', 1, 95, '1793872188_6aec513c0d505.png');

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
(9, 3, 5, 1, '2026-08-31', NULL, NULL, '2026-09-02', 'selesai', 560000),
(10, 5, 5, 10, '2026-10-28', NULL, NULL, '2026-10-29', 'selesai', 0),
(11, 4, 6, 5, '2026-11-05', NULL, NULL, '2026-11-06', 'selesai', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `kelas` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','siswa') NOT NULL DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `nis`, `kelas`, `password`, `role`) VALUES
(2, 'Rahul', 'rahul@gmail.com', '42456224', 'XII RPL 4', '$2y$10$Ap.iZyUgqFEtpMFqey7FkuL2pcG0gZCklRzfXM2479NdWYYLOUV5K', 'siswa'),
(3, 'jainal', 'jainal@gmail.com', '29875985739', 'XII RPL 4', '$2y$10$ytpS5kisCQwme8SWpx90n.PoPeKezGWyPvYAXkwngrdSc.kdyb6Zq', 'siswa'),
(4, 'peminjam', 'peminjam@gmail.com', '29875985739', 'XII RPL 4', '$2y$10$.JUIzVzuK/7oMCUw1cQkqehWMbmnvxj4JpOh5LJVc9P8.Zn34jRFK', 'siswa'),
(5, 'albani', 'albani@gmail.com', '27642698', 'XII RPL 7', '$2y$10$OJe9pjfb2KyjHBweZdoVweHPe6zBy2D5NNp5V8aVmbqjSkqPXIvCW', 'siswa'),
(6, 'admin', 'admin@gmail.com', '', '', '$2y$10$1xP2gFOPpsJggLqzinv68u/jZ0C7bVKpXM48Xu9p2/dJBe6n1lrn6', 'admin');

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
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
