<?php include 'views/layout/header.php'; ?>

<style>
    /* Definisi Variabel Warna untuk Tema Terang & Gelap */
    :root {
        --bg-body: #f8f9fa;
        --bg-card: #ffffff;
        --bg-header: #ffffff;
        --text-main: #333333;
        --text-muted: #6c757d;
        --border-color: #e0e0e0;
        --input-bg: #ffffff;
        --input-border: #ced4da;
        --input-text: #495057;
        --sidebar-bg: #f1f3f5;
        --sidebar-hover: #e9ecef;
        --sidebar-text: #495057;
        --sidebar-active-bg: #007bff;
        --sidebar-active-text: #ffffff;
        --table-border: #e9ecef;
        --badge-count-bg: #e9ecef;
        --badge-count-text: #495057;
    }

    [data-theme="dark"] {
        --bg-body: #121212;
        --bg-card: #1e1e1e;
        --bg-header: #1e1e1e;
        --text-main: #e0e0e0;
        --text-muted: #aaa;
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
        --badge-count-bg: #2d2d2d;
        --badge-count-text: #ffffff;
    }

    /* Styling Dasar Menggunakan Variabel */
    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        transition: background-color 0.3s, color 0.3s;
    }

    .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 20px;
        box-sizing: border-box;
    }

    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: var(--bg-header);
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 20px;
    }

    .badge-status {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
        text-transform: capitalize;
    }
    .status-selesai { background-color: #28a745; color: #fff; }
    .status-ditolak { background-color: #dc3545; color: #fff; }
    
    .badge-count {
        background-color: var(--badge-count-bg);
        color: var(--badge-count-text);
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        float: right;
        border: 1px solid var(--input-border);
        text-align: center;
    }

    /* Styling Sidebar */
    .sidebar-menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
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
        transition: background-color 0.2s, color 0.2s;
    }
    .btn-sidebar:hover { 
        background-color: var(--sidebar-hover); 
    }
    .btn-sidebar.active { 
        background-color: var(--sidebar-active-bg); 
        color: var(--sidebar-active-text); 
        font-weight: bold; 
    }

    .input-dark, input[type="text"] {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--input-text);
        padding: 0 12px;
        border-radius: 6px;
        outline: none;
        box-sizing: border-box;
    }
    .input-dark:focus, input[type="text"]:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Penyelarasan Tinggi & Tampilan Elemen Header */
    .header-bar .theme-toggle-btn, 
    .header-bar input[type="text"], 
    .header-bar .btn-red {
        height: 38px;
        box-sizing: border-box;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        vertical-align: middle;
    }

    .btn-red {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 0 14px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.2s;
    }
    .btn-red:hover {
        background-color: #c82333;
        color: white;
    }

    /* Tombol Switch Tema */
    .theme-toggle-btn {
        background-color: var(--sidebar-bg);
        color: var(--text-main);
        border: 1px solid var(--input-border);
        padding: 0 14px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .theme-toggle-btn:hover {
        background-color: var(--sidebar-hover);
    }
</style>

<!-- Header Bar -->
<div class="header-bar">
    <div style="font-weight: 500; color: var(--text-main);">Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (admin)</div>
    <div style="display: flex; align-items: center; gap: 12px;">
        <!-- Tombol Ganti Tema -->
        <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>

        <form method="GET" action="index.php" style="display: inline-flex; margin: 0;">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="action" value="riwayatPinjam">
            <input type="text" name="search" placeholder="Telusuri..." value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" class="input-dark" style="width: 180px;">
        </form>
        
        <a href="index.php?page=logout" class="btn-red">Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px; color: var(--text-main);">📖 Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start; padding: 0 20px;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 220px; padding: 20px; box-sizing: border-box;">
        <p style="color: var(--text-muted); margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; font-weight: bold;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Riwayat Peminjaman -->
    <div class="card" style="flex: 3; box-sizing: border-box;">
        <div style="margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; color: var(--text-main);">Riwayat Peminjaman</h3>
            <span class="badge-count">Total Riwayat: <strong style="font-size: 14px; color: var(--text-main);"><?= count($riwayatList); ?></strong></span>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="color: var(--text-muted); font-size: 13px; text-align: left; border-bottom: 2px solid var(--border-color); text-transform: uppercase;">
                        <th style="padding: 10px;">Peminjam</th>
                        <th style="padding: 10px;">Buku</th>
                        <th style="padding: 10px;">Tgl Pinjam</th>
                        <th style="padding: 10px;">Tgl Kembali</th>
                        <th style="padding: 10px;">Denda</th>
                        <th style="padding: 10px; text-align: right;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($riwayatList)): ?>
                        <?php foreach ($riwayatList as $r): ?>
                        <tr style="border-bottom: 1px solid var(--table-border);">
                            <td style="padding: 12px 10px; font-weight: bold; color: var(--text-main);">
                                <?= htmlspecialchars($r['nama_siswa']); ?>
                                <?php if (!empty($r['kelas'])): ?>
                                    <br><small style="color: var(--text-muted); font-weight: normal;"><?= htmlspecialchars($r['kelas']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 10px; color: var(--input-text); font-weight: 500;"><?= htmlspecialchars($r['nama_buku']); ?></td>
                            <td style="padding: 12px 10px; color: var(--text-muted); font-size: 13px;">
                                <?= !empty($r['tgl_pinjam']) ? date('d-m-Y', strtotime($r['tgl_pinjam'])) : '-'; ?>
                            </td>
                            <td style="padding: 12px 10px; color: var(--text-muted); font-size: 13px;">
                                <?= !empty($r['tgl_kembali']) ? date('d-m-Y', strtotime($r['tgl_kembali'])) : '-'; ?>
                            </td>
                            <td style="padding: 12px 10px; font-weight: bold; color: <?= ($r['denda'] > 0) ? '#dc3545' : 'var(--text-muted)'; ?>;">
                                Rp <?= number_format($r['denda'] ?? 0, 0, ',', '.'); ?>
                            </td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <?php if ($r['status'] === 'selesai'): ?>
                                    <span class="badge-status status-selesai">Selesai</span>
                                <?php else: ?>
                                    <span class="badge-status status-ditolak">Ditolak</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 25px; font-size: 13px;">Belum ada riwayat transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script untuk Mengatur & Menyimpan Preferensi Tema -->
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