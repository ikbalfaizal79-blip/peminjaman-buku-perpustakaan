<?php
require_once 'config/Database.php';
require_once 'models/Buku.php';
require_once 'models/Transaksi.php';

class SiswaController {
    public function dashboard() {
        $db = (new Database())->getConnection();
        $bukuModel = new Buku($db);
        $buku = $bukuModel->getAllBuku();
        
        require_once 'views/siswa/dashboard.php';
    }

   public function pinjamBuku() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_SESSION['user']['id'];
        $buku_id = $_POST['buku_id'];
        $jumlah = (int)$_POST['jumlah'];
        $tgl_pinjam = $_POST['tgl_pinjam'];
        $tgl_kembali = $_POST['tgl_kembali'];

        // Cek stok buku saat ini
        $buku = $this->bukuModel->getById($buku_id);
        if ($buku && $buku['stok'] >= $jumlah) {
            // 1. Potong stok buku
            $stok_baru = $buku['stok'] - $jumlah;
            $this->bukuModel->updateStok($buku_id, $stok_baru);

            // 2. Simpan transaksi pengajuan
            $this->transaksiModel->createPengajuan($user_id, $buku_id, $jumlah, $tgl_pinjam, $tgl_kembali);

            $_SESSION['success_msg'] = "Pengajuan peminjaman berhasil dikirim. Mohon tunggu ACC dari admin!";
        } else {
            $_SESSION['error_msg'] = "Gagal mengajukan, stok buku tidak mencukupi!";
        }

        header('Location: index.php?action=dashboard');
        exit;
    }
}
}