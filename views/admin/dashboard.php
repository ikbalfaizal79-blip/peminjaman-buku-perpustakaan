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
        margin-left: 5px;
    }
    .btn-approve { background-color: #27ae60; }
    .btn-reject { background-color: #e74c3c; }
    .btn-approve:hover { background-color: #219150; }
    .btn-reject:hover { background-color: #c0392b; }

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

<!-- Header Bar -->
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

<h2 style="text-align:center; margin-bottom: 30px;">Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 200px; padding: 20px; box-sizing: border-box;">
        <p style="color: #aaa; margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar active">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Data Persetujuan Peminjaman -->
    <div class="card" style="flex: 3; box-sizing: border-box;">
        <h3 style="margin-top: 0; font-size: 18px;">Persetujuan peminjaman</h3>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="color: #aaa; font-size: 14px; text-align: left; border-bottom: 1px solid #444;">
                        <th style="padding: 10px;">Peminjam</th>
                        <th style="padding: 10px;">Alat / Buku</th>
                        <th style="padding: 10px;">Jumlah</th>
                        <th style="padding: 10px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pendingList)): ?>
                        <?php foreach ($pendingList as $p): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px 10px; font-weight: bold;"><?= htmlspecialchars($p['nama_siswa']); ?></td>
                            <td style="padding: 12px 10px;"><?= htmlspecialchars($p['nama_buku']); ?></td>
                            <td style="padding: 12px 10px;"><?= $p['jumlah']; ?></td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <a href="index.php?page=admin&action=setujuiPinjaman&id=<?= $p['id_pinjam']; ?>" class="btn-action btn-approve" onclick="return confirm('Setujui peminjaman ini?');">Setujui</a>
                                <a href="index.php?page=admin&action=tolakPinjaman&id=<?= $p['id_pinjam']; ?>" class="btn-action btn-reject" onclick="return confirm('Tolak peminjaman ini?');">Tolak</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #888; padding: 20px;">Tidak ada pengajuan peminjaman yang menunggu persetujuan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>