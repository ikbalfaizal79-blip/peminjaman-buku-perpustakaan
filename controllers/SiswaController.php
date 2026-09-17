<?php
require_once 'models/BukuModel.php';
require_once 'models/PinjamModel.php';

class SiswaController {
    private $db;
    private $bukuModel;
    private $pinjamModel;

    public function __construct() {
        // Enforce autentikasi role siswa
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'siswa') {
            header('Location: index.php?page=login');
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->bukuModel = new BukuModel($this->db);
        $this->pinjamModel = new PinjamModel($this->db);
    }

   // Menampilkan Dashboard Siswa (Daftar Buku & Riwayat)
public function dashboard() {
    $search = $_GET['search'] ?? '';
    $id_user = $_SESSION['user']['id_user'];

    // 1. Ambil daftar buku untuk dipinjam
    $bukuList = $this->bukuModel->getAllBuku($search);
    
    // 2. Ambil riwayat peminjaman user ini
    $riwayat = $this->pinjamModel->getPinjamanByUserId($id_user);
    
    require_once 'views/siswa/dashboard.php';
}

    // 2. Menampilkan Form Pengajuan Pinjam Buku
    public function ajukanPinjam() {
        $id_buku = $_GET['id'] ?? null;

        if (!$id_buku) {
            header('Location: index.php?page=siswa&action=dashboard');
            exit;
        }

        // Ambil detail buku berdasarkan ID
        $buku = $this->bukuModel->getBukuById($id_buku);

        if (!$buku) {
            header('Location: index.php?page=siswa&action=dashboard');
            exit;
        }

        require_once 'views/siswa/ajukan_pinjam.php';
    }

    // 3. Memproses Pengajuan Pinjaman Ke Database
    public function prosesPinjam() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_user     = $_SESSION['user']['id_user'];
            $id_buku     = $_POST['id_buku'] ?? null;
            $jumlah      = $_POST['jumlah'] ?? 1;
            $tgl_kembali = $_POST['tgl_kembali'] ?? null;

            if ($id_buku && $tgl_kembali) {
                // Simpan transaksi pinjam ke database dengan status awal 'menunggu'
                $this->pinjamModel->tambahPinjaman($id_user, $id_buku, $jumlah, $tgl_kembali);
                header('Location: index.php?page=siswa&action=riwayat&msg=sukses_pinjam');
                exit;
            }
        }
        
        header('Location: index.php?page=siswa&action=dashboard');
        exit;
    }

    // 4. Menampilkan Riwayat Pinjaman Siswa
    public function riwayat() {
        $id_user = $_SESSION['user']['id_user'];
        $riwayatList = $this->pinjamModel->getPinjamanByUserId($id_user);

        require_once 'views/siswa/riwayat.php';
    }
    // Memproses Pengembalian Buku oleh Siswa
public function kembalikanBuku() {
    $id_pinjam = $_GET['id'] ?? null;
    $id_user   = $_SESSION['user']['id_user'];

    if ($id_pinjam) {
        $this->pinjamModel->kembalikanBuku($id_pinjam, $id_user);
    }

    header('Location: index.php?page=siswa&action=riwayat&msg=dikembalikan');
    exit;
}
}