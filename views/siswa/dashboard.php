<style>
    /* Global Layout & Dark Theme */
    body {
        background-color: #121214 !important;
        color: #e1e1e6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .top-bar {
        background: #1e1e24;
        padding: 15px 25px;
        border-radius: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border: 1px solid #2d2d35;
    }
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
    }
    .card-dark {
        background: #1e1e24;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #2d2d35;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .card-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-top: 0;
        margin-bottom: 20px;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Table Design */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .custom-table th {
        background: #282830;
        color: #a0a0b0;
        padding: 12px 16px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .custom-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #2d2d35;
        font-size: 0.95rem;
    }
    .custom-table tr:last-child td {
        border-bottom: none;
    }
    
    /* Badges & Buttons */
    .badge-stok {
        background: rgba(46, 213, 115, 0.15);
        color: #2ed573;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .badge-empty {
        background: rgba(255, 71, 87, 0.15);
        color: #ff4757;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .badge-status {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-menunggu { background: rgba(255, 171, 0, 0.2); color: #ffab00; }
    .status-dipinjam { background: rgba(46, 213, 115, 0.2); color: #2ed573; }
    .status-ditolak { background: rgba(255, 71, 87, 0.2); color: #ff4757; }
    .status-kembali { background: rgba(108, 117, 125, 0.2); color: #adb5bd; }

    .btn-pinjam {
        background: #3897f0;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-pinjam:hover { background: #287dc9; }
    .btn-pinjam:disabled { background: #444; color: #888; cursor: not-allowed; }
    .btn-logout {
        background: #ff4757;
        color: #fff;
        padding: 8px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Modal Overlay */
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.75);
        backdrop-filter: blur(4px);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999;
    }
    .modal-content {
        background: #23232a;
        width: 380px;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #333340;
    }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 0.85rem; color: #aaa; margin-bottom: 6px; }
    .form-control {
        width: 100%;
        padding: 10px 14px;
        border-radius: 8px;
        border: 1px solid #3a3a48;
        background: #18181c;
        color: #fff;
        box-sizing: border-box;
    }
</style>

<!-- Topbar Header -->
<div class="top-bar">
    <div style="font-weight: 600; font-size: 1.1rem;">
        👋 Selamat datang, <span style="color: #3897f0;"><?= htmlspecialchars($_SESSION['user']['nama'] ?? 'Siswa') ?></span>
    </div>
    <a href="index.php?action=logout" class="btn-logout">Logout</a>
</div>

<!-- Alert Notifikasi -->
<?php if (isset($_SESSION['success_msg'])): ?>
    <div style="background: rgba(46, 213, 115, 0.15); border: 1px solid #2ed573; color: #2ed573; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 500;">
        📌 <?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_msg'])): ?>
    <div style="background: rgba(255, 71, 87, 0.15); border: 1px solid #ff4757; color: #ff4757; padding: 14px 20px; border-radius: 12px; margin-bottom: 20px; font-weight: 500;">
        ⚠️ <?= $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?>
    </div>
<?php endif; ?>

<!-- Main Dashboard Grid -->
<div class="dashboard-grid">
    <!-- Katalog Buku -->
    <div class="card-dark">
        <h3 class="card-title">📚 Katalog Buku Tersedia</h3>
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($buku as $item): ?>
                <tr>
                    <td style="font-weight: 600;"><?= htmlspecialchars($item['nama_buku']) ?></td>
                    <td><span style="color: #aaa;"><?= htmlspecialchars($item['nama_kategori'] ?? 'Umum') ?></span></td>
                    <td>
                        <?php if ($item['stok'] > 0): ?>
                            <span class="badge-stok"><?= $item['stok'] ?> Unit</span>
                        <?php else: ?>
                            <span class="badge-empty">Habis</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <button onclick="openModal(<?= $item['id'] ?>, '<?= htmlspecialchars($item['nama_buku']) ?>', <?= $item['stok'] ?>)" 
                                class="btn-pinjam" <?= $item['stok'] <= 0 ? 'disabled' : '' ?>>
                            <?= $item['stok'] > 0 ? 'Pinjam' : 'Kosong' ?>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Riwayat Peminjaman Saya -->
    <div class="card-dark">
        <h3 class="card-title">🕒 Riwayat Saya</h3>
        <?php if (empty($riwayat)): ?>
            <p style="color: #777; font-size: 0.9rem; text-align: center; margin-top: 30px;">Belum ada riwayat peminjaman.</p>
        <?php else: ?>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <?php foreach ($riwayat as $r): ?>
                    <div style="background: #282830; padding: 14px; border-radius: 10px; border-left: 4px solid #3897f0;">
                        <div style="font-weight: 600; font-size: 0.95rem; color: #fff; margin-bottom: 4px;">
                            <?= htmlspecialchars($r['nama_buku']) ?>
                        </div>
                        <div style="font-size: 0.8rem; color: #aaa; margin-bottom: 8px;">
                            Jumlah: <?= $r['jumlah'] ?> | Tgl: <?= $r['tgl_pinjam'] ?>
                        </div>
                        <div>
                            <span class="badge-status status-<?= strtolower($r['status']) ?>">
                                <?= $r['status'] == 'menunggu' ? '⏳ Menunggu ACC' : $r['status'] ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Dialog Pengajuan -->
<div id="modalPinjam" class="modal-backdrop">
    <div class="modal-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 1.1rem; color: #fff;">Pengajuan Peminjaman</h3>
            <span onclick="closeModal()" style="cursor: pointer; color: #888; font-size: 1.2rem;">&times;</span>
        </div>
        
        <form action="index.php?action=pinjam_buku" method="POST">
            <input type="hidden" name="buku_id" id="buku_id">
            
            <div class="form-group">
                <label>Judul Buku</label>
                <input type="text" id="modal_nama_buku" class="form-control" readonly style="background: #2d2d35; color: #888;">
            </div>

            <div class="form-group">
                <label>Jumlah Pinjam</label>
                <input type="number" name="jumlah" id="modal_jumlah" value="1" min="1" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" value="<?= date('Y-m-d') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Rencana Tanggal Pengembalian</label>
                <input type="date" name="tgl_kembali" class="form-control" required>
            </div>

            <button type="submit" class="btn-pinjam" style="width: 100%; padding: 12px; margin-top: 10px; font-size: 0.95rem;">
                Kirim Pengajuan
            </button>
        </form>
    </div>
</div>

<script>
function openModal(id, nama, stok) {
    document.getElementById('buku_id').value = id;
    document.getElementById('modal_nama_buku').value = nama;
    document.getElementById('modal_jumlah').max = stok;
    document.getElementById('modalPinjam').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalPinjam').style.display = 'none';
}

// Close modal when clicking outside box
window.onclick = function(event) {
    let modal = document.getElementById('modalPinjam');
    if (event.target == modal) {
        closeModal();
    }
}
</script>