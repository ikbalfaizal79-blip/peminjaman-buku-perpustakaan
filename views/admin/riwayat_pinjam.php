<?php include 'views/layout/header.php'; ?>

<style>
    .badge-status {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
    }
    .status-selesai { background-color: #2ecc71; color: #fff; }
    .status-ditolak { background-color: #e74c3c; color: #fff; }
    .badge-count {
        background-color: #7d7d7d;
        color: #fff;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        float: right;
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
    .btn-sidebar:hover { background-color: #4a4a4a; }
    .btn-sidebar.active { background-color: #666666; font-weight: bold; }
</style>

<!-- Header Bar -->
<div class="header-bar">
    <div>Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (admin)</div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <form method="GET" action="index.php" style="display:inline;">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="action" value="riwayatPinjam">
            <input type="text" name="search" placeholder="Telusuri" value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" class="input-dark" style="width:150px;">
        </form>
        
       
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
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Riwayat Peminjaman -->
    <div class="card" style="flex: 3; box-sizing: border-box;">
        <div style="margin-bottom: 20px;">
            <span class="badge-count">Total Riwayat<br><strong style="font-size: 16px;"><?= count($riwayatList); ?></strong></span>
            <h3 style="margin: 0; font-size: 18px;">riwayat peminjaman</h3>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="color: #aaa; font-size: 13px; text-align: left; border-bottom: 1px solid #444;">
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
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px 10px; font-weight: bold;">
                                <?= htmlspecialchars($r['nama_siswa']); ?>
                                <?php if (!empty($r['kelas'])): ?>
                                    <br><small style="color: #888; font-weight: normal;"><?= htmlspecialchars($r['kelas']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 10px; color: #eee;"><?= htmlspecialchars($r['nama_buku']); ?></td>
                            <td style="padding: 12px 10px; color: #aaa; font-size: 13px;">
                                <?= !empty($r['tgl_pinjam']) ? date('d-m-Y', strtotime($r['tgl_pinjam'])) : '-'; ?>
                            </td>
                            <td style="padding: 12px 10px; color: #aaa; font-size: 13px;">
                                <?= !empty($r['tgl_kembali']) ? date('d-m-Y', strtotime($r['tgl_kembali'])) : '-'; ?>
                            </td>
                            <td style="padding: 12px 10px; font-weight: bold; color: <?= ($r['denda'] > 0) ? '#e74c3c' : '#aaa'; ?>;">
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
                            <td colspan="6" style="text-align: center; color: #888; padding: 20px;">Belum ada riwayat transaksi.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>