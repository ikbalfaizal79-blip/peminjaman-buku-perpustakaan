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
        --input-placeholder: #adb5bd;
        --table-border: #e9ecef;
        --table-header-color: #495057;
        --cover-placeholder-bg: #e9ecef;
        --btn-nav-bg: #e9ecef;
        --btn-nav-text: #495057;
        --btn-nav-hover: #dee2e6;
        --btn-blue-bg: #007bff;
        --btn-blue-hover: #0056b3;
        --shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] {
        --bg-body: #121212;
        --bg-card: #242424;
        --bg-header: #1e1e1e;
        --text-main: #ffffff;
        --text-muted: #aaa;
        --border-color: #333333;
        --input-bg: #7d7d7d;
        --input-border: transparent;
        --input-text: #ffffff;
        --input-placeholder: #d1d1d1;
        --table-border: #333333;
        --table-header-color: #aaa;
        --cover-placeholder-bg: #444444;
        --btn-nav-bg: #34495e;
        --btn-nav-text: white;
        --btn-nav-hover: #2c3e50;
        --btn-blue-bg: #4a4a4a;
        --btn-blue-hover: #666666;
        --shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        font-family: Arial, sans-serif;
        margin: 0;
        transition: background-color 0.3s, color 0.3s;
    }

    .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        box-shadow: var(--shadow);
        padding: 20px;
        box-sizing: border-box;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: var(--bg-header);
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 20px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .status-badge {
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: bold;
        text-transform: capitalize;
    }
    .status-menunggu { background-color: #f39c12; color: #fff; }
    .status-dipinjam { background-color: #27ae60; color: #fff; }
    .status-selesai { background-color: #2980b9; color: #fff; }
    .status-ditolak { background-color: #c0392b; color: #fff; }

    .btn-nav {
        background-color: var(--btn-nav-bg);
        color: var(--btn-nav-text);
        padding: 6px 14px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        margin-right: 8px;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.2s;
        border: 1px solid var(--border-color);
    }
    .btn-nav:hover {
        background-color: var(--btn-nav-hover);
    }

    .input-dark {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--input-text);
        padding: 6px 12px;
        border-radius: 12px;
        outline: none;
        transition: background-color 0.3s, color 0.3s;
    }
    .input-dark::placeholder {
        color: var(--input-placeholder);
    }

    .btn-blue {
        background-color: var(--btn-blue-bg);
        color: white;
        border: none;
        padding: 6px 18px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-blue:hover {
        opacity: 0.85;
    }

    .btn-red {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-red:hover {
        opacity: 0.85;
    }

    /* Tombol Switch Tema di Pojok */
    .theme-toggle-btn {
        background-color: var(--bg-card);
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 6px 12px;
        border-radius: 15px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        box-shadow: var(--shadow);
        transition: background-color 0.2s;
    }
    .theme-toggle-btn:hover {
        opacity: 0.9;
    }
</style>

<!-- Header Bar -->
<div class="header-bar">
    <div style="color: var(--text-main); font-weight: 500;">Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (pengguna)</div>
    <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
        <!-- Tombol Ganti Tema -->
        <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>

        <!-- Tombol Menuju Menu Riwayat Pinjaman -->
        <a href="index.php?page=siswa&action=riwayat" class="btn-nav">📋 Riwayat saya</a>

        <!-- Form Pencarian -->
        <form method="GET" action="index.php" style="display:inline; margin: 0;">
            <input type="hidden" name="page" value="siswa">
            <input type="hidden" name="action" value="dashboard">
            <input type="text" name="search" placeholder="Telusuri" value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" class="input-dark" style="width:140px; height: 32px; box-sizing: border-box; font-size: 13px;">
        </form>

        <a href="index.php?page=logout" class="btn-red" style="height: 32px; box-sizing: border-box;">Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px; color: var(--text-main);">📖 Peminjaman Buku</h2>

<div style="display: flex; gap: 20px; padding: 0 20px; align-items: flex-start; flex-wrap: wrap;">
    <!-- Tabel Daftar Buku (Kiri) -->
    <div class="card" style="flex: 2; min-width: 300px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="color: var(--table-header-color); font-size: 14px; text-align: left; border-bottom: 1px solid var(--border-color);">
                    <th style="padding: 10px;">Cover</th>
                    <th style="padding: 10px;">Nama</th>
                    <th style="padding: 10px;">Kategori</th>
                    <th style="padding: 10px;">Stok</th>
                    <th style="padding: 10px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bukuList)): ?>
                    <?php foreach ($bukuList as $b): ?>
                    <tr style="border-bottom: 1px solid var(--table-border);">
                        <td style="padding: 10px;">
                            <?php if (!empty($b['gambar']) && file_exists('uploads/' . $b['gambar'])): ?>
                                <img src="uploads/<?= htmlspecialchars($b['gambar']); ?>" alt="Cover" style="width: 45px; height: 60px; object-fit: cover; border-radius: 6px;">
                            <?php else: ?>
                                <div style="width: 45px; height: 60px; background: var(--cover-placeholder-bg); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 20px;">📘</div>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px 10px; font-weight: bold; color: var(--text-main);"><?= htmlspecialchars($b['nama_buku']); ?></td>
                        <td style="padding: 12px 10px; color: var(--text-muted);"><?= htmlspecialchars($b['nama_kategori'] ?? '-'); ?></td>
                        <td style="padding: 12px 10px; color: var(--text-muted);"><?= $b['stok']; ?></td>
                        <td style="padding: 12px 10px; text-align: right;">
                            <a href="index.php?page=siswa&action=ajukanPinjam&id=<?= $b['id_buku']; ?>" class="btn btn-blue">Pinjam</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Buku tidak ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Ringkasan Riwayat Saya (Kanan) -->
    <div class="card" style="flex: 1; min-width: 280px; height: fit-content;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 16px; color: var(--text-main);">Riwayat saya</h3>
            <a href="index.php?page=siswa&action=riwayat" style="color: var(--btn-blue-bg); text-decoration: none; font-size: 12px; font-weight: bold;">Lihat Semua &raquo;</a>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <tbody>
                <?php if (!empty($riwayatSaya)): ?>
                    <?php foreach ($riwayatSaya as $r): ?>
                    <tr style="border-bottom: 1px solid var(--table-border);">
                        <td style="padding: 10px 0; font-weight: bold; font-size: 14px; color: var(--text-main);">
                            <?= htmlspecialchars($r['nama_buku']); ?>
                        </td>
                        <td style="padding: 10px 0; font-size: 12px; color: var(--text-muted); text-align: center;">
                            <?= $r['jumlah']; ?> unit<br>
                            <span style="font-size: 10px; color: var(--text-muted);"><?= date('d-m-Y', strtotime($r['tgl_pinjam'])); ?></span>
                        </td>
                        <td style="padding: 10px 0; text-align: right;">
                            <span class="status-badge status-<?= $r['status']; ?>"><?= $r['status']; ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php elseif (!empty($riwayat)): ?>
                    <?php foreach ($riwayat as $r): ?>
                    <tr style="border-bottom: 1px solid var(--table-border);">
                        <td style="padding: 10px 0; font-weight: bold; color: var(--text-main);"><?= htmlspecialchars($r['nama_buku']); ?></td>
                        <td style="padding: 10px 0; color: var(--text-muted); font-size: 14px; text-align: center;"><?= $r['jumlah']; ?> unit</td>
                        <td style="padding: 10px 0; color: var(--text-muted); font-size: 14px; text-align: center;"><?= date('d-m-Y', strtotime($r['tgl_pinjam'])); ?></td>
                        <td style="padding: 10px 0; text-align: right;">
                            <span class="status-badge status-<?= $r['status']; ?>">
                                <?= $r['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 15px; font-size: 13px;">Belum ada riwayat peminjaman.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>

<!-- Script untuk Mengatur & Menyimpan Preferensi Tema -->
<script>
    const htmlElement = document.documentElement;
    const themeToggleBtn = document.getElementById('themeToggle');

    // Cek LocalStorage saat halaman dimuat
    const savedTheme = localStorage.getItem('theme') || 'dark'; // Default diset dark sesuai preferensi awal
    if (savedTheme === 'light') {
        htmlElement.setAttribute('data-theme', 'light');
        themeToggleBtn.textContent = '🌙 Dark Mode';
    } else {
        htmlElement.setAttribute('data-theme', 'dark');
        themeToggleBtn.textContent = '☀️ Light Mode';
    }

    // Fungsi untuk mengganti tema
    function toggleTheme() {
        const currentTheme = htmlElement.getAttribute('data-theme');
        if (currentTheme === 'dark') {
            htmlElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
            themeToggleBtn.textContent = '🌙 Dark Mode';
        } else {
            htmlElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeToggleBtn.textContent = '☀️ Light Mode';
        }
    }
</script>