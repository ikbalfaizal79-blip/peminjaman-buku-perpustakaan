<?php
session_start();
require_once 'config/Database.php';

$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? 'index';

if ($page == 'login') {
    require_once 'controllers/AuthController.php';
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->login();
    } else {
        $controller->showLogin();
    }
} elseif ($page == 'register') {
    require_once 'controllers/AuthController.php';
    $controller = new AuthController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->register();
    } else {
        $controller->showRegister();
    }
} elseif ($page == 'logout') {
    require_once 'controllers/AuthController.php';
    (new AuthController())->logout();
} elseif ($page == 'admin') {
    require_once 'controllers/AdminController.php';
    $controller = new AdminController();
    
    // Secara otomatis memanggil method di AdminController sesuai parameter $action
    // (Termasuk riwayatPinjam, kelolaKategori, tambahKategori, setujuiPinjam, dll)
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->dashboard();
    }

} elseif ($page == 'siswa') {
    require_once 'controllers/SiswaController.php';
    $controller = new SiswaController();

    if ($action == 'ajukanPinjam') {
        $controller->ajukanPinjam();
    } elseif ($action == 'prosesPinjam') {
        $controller->prosesPinjam();
    } elseif ($action == 'kembalikanBuku') {
        $controller->kembalikanBuku();
    } elseif ($action == 'riwayat') {
        $controller->riwayat();
    } else {
        $controller->dashboard();
    }
}