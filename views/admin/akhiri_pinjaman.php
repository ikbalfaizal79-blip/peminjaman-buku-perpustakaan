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
        display: inline-block;
    }
    .btn-finish { background-color: #e74c3c; }
    .btn-finish:hover { background-color: #c0392b; }

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

    /* Tombol Khusus */
    .btn-blue {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
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
        cursor: pointer;
    }
    .btn-red:hover {
        background-color: #c82333;
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
</style>

<!-- Header Bar dengan Tombol yang Dirapikan -->
<div class="header-bar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: var(--bg-header); border-bottom: 1px solid var(--border-color); margin-bottom: 20px;">
    <div style="font-weight: 500; color: var(--text-main);">Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (admin)</div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <!-- Tombol Ganti Tema -->
        <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>

        <form method="GET" action="index.php" style="display:inline; margin: 0;">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="action" value="<?= $_GET['action'] ?? 'dashboard'; ?>">
            <input type="text" name="search" placeholder="Telusuri..." value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" style="width: 140px;">
        </form>
        
        <!-- Tombol Riwayat Peminjaman -->
        <a href="index.php?page=admin&action=riwayatPinjam" class="btn btn-blue" style="border-radius: 15px; font-size: 13px; padding: 6px 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">📋 Riwayat</a>
        
        <!-- Tombol Logout -->
        <a href="index.php?page=logout" class="btn-red" style="border-radius: 15px; font-size: 13px; padding: 6px 12px; text-decoration: none;">🚪 Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px; color: var(--text-heading);">📖 Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start; padding: 0 20px;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 200px; padding: 20px; box-sizing: border-box;">
        <p style="color: var(--text-muted); margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; font-weight: bold;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar active">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Data Pinjaman Aktif -->
    <div class="card" style="flex: 3; padding: 20px; box-sizing: border-box;">
        <h3 style="margin-top: 0; font-size: 18px; color: var(--text-heading);">Akhiri peminjaman</h3>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="color: var(--text-muted); font-size: 14px; text-align: left; border-bottom: 2px solid var(--table-header-border);">
                        <th style="padding: 10px;">Peminjam</th>
                        <th style="padding: 10px;">Buku</th>
                        <th style="padding: 10px;">Batas Kembali</th>
                        <th style="padding: 10px;">Terlambat</th>
                        <th style="padding: 10px;">Estimasi Denda</th>
                        <th style="padding: 10px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($activePinjaman)): ?>
                        <?php foreach ($activePinjaman as $p): ?>
                        <?php
                            $hari_terlambat = 0;
                            $estimasi_denda = 0;

                            if (!empty($p['tgl_kembali'])) {
                                $tgl_kembali = new DateTime($p['tgl_kembali']);
                                $tgl_sekarang = new DateTime(date('Y-m-d'));

                                if ($tgl_sekarang > $tgl_kembali) {
                                    $selisih = $tgl_sekarang->diff($tgl_kembali);
                                    $hari_terlambat = $selisih->days;
                                    $estimasi_denda = $hari_terlambat * 10000;
                                }
                            }
                        ?>
                        <tr style="border-bottom: 1px solid var(--table-border);">
                            <td style="padding: 12px 10px; font-weight: bold; color: var(--text-heading);"><?= htmlspecialchars($p['nama_siswa']); ?></td>
                            <td style="padding: 12px 10px; color: var(--text-main);"><?= htmlspecialchars($p['nama_buku']); ?></td>
                            <td style="padding: 12px 10px; color: var(--text-muted);"><?= !empty($p['tgl_kembali']) ? date('d-m-Y', strtotime($p['tgl_kembali'])) : '-'; ?></td>
                            <td style="padding: 12px 10px;">
                                <?php if ($hari_terlambat > 0): ?>
                                    <span style="color: #dc3545; font-weight: bold;"><?= $hari_terlambat; ?> Hari</span>
                                <?php else: ?>
                                    <span style="color: #28a745; font-weight: 500;">Tepat Waktu</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 10px; font-weight: bold; color: <?= $estimasi_denda > 0 ? '#dc3545' : '#28a745'; ?>;">
                                Rp <?= number_format($estimasi_denda, 0, ',', '.'); ?>
                            </td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <a href="index.php?page=admin&action=prosesAkhiriPinjaman&id=<?= $p['id_pinjam']; ?>" 
                                   class="btn-action btn-finish" 
                                   onclick="return confirm('<?= $estimasi_denda > 0 ? 'Peminjaman terlambat! Total Denda: Rp ' . number_format($estimasi_denda, 0, ',', '.') . '. Akhiri peminjaman?' : 'Akhiri peminjaman ini?'; ?>');">
                                   Akhiri Pinjaman
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 25px;">Tidak ada transaksi peminjaman yang sedang aktif.</td>
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

    // Cek LocalStorage saat halaman dimuat agar preferensi tema tetap terjaga
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