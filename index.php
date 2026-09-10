<?php
session_start();

$action = $_GET['action'] ?? 'login';

switch ($action) {
    // ==========================================
    // AUTHENTICATION
    // ==========================================
    case 'login':
        require_once 'controllers/AuthController.php';
        (new AuthController())->login();
        break;

    case 'register':
        require_once 'controllers/AuthController.php';
        (new AuthController())->register();
        break;

    case 'logout':
        require_once 'controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    // ==========================================
    // ADMIN ROUTES
    // ==========================================
    case 'admin_dashboard':
    case 'setujui_pinjam':
        require_once 'controllers/AdminController.php';
        (new AdminController())->setujuiPinjam();
        break;

    case 'acc_pinjam':
        require_once 'controllers/AdminController.php';
        (new AdminController())->accPinjam();
        break;

    case 'tolak_pinjam':
        require_once 'controllers/AdminController.php';
        (new AdminController())->tolakPinjam();
        break;

    case 'akhiri_pinjaman':
        require_once 'controllers/AdminController.php';
        (new AdminController())->akhiriPinjaman();
        break;

    case 'proses_pengembalian':
        require_once 'controllers/AdminController.php';
        (new AdminController())->prosesPengembalian();
        break;

    case 'kelola_buku':
        require_once 'controllers/AdminController.php';
        (new AdminController())->kelolaBuku();
        break;

    case 'tambah_buku':
        require_once 'controllers/AdminController.php';
        (new AdminController())->tambahBuku();
        break;

    case 'kelola_user':
        require_once 'controllers/AdminController.php';
        (new AdminController())->kelolaUser();
        break;

    case 'tambah_user':
        require_once 'controllers/AdminController.php';
        (new AdminController())->tambahUser();
        break;

    // ==========================================
    // SISWA ROUTES
    // ==========================================
    case 'siswa_dashboard':
        require_once 'controllers/SiswaController.php';
        (new SiswaController())->dashboard();
        break;

    
    case 'pinjam':
        $siswaController->pinjamBuku();
        break;

    default:
        $authController->login();
        break;
}