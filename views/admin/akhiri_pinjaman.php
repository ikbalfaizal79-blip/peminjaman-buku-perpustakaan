<?php include 'views/layout/header.php'; ?>

<style>
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
    }
    .btn-finish { background-color: #e74c3c; }
    .btn-finish:hover { background-color: #c0392b; }

    /* Styling khusus untuk merapikan Sidebar */
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
        background-color: #383838;
        color: #ffffff;
        text-decoration: none;
        text-align: center;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        box-sizing: border-box;
        transition: background-color 0.2s, transform 0.1s;
    }
    .btn-sidebar:hover {
        background-color: #4a4a4a;
    }
    .btn-sidebar.active {
        background-color: #666666;
        font-weight: bold;
    }
</style>

<div class="header-bar">
    <div>Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (admin)</div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <form method="GET" action="index.php" style="display:inline;">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="action" value="<?= $_GET['action'] ?? 'dashboard'; ?>">
            <input type="text" name="search" placeholder="Telusuri" value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" class="input-dark" style="width:150px;">
        </form>
        
        <!-- Tombol Riwayat Peminjaman -->
        <a href="index.php?page=admin&action=riwayatPinjam" class="btn btn-blue" style="border-radius: 15px; font-size: 13px; padding: 6px 12px;">📋 Riwayat</a>
        
        <a href="index.php?page=logout" class="btn btn-red">Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px;">📖 Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 200px; padding: 20px; box-sizing: border-box;">
        <p style="color: #aaa; margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar active">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Data Pinjaman Aktif -->
    <div class="card" style="flex: 3; box-sizing: border-box;">
        <h3 style="margin-top: 0; font-size: 18px;">Akhiri peminjaman</h3>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="color: #aaa; font-size: 14px; text-align: left; border-bottom: 1px solid #444;">
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
            <tr style="border-bottom: 1px solid #333;">
                <td style="padding: 12px 10px; font-weight: bold;"><?= htmlspecialchars($p['nama_siswa']); ?></td>
                <td style="padding: 12px 10px;"><?= htmlspecialchars($p['nama_buku']); ?></td>
                <td style="padding: 12px 10px; color: #aaa;"><?= !empty($p['tgl_kembali']) ? date('d-m-Y', strtotime($p['tgl_kembali'])) : '-'; ?></td>
                <td style="padding: 12px 10px;">
                    <?php if ($hari_terlambat > 0): ?>
                        <span style="color: #e74c3c; font-weight: bold;"><?= $hari_terlambat; ?> Hari</span>
                    <?php else: ?>
                        <span style="color: #2ecc71;">Tepat Waktu</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 12px 10px; font-weight: bold; color: <?= $estimasi_denda > 0 ? '#e74c3c' : '#2ecc71'; ?>;">
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
                <td colspan="6" style="text-align: center; color: #888; padding: 20px;">Tidak ada transaksi peminjaman yang sedang aktif.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>