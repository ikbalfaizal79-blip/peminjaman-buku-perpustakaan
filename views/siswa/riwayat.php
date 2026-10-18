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
        --table-border: #e9ecef;
        --table-header-color: #495057;
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
        --table-border: #333333;
        --table-header-color: #aaa;
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
        padding: 25px;
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
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        text-transform: capitalize;
        display: inline-block;
    }
    .status-menunggu { background-color: #f39c12; color: #fff; }
    .status-dipinjam { background-color: #27ae60; color: #fff; }
    .status-selesai { background-color: #2980b9; color: #fff; }
    .status-ditolak { background-color: #c0392b; color: #fff; }
    
    .btn-return {
        background-color: #e67e22;
        color: white;
        padding: 5px 12px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
        transition: opacity 0.2s;
    }
    .btn-return:hover { opacity: 0.85; }

    .btn {
        padding: 6px 14px;
        border-radius: 15px;
        text-decoration: none;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        font-size: 13px;
        cursor: pointer;
        border: none;
        transition: opacity 0.2s;
    }
    .btn:hover { opacity: 0.85; }
    .btn-blue {
        background-color: var(--btn-blue-bg);
        color: white;
    }
    .btn-red {
        background-color: #dc3545;
        color: white;
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
        height: 32px;
        box-sizing: border-box;
    }
    .theme-toggle-btn:hover {
        opacity: 0.9;
    }
</style>

<!-- Header Bar -->
<div class="header-bar">
    <div style="color: var(--text-main); font-weight: 500;">Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (siswa)</div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Tombol Ganti Tema -->
        <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>
        
        <a href="index.php?page=siswa&action=dashboard" class="btn btn-blue" style="height: 32px; box-sizing: border-box;">Dashboard</a>
        <a href="index.php?page=logout" class="btn btn-red" style="height: 32px; box-sizing: border-box;">Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px; color: var(--text-main);">📖 Riwayat Peminjaman Buku</h2>

<div class="card" style="max-width: 950px; margin: 0 auto;">
    <div style="margin-bottom: 20px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px;">
        <h3 style="margin: 0; font-size: 18px; color: var(--text-main);">Daftar Pinjaman Saya</h3>
    </div>

    <div class="table-container">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="color: var(--table-header-color); font-size: 14px; text-align: left; border-bottom: 2px solid var(--border-color);">
                    <th style="padding: 10px;">Buku</th>
                    <th style="padding: 10px;">Jumlah</th>
                    <th style="padding: 10px;">Tgl Pinjam</th>
                    <th style="padding: 10px;">Tgl Kembali</th>
                    <th style="padding: 10px; text-align: center;">Status</th>
                    <th style="padding: 10px;">Denda</th>
                    <th style="padding: 10px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($riwayatList)): ?>
                    <?php foreach ($riwayatList as $r): ?>
                    <?php
                        // Logika Penghitungan Denda
                        $denda_tampil = 0;
                        $ket_denda = '';

                        // Jika status masih dipinjam, hitung denda berjalan secara realtime
                        if ($r['status'] === 'dipinjam' && !empty($r['tgl_kembali'])) {
                            $tgl_kembali = new DateTime($r['tgl_kembali']);
                            $tgl_sekarang = new DateTime(date('Y-m-d')); // Tanggal hari ini tanpa jam

                            if ($tgl_sekarang > $tgl_kembali) {
                                $selisih = $tgl_sekarang->diff($tgl_kembali);
                                $hari_terlambat = $selisih->days;
                                $denda_tampil = $hari_terlambat * 10000;
                                $ket_denda = 'Terlambat ' . $hari_terlambat . ' hari';
                            }
                        } else {
                            // Jika sudah selesai/dikembalikan, ambil nilai denda dari database
                            $denda_tampil = $r['denda'] ?? 0;
                            if ($denda_tampil > 0) {
                                $ket_denda = 'Denda Final';
                            }
                        }
                    ?>
                    <tr style="border-bottom: 1px solid var(--table-border);">
                        <td style="padding: 12px 10px; font-weight: bold; color: var(--text-main);"><?= htmlspecialchars($r['nama_buku']); ?></td>
                        <td style="padding: 12px 10px; color: var(--text-main);"><?= $r['jumlah']; ?></td>
                        <td style="padding: 12px 10px; color: var(--text-muted);"><?= !empty($r['tgl_pinjam']) ? date('d-m-Y', strtotime($r['tgl_pinjam'])) : '-'; ?></td>
                        <td style="padding: 12px 10px; color: var(--text-muted);"><?= !empty($r['tgl_kembali']) ? date('d-m-Y', strtotime($r['tgl_kembali'])) : '-'; ?></td>
                        <td style="padding: 12px 10px; text-align: center;">
                            <span class="status-badge status-<?= strtolower($r['status']); ?>">
                                <?= htmlspecialchars($r['status']); ?>
                            </span>
                        </td>
                        <td style="padding: 12px 10px;">
                            <?php if ($denda_tampil > 0): ?>
                                <span style="color: #e74c3c; font-weight: bold;">
                                    Rp <?= number_format($denda_tampil, 0, ',', '.'); ?>
                                </span>
                                <?php if ($ket_denda): ?>
                                    <br><small style="color: #e74c3c; font-size: 11px;"><?= $ket_denda; ?></small>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="color: #2ecc71; font-weight: bold;">Rp 0</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px 10px; text-align: right;">
                            <?php if ($r['status'] === 'dipinjam'): ?>
                                <a href="index.php?page=siswa&action=kembalikanBuku&id=<?= $r['id_pinjam']; ?>" 
                                   class="btn-return" 
                                   onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                                   Kembalikan
                                </a>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-size: 12px;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 25px;">Belum ada riwayat peminjaman.</td>
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