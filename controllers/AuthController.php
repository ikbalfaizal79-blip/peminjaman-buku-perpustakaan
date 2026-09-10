<?php
require_once 'config/Database.php';
require_once 'models/User.php';

class AuthController {
    private $db;
    private $userModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    // Menampilkan halaman login dan memproses submit form login
    public function login() {
        $error = null;
        

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($email) && !empty($password)) {
                $user = $this->userModel->login($email, $password);

                if ($user) {
                    // Simpan data user ke Session
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'role' => $user['role']
                    ];

                    // Redirect berdasarkan role
                    if ($user['role'] === 'admin') {
                        header("Location: index.php?action=admin_dashboard");
                    } else {
                        header("Location: index.php?action=siswa_dashboard");
                    }
                    exit();
                } else {
                    $error = "Email atau Password salah!";
                }
            } else {
                $error = "Semua kolom wajib diisi!";
            }
        }

        // Tampilkan View Login
        $viewFile = 'views/auth/login.php';
        require_once 'views/layout.php';
    }

    // Menampilkan halaman registrasi siswa dan memproses pendaftaran
    public function register() {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($nama) && !empty($email) && !empty($password)) {
                // Default role pendaftaran publik adalah 'siswa'
                $created = $this->userModel->create($nama, $email, $password, 'siswa');

                if ($created) {
                    header("Location: index.php?action=login&registered=1");
                    exit();
                } else {
                    $error = "Gagal mendaftar. Email mungkin sudah digunakan.";
                }
            } else {
                $error = "Semua kolom wajib diisi!";
            }
        }

        // Tampilkan View Register
        $viewFile = 'views/auth/register.php';
        require_once 'views/layout.php';
    }

    // Memproses Logout
    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}