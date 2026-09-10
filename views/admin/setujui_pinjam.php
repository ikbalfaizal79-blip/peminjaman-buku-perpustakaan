<div style="display: flex; gap: 20px;">
    <!-- Sidebar Kelola -->
    <div style="width: 220px; background: #232326; padding: 20px; border-radius: 16px; min-height: 400px;">
        <span style="font-size: 11px; color: #aaa; letter-spacing: 1px;">KELOLA</span>
        <div style="margin-top: 15px; display: flex; flex-direction: column; gap: 12px;">
            <a href="index.php?action=setujui_pinjam" class="btn" style="background: #a3a3a3; color: #111; text-align: left; font-weight: bold;">Setujui pinjam</a>
            <a href="index.php?action=akhiri_pinjaman" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Akhiri pinjaman</a>
            <a href="index.php?action=kelola_user" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Kelola User</a>
            <a href="index.php?action=kelola_buku" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Kelola Buku</a>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div style="flex: 1; background: #232326; padding: 25px; border-radius: 16px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: #fff; font-size: 18px;">Persetujuan peminjaman</h3>
            <span style="background: #888; color: #111; padding: 6px 16px; border-radius: 20px; font-weight: bold; font-size: 14px;">
                Total Pengajuan: <?= count($pendingList) ?>
            </span>
        </div>

        <table>
            <thead>
                <tr style="border-bottom: 2px solid #444; color: #ccc;">
                    <th style="padding: 10px;">peminjam</th>
                    <th style="padding: 10px;">Alat / Buku</th>
                    <th style="padding: 10px; text-align: center;">Jumlah</th>
                    <th style="padding: 10px; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pendingList)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: #888; padding: 20px;">Tidak ada pengajuan pinjaman pending.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pendingList as $row): ?>
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 12px; font-size: 16px;"><?= htmlspecialchars($row['peminjam']) ?></td>
                        <td style="padding: 12px; font-size: 16px;"><?= htmlspecialchars($row['alat']) ?></td>
                        <td style="padding: 12px; text-align: center; font-size: 16px;"><?= $row['jumlah'] ?></td>
                        <td style="padding: 12px; text-align: right;">
                            <a href="index.php?action=acc_pinjam&id=<?= $row['id'] ?>" class="btn" style="background: #6c6c75; color: white; padding: 6px 18px; font-size: 12px; border-radius: 12px;">ACC</a>
                            <a href="index.php?action=tolak_pinjam&id=<?= $row['id'] ?>" class="btn" style="background: #4a4a52; color: white; padding: 6px 18px; font-size: 12px; border-radius: 12px;" onclick="return confirm('Tolak peminjaman ini?')">Tolak</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>