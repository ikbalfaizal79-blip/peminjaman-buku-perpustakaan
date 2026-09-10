<div style="display: flex; gap: 20px;">
    <!-- Sidebar Kelola -->
    <div style="width: 220px; background: #232326; padding: 20px; border-radius: 16px; min-height: 400px;">
        <span style="font-size: 11px; color: #aaa; letter-spacing: 1px;">KELOLA</span>
        <div style="margin-top: 15px; display: flex; flex-direction: column; gap: 12px;">
            <a href="index.php?action=setujui_pinjam" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Setujui pinjam</a>
            <a href="index.php?action=akhiri_pinjaman" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Akhiri pinjaman</a>
            <a href="index.php?action=kelola_user" class="btn" style="background: #3d3d3d; color: #fff; text-align: left;">Kelola User</a>
            <a href="index.php?action=kelola_buku" class="btn" style="background: #a3a3a3; color: #111; text-align: left; font-weight: bold;">Kelola Buku</a>
        </div>
    </div>

    <!-- Main Content Panel -->
    <div style="flex: 1; background: #232326; padding: 25px; border-radius: 16px; position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <table style="width: auto; border: none;">
                <thead>
                    <tr style="color: #ccc;">
                        <th style="padding-right: 40px;">nama</th>
                        <th style="padding-right: 40px;">kategori</th>
                        <th style="padding-right: 40px;">stok</th>
                    </tr>
                </thead>
            </table>
            <span style="background: #888; color: #111; padding: 6px 16px; border-radius: 20px; font-weight: bold; font-size: 14px;">
                Total Barang: <?= count($bukuList) ?>
            </span>
        </div>

        <table>
            <tbody>
                <?php foreach ($bukuList as $b): ?>
                <tr style="border-bottom: 1px solid #333;">
                    <td style="padding: 12px; font-size: 16px; width: 30%;"><?= htmlspecialchars($b['nama_buku']) ?></td>
                    <td style="padding: 12px; font-size: 16px; color: #ccc; width: 30%;"><?= htmlspecialchars($b['nama_kategori']) ?></td>
                    <td style="padding: 12px; font-size: 16px; width: 20%;"><?= $b['stok'] ?></td>
                    <td style="padding: 12px; text-align: right; width: 20%;">
                        <button class="btn" style="background: #555; color: white; padding: 6px 16px; border-radius: 12px; margin-right: 5px;">Edit</button>
                        <button class="btn" style="background: transparent; color: #aaa; border: none; font-size: 16px;">🗑</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Link Tambah Buku Modal Trigger -->
        <div style="margin-top: 25px;">
            <a href="javascript:void(0)" onclick="document.getElementById('modalBuku').style.display='block'" style="color: #3897f0; text-decoration: none; font-weight: bold; font-size: 14px;">+ Tambah Alat / Buku</a>
        </div>
    </div>
</div>

<!-- Modal Dialog Tambah Buku -->
<div id="modalBuku" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.7); z-index:99;">
    <div style="background-color: #232326; border-radius: 20px; padding: 30px; width: 320px; margin: 10% auto; text-align: center; position: relative;">
        <span onclick="document.getElementById('modalBuku').style.display='none'" style="position: absolute; right: 20px; top: 15px; cursor: pointer; color: #aaa; font-weight: bold;">✕</span>
        
        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" style="margin-bottom: 10px;">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>

        <h3 style="color: #fff; margin: 0 0 20px 0;">Tambah Buku</h3>

        <form action="index.php?action=tambah_buku" method="POST">
            <input type="text" name="nama" placeholder="Nama Buku" required style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: #aeaeae; margin-bottom: 10px; box-sizing: border-box;">
            
            <select name="kategori_id" required style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: #aeaeae; margin-bottom: 10px; box-sizing: border-box;">
                <option value="">Pilih Kategori</option>
                <?php foreach ($kategoriList as $k): ?>
                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="stok" placeholder="Stok" min="1" required style="width: 100%; padding: 12px; border-radius: 10px; border: none; background: #aeaeae; margin-bottom: 20px; box-sizing: border-box;">
            
            <button type="submit" class="btn" style="background: #555; color: white; width: 100%; border-radius: 20px; padding: 10px; font-weight: bold;">TAMBAH</button>
        </form>
    </div>
</div>