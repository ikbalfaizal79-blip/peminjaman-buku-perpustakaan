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
        --modal-bg: #ffffff;
        --badge-count-bg: #6c757d;
        --badge-count-text: #fff;
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
        --modal-bg: #1e1e1e;
        --badge-count-bg: #3a3a3a;
        --badge-count-text: #ffffff;
    }

    /* Styling Dasar Menggunakan Variabel */
    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        transition: background-color 0.3s, color 0.3s;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        justify-content: center;
        align-items: center;
    }
    .modal-content {
        background-color: var(--modal-bg);
        color: var(--text-main);
        padding: 30px;
        border-radius: 8px;
        width: 380px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        position: relative;
        border: 1px solid var(--border-color);
    }
    .close-btn {
        position: absolute;
        top: 15px;
        right: 20px;
        color: var(--text-muted);
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }
    .close-btn:hover { color: var(--text-heading); }
    
    .badge-count {
        background-color: var(--badge-count-bg);
        color: var(--badge-count-text);
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        float: right;
    }

    /* Kartu / Container */
    .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* Input & Select */
    .input-dark, input[type="text"], input[type="email"], input[type="password"], select {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--input-text);
        padding: 8px 12px;
        border-radius: 4px;
        width: 100%;
        margin-bottom: 12px;
        box-sizing: border-box;
    }
    .input-dark:focus, input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus, select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Tombol Utama */
    .btn-blue {
        background-color: #007bff;
        color: white;
        border: none;
    }
    .btn-blue:hover {
        background-color: #0056b3;
        color: white;
    }
    .btn-red {
        background-color: #dc3545;
        color: white;
        text-decoration: none;
        border: none;
    }
    .btn-red:hover {
        background-color: #c82333;
        color: white;
    }

    /* Styling Tombol Aksi Tabel */
    .btn-action {
        padding: 5px 15px;
        border-radius: 4px;
        text-decoration: none;
        color: white;
        font-size: 13px;
        cursor: pointer;
        display: inline-block;
        text-align: center;
        font-weight: bold;
    }
    .btn-edit { 
        background-color: #007bff; 
        border: none; 
        margin-right: 5px; 
    }
    .btn-edit:hover { background-color: #0056b3; }
    .btn-delete { 
        background-color: #dc3545; 
        border: none; 
        cursor: pointer; 
        color: #fff; 
        padding: 5px 15px; 
        border-radius: 4px; 
        font-size: 13px; 
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
    }
    .btn-delete:hover { background-color: #c82333; }

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
            <input type="text" name="search" placeholder="Telusuri" value="<?= htmlspecialchars($_GET['search'] ?? ''); ?>" class="input-dark" style="width:150px; margin-bottom:0;">
        </form>
        
        <!-- Tombol Riwayat Peminjaman -->
        <a href="index.php?page=admin&action=riwayatPinjam" class="btn btn-blue" style="border-radius: 15px; font-size: 13px; padding: 6px 12px; text-decoration: none;">📋 Riwayat</a>
        
        <a href="index.php?page=logout" class="btn btn-red" style="padding: 6px 12px; border-radius: 4px; font-size: 13px;">Logout</a>
    </div>
</div>

<h2 style="text-align:center; margin-bottom: 30px; color: var(--text-heading);">📖 Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start; padding: 0 20px;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 200px; padding: 20px; box-sizing: border-box;">
        <p style="color: var(--text-muted); margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase; font-weight: bold;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar active">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Data User -->
    <div class="card" style="flex: 3; padding: 20px; box-sizing: border-box;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h3 style="margin: 0; font-size: 18px; text-transform: capitalize; color: var(--text-heading);">Kelola User</h3>
            </div>
            <!-- Tombol Tambah User di Kanan Atas -->
            <div>
                <a href="#" onclick="openAddModal()" class="btn btn-blue" style="border-radius: 15px; font-size: 13px; padding: 6px 15px; text-decoration: none;">+ Tambah User</a>
            </div>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <?php if (!empty($userList)): ?>
                        <?php foreach ($userList as $u): ?>
                        <tr style="border-bottom: 1px solid var(--table-border);">
                            <td style="padding: 12px 10px; font-weight: bold; width: 25%; color: var(--text-heading);">
                                <?= htmlspecialchars($u['nama']); ?>
                                <?php if (!empty($u['kelas'])): ?>
                                    <br><small style="color: var(--text-muted); font-weight: normal;"><?= htmlspecialchars($u['kelas']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 10px; color: var(--input-text); font-size: 14px;">
                                <?= htmlspecialchars($u['email']); ?>
                                <?php if (!empty($u['nis'])): ?>
                                    | <span style="color: #007bff; font-weight: 500;">NIS: <?= htmlspecialchars($u['nis']); ?></span>
                                <?php endif; ?>
                                <span style="font-size: 12px; color: var(--text-muted);">\(<?= htmlspecialchars($u['role']); ?>\)</span>
                            </td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <button type="button" class="btn-action btn-edit" onclick='openEditModal(<?= json_encode($u); ?>)'>Edit</button>
                                <a href="index.php?page=admin&action=hapusUser&id=<?= $u['id_user']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 25px;">Belum ada data user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div id="modalTambahUser" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeAddModal()">&times;</span>
        <div style="font-size: 40px; margin-bottom: 10px;">👤</div>
        <h3 style="margin-top: 0; margin-bottom: 20px; color: var(--text-heading);">Tambah User</h3>

        <form method="POST" action="index.php?page=admin&action=tambahUser">
            <input type="text" name="nama" placeholder="Nama" class="input-dark" required>
            <input type="email" name="email" placeholder="Email" class="input-dark" required>
            <input type="text" name="nis" placeholder="NIS (Khusus Siswa)" class="input-dark">
            <input type="text" name="kelas" placeholder="Kelas (Khusus Siswa)" class="input-dark">
            <input type="password" name="password" placeholder="Password" class="input-dark" required>
            
            <select name="role" class="input-dark" required>
                <option value="siswa" selected>Siswa</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" class="btn btn-blue" style="width: 100%; margin-top: 10px; border-radius: 20px; padding: 10px; cursor: pointer; font-weight: bold;">TAMBAH</button>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div id="modalEditUser" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <div style="font-size: 40px; margin-bottom: 10px;">✏️</div>
        <h3 style="margin-top: 0; margin-bottom: 20px; color: var(--text-heading);">Edit User</h3>

        <form method="POST" action="index.php?page=admin&action=editUser">
            <input type="hidden" name="id_user" id="edit_id_user">
            
            <input type="text" name="nama" id="edit_nama" placeholder="Nama" class="input-dark" required>
            <input type="email" name="email" id="edit_email" placeholder="Email" class="input-dark" required>
            <input type="text" name="nis" id="edit_nis" placeholder="NIS" class="input-dark">
            <input type="text" name="kelas" id="edit_kelas" placeholder="Kelas" class="input-dark">
            <input type="password" name="password" placeholder="Kosongkan jika tak diubah" class="input-dark">
            
            <select name="role" id="edit_role" class="input-dark" required>
                <option value="siswa">Siswa</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit" class="btn btn-blue" style="width: 100%; margin-top: 10px; border-radius: 20px; padding: 10px; cursor: pointer; font-weight: bold;">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</div>

<script>
    const htmlElement = document.documentElement;
    const themeToggleBtn = document.getElementById('themeToggle');

    // Cek LocalStorage saat halaman dimuat
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

    function openAddModal() {
        document.getElementById('modalTambahUser').style.display = 'flex';
    }
    function closeAddModal() {
        document.getElementById('modalTambahUser').style.display = 'none';
    }

    function openEditModal(user) {
        document.getElementById('edit_id_user').value = user.id_user;
        document.getElementById('edit_nama').value = user.nama;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_nis').value = user.nis ?? '';
        document.getElementById('edit_kelas').value = user.kelas ?? '';
        document.getElementById('edit_role').value = user.role;
        document.getElementById('modalEditUser').style.display = 'flex';
    }
    function closeEditModal() {
        document.getElementById('modalEditUser').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('modalTambahUser')) closeAddModal();
        if (event.target == document.getElementById('modalEditUser')) closeEditModal();
    }
</script>

<?php include 'views/layout/footer.php'; ?>