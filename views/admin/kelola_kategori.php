<?php include 'views/layout/header.php'; ?>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background-color: #242424;
        padding: 30px;
        border-radius: 20px;
        width: 350px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        position: relative;
    }
    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        color: #aaa;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }
    .close-btn:hover { color: #fff; }
    
    .badge-count {
        background-color: #7d7d7d;
        color: #fff;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        float: right;
    }

    /* Styling Tombol Aksi Tabel */
    .btn-action {
        padding: 5px 15px;
        border-radius: 15px;
        text-decoration: none;
        color: white;
        font-size: 13px;
        cursor: pointer;
        display: inline-block;
        text-align: center;
    }
    .btn-edit { 
        background-color: #3498db; 
        border: none; 
        margin-right: 5px; 
    }
    .btn-delete { 
        background-color: #e74c3c; 
        border: none; 
        cursor: pointer; 
        color: #fff; 
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
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar active">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Data Kategori -->
    <div class="card" style="flex: 3; box-sizing: border-box;">
        <!-- Header Bagian Kartu (Judul & Tombol Tambah di Kanan Atas) -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h3 style="margin: 0; font-size: 18px; text-transform: capitalize;">Kelola Kategori</h3>
            </div>
            <div>
                <a href="#" onclick="openModalTambah()" class="btn btn-blue" style="border-radius: 15px; font-size: 13px; padding: 6px 15px; text-decoration: none;">+ Tambah Kategori</a>
            </div>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <?php if (!empty($kategoriList)): ?>
                        <?php foreach ($kategoriList as $k): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px 10px; font-weight: bold;">
                                <?= htmlspecialchars($k['nama_kategori']); ?>
                            </td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <button type="button" class="btn-action btn-edit" onclick="openModalEdit(<?= $k['id_kategori']; ?>, '<?= htmlspecialchars($k['nama_kategori'], ENT_QUOTES); ?>')">Edit</button>
                                <a href="index.php?page=admin&action=hapusKategori&id=<?= $k['id_kategori']; ?>" class="btn-action btn-delete" onclick="return confirm('Hapus kategori ini? Buku yang terhubung mungkin akan kehilangan referensi kategori.');">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" style="text-align: center; color: #888; padding: 20px;">Belum ada data kategori.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModalTambah()">&times;</span>
        <div style="font-size: 40px; margin-bottom: 10px;">🏷️</div>
        <h3 style="margin-top: 0; margin-bottom: 20px;">Tambah Kategori</h3>

        <form method="POST" action="index.php?page=admin&action=tambahKategori">
            <input type="text" name="nama_kategori" placeholder="Nama Kategori" class="input-dark" required style="width: 100%; margin-bottom: 15px; box-sizing: border-box;">
            <button type="submit" class="btn btn-blue" style="width: 100%; border-radius: 20px; padding: 10px;">SIMPAN</button>
        </form>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModalEdit()">&times;</span>
        <div style="font-size: 40px; margin-bottom: 10px;">✏️</div>
        <h3 style="margin-top: 0; margin-bottom: 20px;">Edit Kategori</h3>

        <form method="POST" action="index.php?page=admin&action=editKategori">
            <input type="hidden" name="id_kategori" id="edit_id_kategori">
            <input type="text" name="nama_kategori" id="edit_nama_kategori" placeholder="Nama Kategori" class="input-dark" required style="width: 100%; margin-bottom: 15px; box-sizing: border-box;">
            <button type="submit" class="btn btn-blue" style="width: 100%; border-radius: 20px; padding: 10px;">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</div>

<script>
    function openModalTambah() {
        document.getElementById('modalTambah').style.display = 'flex';
    }
    function closeModalTambah() {
        document.getElementById('modalTambah').style.display = 'none';
    }

    function openModalEdit(id, nama) {
        document.getElementById('edit_id_kategori').value = id;
        document.getElementById('edit_nama_kategori').value = nama;
        document.getElementById('modalEdit').style.display = 'flex';
    }
    function closeModalEdit() {
        document.getElementById('modalEdit').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('modalTambah')) closeModalTambah();
        if (event.target == document.getElementById('modalEdit')) closeModalEdit();
    }
</script>

<?php include 'views/layout/footer.php'; ?>