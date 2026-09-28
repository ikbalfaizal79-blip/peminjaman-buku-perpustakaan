<?php include 'views/layout/header.php'; ?>

<style>
    /* Definisi Variabel Warna untuk Tema Terang & Gelap */
    :root {
        --bg-body: #f8f9fa;
        --bg-card: #ffffff;
        --bg-header: #ffffff;
        --text-main: #333333;
        --text-muted: #6c757d;
        --text-heading: #212529;
        --border-color: #e0e0e0;
        --input-bg: #ffffff;
        --input-border: #ced4da;
        --input-text: #495057;
        --sidebar-bg: #f1f3f5;
        --sidebar-hover: #e2e6ea;
        --sidebar-text: #495057;
        --sidebar-active-bg: #007bff;
        --sidebar-active-text: #ffffff;
        --table-border: #e9ecef;
        --table-header-border: #dee2e6;
        --modal-bg: rgba(0, 0, 0, 0.5);
    }

    [data-theme="dark"] {
        --bg-body: #121212;
        --bg-card: #1e1e1e;
        --bg-header: #1e1e1e;
        --text-main: #e0e0e0;
        --text-muted: #aaa;
        --text-heading: #ffffff;
        --border-color: #333333;
        --input-bg: #2d2d2d;
        --input-border: #444444;
        --input-text: #ffffff;
        --sidebar-bg: #252525;
        --sidebar-hover: #333333;
        --sidebar-text: #cccccc;
        --sidebar-active-bg: #444444;
        --sidebar-active-text: #ffffff;
        --table-border: #333333;
        --table-header-border: #444444;
        --modal-bg: rgba(0, 0, 0, 0.7);
    }

    /* Styling Dasar Menggunakan Variabel */
    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        transition: background-color 0.3s, color 0.3s;
    }

    .table-container {
        margin-top: 15px;
    }
    
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
        background-color: var(--sidebar-bg);
        color: var(--sidebar-text);
        text-decoration: none;
        text-align: center;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        box-sizing: border-box;
        transition: background-color 0.2s, transform 0.1s;
    }
    .btn-sidebar:hover {
        background-color: var(--sidebar-hover);
        color: var(--text-heading);
    }
    .btn-sidebar.active {
        background-color: var(--sidebar-active-bg);
        color: var(--sidebar-active-text);
        font-weight: bold;
    }

    /* Kartu / Container */
    .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Input */
    .input-dark, input[type="text"], input[type="number"], select {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--input-text);
        padding: 6px 10px;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .input-dark:focus, input[type="text"]:focus, input[type="number"]:focus, select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Tombol Utama */
    .btn-blue {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .btn-blue:hover {
        background-color: #0056b3;
    }
    .btn-red {
        background-color: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
        border: none;
        cursor: pointer;
        display: inline-block;
        text-align: center;
    }
    .btn-red:hover {
        background-color: #c82333;
    }

    /* Tombol Switch Tema */
    .theme-toggle-btn {
        background-color: var(--sidebar-bg);
        color: var(--text-main);
        border: 1px solid var(--input-border);
        padding: 6px 12px;
        border-radius: 15px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        transition: background-color 0.2s;
    }
    .theme-toggle-btn:hover {
        background-color: var(--sidebar-hover);
    }
</style>

<!-- Header Bar -->
<div class="header-bar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: var(--bg-header); border-bottom: 1px solid var(--border-color); margin-bottom: 20px;">
    <div style="font-weight: 500; color: var(--text-main);">Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (admin)</div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Tombol Ganti Tema -->
        <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>

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

<h2 style="text-align:center; margin-bottom: 30px; color: var(--text-heading);">Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start; padding: 0 20px;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 200px; padding: 20px; box-sizing: border-box;">
        <p style="color: var(--text-muted); margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; font-weight: bold;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar active">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Content Utama Kelola Buku -->
    <div class="card" style="flex: 3; padding: 20px; box-sizing: border-box;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 18px; color: var(--text-heading);">Daftar Buku</h3>
            <button onclick="openModalTambah()" class="btn btn-blue" style="border-radius: 20px; padding: 8px 16px;">+ Tambah Buku</button>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="color: var(--text-muted); font-size: 14px; text-align: left; border-bottom: 2px solid var(--table-header-border);">
                        <th style="padding: 10px;">Cover</th>
                        <th style="padding: 10px;">Nama Buku</th>
                        <th style="padding: 10px;">Kategori</th>
                        <th style="padding: 10px;">Stok</th>
                        <th style="padding: 10px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($bukuList)): ?>
                        <?php foreach ($bukuList as $b): ?>
                        <tr style="border-bottom: 1px solid var(--table-border);">
                            <td style="padding: 10px;">
                                <?php if (!empty($b['gambar']) && file_exists('uploads/' . $b['gambar'])): ?>
                                    <img src="uploads/<?= htmlspecialchars($b['gambar']); ?>" alt="Cover" style="width: 40px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <div style="width: 40px; height: 50px; background: var(--input-bg); border: 1px solid var(--input-border); border-radius: 4px; display: flex; align-items: center; justify-content: center; font-size: 16px;">📘</div>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 10px; font-weight: bold; color: var(--text-heading);"><?= htmlspecialchars($b['nama_buku']); ?></td>
                            <td style="padding: 12px 10px; color: var(--text-muted);"><?= htmlspecialchars($b['nama_kategori'] ?? '-'); ?></td>
                            <td style="padding: 12px 10px; color: var(--text-main);"><?= $b['stok']; ?></td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <button onclick="openModalEdit(<?= $b['id_buku']; ?>, '<?= htmlspecialchars($b['nama_buku'], ENT_QUOTES); ?>', <?= $b['id_kategori'] ?? 0; ?>, <?= $b['stok']; ?>)" class="btn btn-blue" style="padding: 4px 10px; font-size: 12px; margin-right: 5px; border-radius: 4px;">Edit</button>
                                <a href="index.php?page=admin&action=hapusBuku&id=<?= $b['id_buku']; ?>" class="btn btn-red" style="padding: 4px 10px; font-size: 12px;" onclick="return confirm('Hapus buku ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 25px;">Belum ada data buku.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Buku -->
<div id="modalTambah" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:var(--modal-bg); justify-content:center; align-items:center; z-index:999;">
    <div class="card" style="width: 400px; position:relative; padding: 20px;">
        <span onclick="closeModalTambah()" style="position:absolute; right:15px; top:15px; cursor:pointer; color:var(--text-muted); font-size:20px;">&times;</span>
        <h3 style="margin-top:0; margin-bottom: 20px; text-align:center; color: var(--text-heading);">Tambah Buku</h3>
        <form method="POST" action="index.php?page=admin&action=tambahBuku" enctype="multipart/form-data">
            <input type="text" name="nama_buku" placeholder="Nama Buku" class="input-dark" required style="width:100%; margin-bottom: 12px; box-sizing:border-box;">
            
            <select name="id_kategori" class="input-dark" required style="width:100%; margin-bottom: 12px; box-sizing:border-box;">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategoriList as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>"><?= htmlspecialchars($k['nama_kategori']); ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="stok" placeholder="Jumlah Stok" min="1" class="input-dark" required style="width:100%; margin-bottom: 12px; box-sizing:border-box;">
            
            <div style="text-align: left; margin-bottom: 15px;">
                <label style="color: var(--text-muted); font-size: 12px; display:block; margin-bottom: 5px;">Cover Buku (Gambar):</label>
                <input type="file" name="gambar" accept="image/*" class="input-dark" style="width:100%; box-sizing:border-box;">
            </div>

            <button type="submit" class="btn btn-blue" style="width: 100%; border-radius: 20px; padding: 10px;">TAMBAH BUKU</button>
        </form>
    </div>
</div>

<!-- Modal Edit Buku -->
<div id="modalEdit" class="modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:var(--modal-bg); justify-content:center; align-items:center; z-index:999;">
    <div class="card" style="width: 400px; position:relative; padding: 20px;">
        <span onclick="closeModalEdit()" style="position:absolute; right:15px; top:15px; cursor:pointer; color:var(--text-muted); font-size:20px;">&times;</span>
        <h3 style="margin-top:0; margin-bottom: 20px; text-align:center; color: var(--text-heading);">Edit Buku</h3>
        <form method="POST" action="index.php?page=admin&action=editBuku" enctype="multipart/form-data">
            <input type="hidden" name="id_buku" id="edit_id_buku">
            
            <input type="text" name="nama_buku" id="edit_nama_buku" placeholder="Nama Buku" class="input-dark" required style="width:100%; margin-bottom: 12px; box-sizing:border-box;">
            
            <select name="id_kategori" id="edit_id_kategori" class="input-dark" required style="width:100%; margin-bottom: 12px; box-sizing:border-box;">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($kategoriList as $k): ?>
                    <option value="<?= $k['id_kategori']; ?>"><?= htmlspecialchars($k['nama_kategori']); ?></option>
                <?php endforeach; ?>
            </select>

            <input type="number" name="stok" id="edit_stok" placeholder="Jumlah Stok" min="1" class="input-dark" required style="width:100%; margin-bottom: 12px; box-sizing:border-box;">

            <div style="text-align: left; margin-bottom: 15px;">
                <label style="color: var(--text-muted); font-size: 12px; display:block; margin-bottom: 5px;">Ganti Cover Buku (Opsional):</label>
                <input type="file" name="gambar" accept="image/*" class="input-dark" style="width:100%; box-sizing:border-box;">
            </div>

            <button type="submit" class="btn btn-blue" style="width: 100%; border-radius: 20px; padding: 10px;">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</div>

<script>
    const htmlElement = document.documentElement;
    const themeToggleBtn = document.getElementById('themeToggle');

    // Cek LocalStorage saat halaman dimuat agar preferensi tema tetap terjaga
    const savedTheme = localStorage.getItem('theme') || 'light';
    if (savedTheme === 'dark') {
        htmlElement.setAttribute('data-theme', 'dark');
        themeToggleBtn.textContent = '☀️ Light Mode';
    }

    // Fungsi untuk mengganti tema
    function toggleTheme() {
        const currentTheme = htmlElement.getAttribute('data-theme');
        if (currentTheme === 'dark') {
            htmlElement.removeAttribute('data-theme');
            localStorage.setItem('theme', 'light');
            themeToggleBtn.textContent = '🌙 Dark Mode';
        } else {
            htmlElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeToggleBtn.textContent = '☀️ Light Mode';
        }
    }

    // Fungsi Modals
    function openModalTambah() {
        document.getElementById('modalTambah').style.display = 'flex';
    }
    function closeModalTambah() {
        document.getElementById('modalTambah').style.display = 'none';
    }
    function openModalEdit(id, nama, idKategori, stok) {
        document.getElementById('edit_id_buku').value = id;
        document.getElementById('edit_nama_buku').value = nama;
        document.getElementById('edit_id_kategori').value = idKategori;
        document.getElementById('edit_stok').value = stok;
        document.getElementById('modalEdit').style.display = 'flex';
    }
    function closeModalEdit() {
        document.getElementById('modalEdit').style.display = 'none';
    }
</script>

<?php include 'views/layout/footer.php'; ?>