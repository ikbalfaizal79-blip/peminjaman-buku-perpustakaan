<?php include 'views/layout/header.php'; ?>

<style>
    /* Definisi Variabel Warna untuk Tema Terang & Gelap */
    :root {
        --bg-body: #f8f9fa;
        --bg-card: #ffffff;
        --bg-header: #ffffff;
        --text-main: #333333;
        --text-muted: #6c757d;
        --text-heading: #212529;
        --border-color: #e0e0e0;
        --input-bg: #ffffff;
        --input-border: #ced4da;
        --input-text: #495057;
        --sidebar-bg: #f1f3f5;
        --sidebar-hover: #e2e6ea;
        --sidebar-text: #495057;
        --sidebar-active-bg: #007bff;
        --sidebar-active-text: #ffffff;
        --table-border: #e9ecef;
        --table-header-border: #dee2e6;
    }

    [data-theme="dark"] {
        --bg-body: #121212;
        --bg-card: #1e1e1e;
        --bg-header: #1e1e1e;
        --text-main: #e0e0e0;
        --text-muted: #aaa;
        --text-heading: #ffffff;
        --border-color: #333333;
        --input-bg: #2d2d2d;
        --input-border: #444444;
        --input-text: #ffffff;
        --sidebar-bg: #252525;
        --sidebar-hover: #333333;
        --sidebar-text: #cccccc;
        --sidebar-active-bg: #444444;
        --sidebar-active-text: #ffffff;
        --table-border: #333333;
        --table-header-border: #444444;
    }

    /* Styling Dasar Menggunakan Variabel */
    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        transition: background-color 0.3s, color 0.3s;
    }

    .table-container {
        margin-top: 15px;
    }

    .btn-action {
        padding: 6px 16px;
        border-radius: 15px;
        text-decoration: none;
        color: white;
        font-size: 13px;
        font-weight: bold;
        margin-left: 5px;
        display: inline-block;
    }
    .btn-approve { background-color: #28a745; }
    .btn-reject { background-color: #dc3545; }
    .btn-approve:hover { background-color: #218838; }
    .btn-reject:hover { background-color: #c82333; }

    /* Kartu / Container */
    .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Input */
    .input-dark, input[type="text"] {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--input-text);
        padding: 6px 10px;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .input-dark:focus, input[type="text"]:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Tombol Utama */
    .btn-blue {
        background-color: #007bff;
        color: white;
        border: none;
    }
    .btn-blue:hover {
        background-color: #0056b3;
        color: white;
    }
    .btn-red {
        background-color: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
        border: none;
    }
    .btn-red:hover {
        background-color: #c82333;
    }

    /* Styling Sidebar */
    .sidebar-menu {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 100%;
        box-sizing: border-box;
    }
    .btn-sidebar {
        display: block;
        width: 100%;
        padding: 10px 14px;
        background-color: var(--sidebar-bg);
        color: var(--sidebar-text);
        text-decoration: none;
        text-align: center;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        box-sizing: border-box;
        transition: background-color 0.2s, transform 0.1s;
    }
    .btn-sidebar:hover {
        background-color: var(--sidebar-hover);
        color: var(--text-heading);
    }
    .btn-sidebar.active {
        background-color: var(--sidebar-active-bg);
        color: var(--sidebar-active-text);
        font-weight: bold;
    }

    /* Tombol Switch Tema */
    .theme-toggle-btn {
        background-color: var(--sidebar-bg);
        color: var(--text-main);
        border: 1px solid var(--input-border);
        padding: 6px 12px;
        border-radius: 15px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        transition: background-color 0.2s;
    }
    .theme-toggle-btn:hover {
        background-color: var(--sidebar-hover);
    }
</style>

<!-- Header Bar -->
<div class="header-bar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: var(--bg-header); border-bottom: 1px solid var(--border-color); margin-bottom: 20px;">
    <div style="font-weight: 500; color: var(--text-main);">Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (admin)</div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Tombol Ganti Tema -->
        <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>

        <form method="GET" action="index.php" style="display:inline;">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="action" value="<?= $_GET['action'] ?? 'dashboard'; ?>">
            <input type="text" name="search" placeholder="Telusuri" value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" style="width:150px;">
        </form>
        
        <!-- Tombol Riwayat Peminjaman -->
        <a href="index.php?page=admin&action=riwayatPinjam" class="btn btn-blue" style="border-radius: 15px; font-size: 13px; padding: 6px 12px; text-decoration: none;">📋 Riwayat</a>
        
        <a href="index.php?page=logout" class="btn-red">Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px; color: var(--text-heading);">Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start; padding: 0 20px;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 200px; padding: 20px; box-sizing: border-box;">
        <p style="color: var(--text-muted); margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; font-weight: bold;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar active">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">KelolaKategori</a>
        </div>
    </div>

    <!-- Tabel Data Persetujuan Peminjaman -->
    <div class="card" style="flex: 3; padding: 20px; box-sizing: border-box;">
        <h3 style="margin-top: 0; font-size: 18px; color: var(--text-heading);">Persetujuan peminjaman</h3>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="color: var(--text-muted); font-size: 14px; text-align: left; border-bottom: 2px solid var(--table-header-border);">
                        <th style="padding: 10px;">Peminjam</th>
                        <th style="padding: 10px;">Alat / Buku</th>
                        <th style="padding: 10px;">Jumlah</th>
                        <th style="padding: 10px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pendingList)): ?>
                        <?php foreach ($pendingList as $p): ?>
                        <tr style="border-bottom: 1px solid var(--table-border);">
                            <td style="padding: 12px 10px; font-weight: bold; color: var(--text-heading);"><?= htmlspecialchars($p['nama_siswa']); ?></td>
                            <td style="padding: 12px 10px; color: var(--text-main);"><?= htmlspecialchars($p['nama_buku']); ?></td>
                            <td style="padding: 12px 10px; color: var(--text-main);"><?= $p['jumlah']; ?></td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <a href="index.php?page=admin&action=setujuiPinjaman&id=<?= $p['id_pinjam']; ?>" class="btn-action btn-approve" onclick="return confirm('Setujui peminjaman ini?');">Setujui</a>
                                <a href="index.php?page=admin&action=tolakPinjaman&id=<?= $p['id_pinjam']; ?>" class="btn-action btn-reject" onclick="return confirm('Tolak peminjaman ini?');">Tolak</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 25px;">Tidak ada pengajuan peminjaman yang menunggu persetujuan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const htmlElement = document.documentElement;
    const themeToggleBtn = document.getElementById('themeToggle');

    // Cek LocalStorage saat halaman dimuat
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        htmlElement.setAttribute('data-theme', 'dark');
        themeToggleBtn.textContent = '☀️ Light Mode';
    }

    // Fungsi untuk mengganti tema
    function toggleTheme() {
        const currentTheme = htmlElement.getAttribute('data-theme');
        if (currentTheme === 'dark') {
            htmlElement.removeAttribute('data-theme');
            localStorage.setItem('theme', 'light');
            themeToggleBtn.textContent = '🌙 Dark Mode';
        } else {
            htmlElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeToggleBtn.textContent = '☀️ Light Mode';
        }
    }
</script>

<?php include 'views/layout/footer.php'; ?>