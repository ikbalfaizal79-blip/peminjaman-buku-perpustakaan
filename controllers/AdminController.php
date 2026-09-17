<?php
require_once 'models/BukuModel.php';
require_once 'models/PinjamModel.php';
require_once 'models/UserModel.php';
require_once 'models/KategoriModel.php';

class AdminController {
    private $db;
    private $bukuModel;
    private $pinjamModel;
    private $userModel;
    private $kategoriModel;

    public function __construct() {
        // Proteksi Halaman: Pastikan hanya admin yang bisa mengakses
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }

        $database = new Database();
        $this->db = $database->getConnection();
        $this->bukuModel = new BukuModel($this->db);
        $this->pinjamModel = new PinjamModel($this->db);
        $this->kategoriModel = new KategoriModel($this->db);
        $this->userModel = new UserModel($this->db);
        
    }
    private function checkAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
    }

    // 1. Dashboard Admin: Setujui Pinjaman (Status Menunggu)
   // Dashboard Admin: Menampilkan daftar pengajuan pinjaman yang menunggu persetujuan
public function dashboard() {
    $search = $_GET['search'] ?? '';
    // Diubah nama variabelnya menjadi $pendingList
    $pendingList = $this->pinjamModel->getPendingPinjaman($search);

    require_once 'views/admin/dashboard.php';
}

    // 2. Setujui Pengajuan Pinjaman
    public function setujuiPinjaman() {
        $id_pinjam = $_GET['id'] ?? null;
        if ($id_pinjam) {
            $this->pinjamModel->setujuiPinjaman($id_pinjam);
        }
        header('Location: index.php?page=admin&action=dashboard');
        exit;
    }

    // 3. Tolak Pengajuan Pinjaman
    public function tolakPinjaman() {
        $id_pinjam = $_GET['id'] ?? null;
        if ($id_pinjam) {
            $this->pinjamModel->tolakPinjaman($id_pinjam);
        }
        header('Location: index.php?page=admin&action=dashboard');
        exit;
    }

    // 4. Halaman Akhiri Pinjaman (Status Dipinjam / Aktif)
    public function akhiriPinjaman() {
        $search = $_GET['search'] ?? '';
        $activePinjaman = $this->pinjamModel->getActivePinjaman($search);

        require_once 'views/admin/akhiri_pinjaman.php';
    }

    // 5. Selesaikan / Akhiri Pinjaman
    public function prosesAkhiriPinjaman() {
        $id_pinjam = $_GET['id'] ?? null;
        if ($id_pinjam) {
            $this->pinjamModel->akhiriPinjaman($id_pinjam);
        }
        header('Location: index.php?page=admin&action=akhiriPinjaman');
        exit;
    }

    // 6. Kelola Buku (Daftar Buku & Form Tambah)
    public function kelolaBuku() {
        $search = $_GET['search'] ?? '';
        $bukuList = $this->bukuModel->getAllBuku($search);

        // Ambil data kategori untuk dropdown select
        $stmt = $this->db->query("SELECT * FROM kategori");
        $kategoriList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once 'views/admin/kelola_buku.php';
    }

    public function tambahBuku() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama        = trim($_POST['nama_buku'] ?? '');
        $id_kategori = $_POST['id_kategori'] ?? null;
        $stok        = $_POST['stok'] ?? 1;
        $gambarNama  = null;

        // Proses Upload Gambar
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath   = $_FILES['gambar']['tmp_name'];
            $fileName      = $_FILES['gambar']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExts   = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $allowedExts)) {
                $gambarNama = time() . '_' . uniqid() . '.' . $fileExtension;
                $uploadFileDir = 'uploads/';
                move_uploaded_file($fileTmpPath, $uploadFileDir . $gambarNama);
            }
        }

        if (!empty($nama) && $id_kategori) {
            $this->bukuModel->tambahBuku($nama, $id_kategori, $stok, $gambarNama);
        }
    }
    header('Location: index.php?page=admin&action=kelolaBuku');
    exit;
}

    // 8. Hapus Buku
    public function hapusBuku() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $this->db->prepare("DELETE FROM buku WHERE id_buku = :id");
            $stmt->execute([':id' => $id]);
        }
        header('Location: index.php?page=admin&action=kelolaBuku');
        exit;
    }

    // 9. Kelola User (Daftar User & Form Tambah)
    public function kelolaUser() {
        $userList = $this->userModel->getAllUsers();
        require_once 'views/admin/kelola_user.php';
    }

    // 10. Memproses Tambah User Baru
