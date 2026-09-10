<?php
require_once 'config/Database.php';
require_once 'models/User.php';
require_once 'models/Buku.php';
require_once 'models/Kategori.php';
require_once 'models/Transaksi.php';

class AdminController {
    private $db;
    private $userModel;
    private $bukuModel;
    private $kategoriModel;
    private $transaksiModel;

    public function __construct() {
        // Autentikasi Keamanan: Pastikan hanya admin yang bisa mengakses
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header("Location: index.php?action=login");
            exit();
        }

        $database = new Database();
        $this->db = $database->getConnection();
        
        $this->userModel = new User($this->db);
        $this->bukuModel = new Buku($this->db);
        $this->kategoriModel = new Kategori($this->db);
        $this->transaksiModel = new Transaksi($this->db);
    }

    // 1. Halaman Persetujuan Pinjaman (Setujui Pinjam)
    public function setujuiPinjam() {
        $pendingList = $this->transaksiModel->getPending();
        $viewFile = 'views/admin/setujui_pinjam.php';
        require_once 'views/layout.php';
    }

    // Memproses ACC Pinjaman
    public function accPinjam() {
        if (isset($_GET['id'])) {
            $this->transaksiModel->setujuiPinjaman($_GET['id']);
        }
        header("Location: index.php?action=setujui_pinjam");
        exit();
    }

    // Memproses Tolak Pinjaman
    public function tolakPinjam() {
        if (isset($_GET['id'])) {
            $this->transaksiModel->tolakPinjaman($_GET['id']);
        }
        header("Location: index.php?action=setujui_pinjam");
        exit();
    }

    // 2. Halaman Akhiri Pinjaman (Pengembalian Buku)
    public function akhiriPinjaman() {
        $dipinjamList = $this->transaksiModel->getDipinjam();
        $statistik = $this->transaksiModel->getStatistik();
        $viewFile = 'views/admin/akhiri_pinjaman.php';
        require_once 'views/layout.php';
    }

    // Memproses Pengembalian Buku
    public function prosesPengembalian() {
        if (isset($_GET['id'])) {
            $this->transaksiModel->akhiriPinjaman($_GET['id']);
        }
        header("Location: index.php?action=akhiri_pinjaman");
        exit();
    }

    // 3. Halaman Kelola Data Buku
    public function kelolaBuku() {
        $bukuList = $this->bukuModel->getAllBuku();
        $kategoriList = $this->kategoriModel->getAll();
        $viewFile = 'views/admin/kelola_buku.php';
        require_once 'views/layout.php';
    }

    // Tambah Buku Baru
    public function tambahBuku() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_buku = trim($_POST['nama'] ?? '');
            $kategori_id = $_POST['kategori_id'] ?? '';
            $stok = $_POST['stok'] ?? 0;

            if (!empty($nama_buku) && !empty($kategori_id)) {
                $this->bukuModel->create($nama_buku, $kategori_id, $stok);
            }
        }
        header("Location: index.php?action=kelola_buku");
        exit();
    }

    // 4. Halaman Kelola Data User / Anggota
    public function kelolaUser() {
        $userList = $this->userModel->getAllUsers();
        $viewFile = 'views/admin/kelola_user.php';
        require_once 'views/layout.php';
    }

    // Tambah User/Anggota Baru oleh Admin
    public function tambahUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role = $_POST['role'] ?? 'siswa';

            if (!empty($nama) && !empty($email) && !empty($password)) {
                $this->userModel->create($nama, $email, $password, $role);
            }
        }
        header("Location: index.php?action=kelola_user");
        exit();
    }
}