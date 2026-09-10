<div style="display: flex; gap: 20px;">
    <!-- Sidebar Kelola -->
    <div style="width: 220px; background: #232326; padding: 20px; border-radius: 16px; min-height: 400px;">
        <span style="font-size: 11px; color: #aaa; letter-spacing: 1px;">KELOLA</span>
        <div style="margin-top: 15px; display: flex; flex-direction: column; gap: 12px;">
            <a href="index.php?action=setujui_pinjam" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Setujui pinjam</a>
            <a href="index.php?action=akhiri_pinjaman" class="btn" style="background: #a3a3a3; color: #111; text-align: left; font-weight: bold;">Akhiri pinjaman</a>
            <a href="index.php?action=kelola_user" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Kelola User</a>
            <a href="index.php?action=kelola_buku" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Kelola Buku</a>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div style="flex: 1; display: flex; flex-direction: column; gap: 15px;">
        <!-- Card Counter Stats Header -->
        <div style="display: flex; gap: 15px; justify-content: space-between;">
            <div style="flex: 1; background: #888; color: #111; padding: 15px; border-radius: 16px; text-align: center;">
                <span style="font-size: 12px; font-weight: bold;">Total</span>
                <h2 style="margin: 5px 0 0 0; font-size: 28px;"><?= $statistik['total'] ?></h2>
            </div>
            <div style="flex: 1; background: #888; color: #111; padding: 15px; border-radius: 16px; text-align: center;">
                <span style="font-size: 12px; font-weight: bold;">Sedang di pinjam</span>
                <h2 style="margin: 5px 0 0 0; font-size: 28px;"><?= $statistik['dipinjam'] ?></h2>
            </div>
            <div style="flex: 1; background: #888; color: #111; padding: 15px; border-radius: 16px; text-align: center;">
                <span style="font-size: 12px; font-weight: bold;">Kembali</span>
                <h2 style="margin: 5px 0 0 0; font-size: 28px;"><?= $statistik['kembali'] ?></h2>
            </div>
        </div>

        <div style="background: #232326; padding: 25px; border-radius: 16px; flex: 1;">
            <table>
                <thead>
                    <tr style="border-bottom: 2px solid #444; color: #ccc;">
                        <th style="padding: 10px;">peminjam</th>
                        <th style="padding: 10px;">Alat</th>
                        <th style="padding: 10px; text-align: center;">Jumlah</th>
                        <th style="padding: 10px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($dipinjamList)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center; color: #888; padding: 20px;">Tidak ada transaksi buku yang sedang dipinjam.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($dipinjamList as $row): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px; font-size: 16px;"><?= htmlspecialchars($row['peminjam']) ?></td>
                            <td style="padding: 12px; font-size: 16px;"><?= htmlspecialchars($row['alat']) ?></td>
                            <td style="padding: 12px; text-align: center; font-size: 16px;"><?= $row['jumlah'] ?></td>
                            <td style="padding: 12px; text-align: right;">
                                <a href="index.php?action=proses_pengembalian&id=<?= $row['id'] ?>" class="btn" style="background: #55555d; color: white; padding: 8px 20px; font-size: 13px; border-radius: 14px;" onclick="return confirm('Proses pengembalian buku ini?')">Akhiri</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>