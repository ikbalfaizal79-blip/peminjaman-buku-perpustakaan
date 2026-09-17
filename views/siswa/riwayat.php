<?php include 'views/layout/header.php'; ?>

<style>
    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        text-transform: capitalize;
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
    }
    .btn-return:hover { background-color: #d35400; }
</style>

<!-- Header Bar -->
<div class="header-bar">
    <div>Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (siswa)</div>
    <div>
        <a href="index.php?page=siswa&action=dashboard" class="btn btn-blue" style="margin-right: 10px;">Dashboard</a>
        <a href="index.php?page=logout" class="btn btn-red">Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px;">📖 Riwayat Peminjaman Buku</h2>

<div class="card" style="max-width: 950px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <h3 style="margin: 0; font-size: 18px;">Daftar Pinjaman Saya</h3>
    </div>

    <div class="table-container">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="color: #aaa; font-size: 14px; text-align: left; border-bottom: 1px solid #444;">
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
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 12px 10px; font-weight: bold;"><?= htmlspecialchars($r['nama_buku']); ?></td>
                        <td style="padding: 12px 10px;"><?= $r['jumlah']; ?></td>
                        <td style="padding: 12px 10px; color: #aaa;"><?= !empty($r['tgl_pinjam']) ? date('d-m-Y', strtotime($r['tgl_pinjam'])) : '-'; ?></td>
                        <td style="padding: 12px 10px; color: #aaa;"><?= !empty($r['tgl_kembali']) ? date('d-m-Y', strtotime($r['tgl_kembali'])) : '-'; ?></td>
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
                                <span style="color: #666; font-size: 12px;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #888; padding: 20px;">Belum ada riwayat peminjaman.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layout/footer.php'; ?>