<?php
require_once 'models/UserModel.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    // 1. Menampilkan Halaman Login
    public function showLogin() {
        // Jika user sudah dalam kondisi login, langsung alihkan sesuai role
        if (isset($_SESSION['user'])) {
            $this->redirectByUserRole($_SESSION['user']['role']);
            return;
        }
        require_once 'views/auth/login.php';
    }

    // 2. Memproses Aksi Login
    public function login() {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $error = "Email dan password wajib diisi!";
            require_once 'views/auth/login.php';
            return;
        }

        $user = $this->userModel->login($email, $password);

        if ($user) {
            // Simpan data identitas user ke session
            $_SESSION['user'] = [
                'id_user' => $user['id_user'],
                'nama'    => $user['nama'],
                'email'   => $user['email'],
                'role'    => $user['role']
            ];

            // Redirect ke halaman dashboard sesuai role
            $this->redirectByUserRole($user['role']);
        } else {
            $error = "Email atau password salah!";
            require_once 'views/auth/login.php';
        }
    }

    // 3. Menampilkan Halaman Register (Daftar Siswa)
    public function showRegister() {
        if (isset($_SESSION['user'])) {
            $this->redirectByUserRole($_SESSION['user']['role']);
            return;
        }
        require_once 'views/auth/register.php';
    }

    // 4. Memproses Registrasi Siswa Baru
    public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama     = trim($_POST['nama'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $nis      = trim($_POST['nis'] ?? '');
        $kelas    = trim($_POST['kelas'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role     = 'siswa'; // Default role registrasi mandiri adalah siswa

        if (!empty($nama) && !empty($email) && !empty($password)) {
            // Mendaftarkan user dengan parameter NIS dan Kelas
            $success = $this->userModel->register($nama, $email, $password, $role, $nis, $kelas);

            if ($success) {
                header('Location: index.php?page=login&msg=registrasi_berhasil');
                exit;
            } else {
                $error = "Registrasi gagal, email mungkin sudah digunakan.";
            }
        }
    }
    require_once 'views/auth/register.php';
}

    // 5. Memproses Logout
    public function logout() {
        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }

    // Helper Fungsi Redirect Berdasarkan Role
    private function redirectByUserRole($role) {
        if ($role === 'admin') {
            header('Location: index.php?page=admin&action=dashboard');
        } else {
            header('Location: index.php?page=siswa&action=dashboard');
        }
        exit;
    }
}