public function tambahUser() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $nis      = trim($_POST['nis'] ?? '');
        $kelas    = trim($_POST['kelas'] ?? '');
        $role     = $_POST['role'] ?? 'siswa';

        if (!empty($nama) && !empty($email) && !empty($password)) {
            // Pastikan urutan parameter sesuai dengan UserModel::register()
            $this->userModel->register($nama, $email, $password, $role, $nis, $kelas);
        }
    }
    header('Location: index.php?page=admin&action=kelolaUser');
    exit;
}

    // 11. Hapus User
    public function hapusUser() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->userModel->deleteUser($id);
        }
        header('Location: index.php?page=admin&action=kelolaUser');
        exit;
    }
// Memproses Edit User
public function editUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_user  = $_POST['id_user'];
            $nama     = trim($_POST['nama']);
            $email    = trim($_POST['email']);
            $role     = trim($_POST['role']);
            $nis      = trim($_POST['nis'] ?? '');
            $kelas    = trim($_POST['kelas'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $this->userModel->updateUser($id_user, $nama, $email, $role, $nis, $kelas, $password);
        }
        header('Location: index.php?page=admin&action=kelolaUser');
        exit;
    }

// Memproses Edit Buku
public function editBuku() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_buku     = $_POST['id_buku'];
        $nama_buku   = trim($_POST['nama_buku']);
        $id_kategori = $_POST['id_kategori'];
        $stok        = $_POST['stok'];
        $gambarNama  = null;

        // Proses Upload Gambar Baru jika ada
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath   = $_FILES['gambar']['tmp_name'];
            $fileName      = $_FILES['gambar']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExts   = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $allowedExts)) {
                $gambarNama = time() . '_' . uniqid() . '.' . $fileExtension;
                $uploadFileDir = 'uploads/';
                move_uploaded_file($fileTmpPath, $uploadFileDir . $gambarNama);
            }
        }

        $this->bukuModel->updateBuku($id_buku, $nama_buku, $id_kategori, $stok, $gambarNama);
    }
    header('Location: index.php?page=admin&action=kelolaBuku');
    exit;
}
// Halaman Kelola Kategori
public function kelolaKategori() {
    $this->checkAdmin();
    $kategoriList = $this->kategoriModel->getAllKategori();
    require_once 'views/admin/kelola_kategori.php';
}

// Memproses Tambah Kategori
public function tambahKategori() {
    $this->checkAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_kategori = trim($_POST['nama_kategori'] ?? '');
        if (!empty($nama_kategori)) {
            $this->kategoriModel->tambahKategori($nama_kategori);
        }
    }
    header('Location: index.php?page=admin&action=kelolaKategori');
    exit;
}

// Memproses Edit Kategori
public function editKategori() {
    $this->checkAdmin();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_kategori   = $_POST['id_kategori'];
        $nama_kategori = trim($_POST['nama_kategori']);
        if (!empty($nama_kategori)) {
            $this->kategoriModel->updateKategori($id_kategori, $nama_kategori);
        }
    }
    header('Location: index.php?page=admin&action=kelolaKategori');
    exit;
}

// Memproses Hapus Kategori
public function hapusKategori() {
    $this->checkAdmin();
    $id_kategori = $_GET['id'] ?? null;
    if ($id_kategori) {
        $this->kategoriModel->hapusKategori($id_kategori);
    }
    header('Location: index.php?page=admin&action=kelolaKategori');
    exit;
}
public function riwayatPinjam() {
    $search = trim($_GET['search'] ?? '');
    $riwayatList = $this->pinjamModel->getRiwayatPinjaman($search);

    require_once 'views/admin/riwayat_pinjam.php';
}


}