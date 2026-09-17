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
    .btn-action {
        padding: 5px 15px;
        border-radius: 15px;
        text-decoration: none;
        color: white;
        font-size: 13px;
        margin-right: 5px;
        cursor: pointer;
    }
    .btn-edit { background-color: #555; border: none; }
    .btn-delete { background-color: transparent; border: none; cursor: pointer; color: #fff; font-size: 16px; }

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

<h2 style="text-align:center; margin-bottom: 30px;">📖 Halaman Admin</h2>

<div style="display: flex; gap: 20px; align-items: flex-start;">
    <!-- Sidebar Menu Kelola -->
    <div class="card" style="flex: 1; min-width: 200px; padding: 20px; box-sizing: border-box;">
        <p style="color: #aaa; margin-top: 0; margin-bottom: 15px; font-size: 12px; letter-spacing: 1px; text-transform: uppercase;">Kelola</p>
        
        <div class="sidebar-menu">
            <a href="index.php?page=admin&action=dashboard" class="btn-sidebar">Setujui pinjam</a>
            <a href="index.php?page=admin&action=akhiriPinjaman" class="btn-sidebar">Akhiri pinjaman</a>
            <a href="index.php?page=admin&action=kelolaUser" class="btn-sidebar active">Kelola User</a>
            <a href="index.php?page=admin&action=kelolaBuku" class="btn-sidebar">Kelola Buku</a>
            <a href="index.php?page=admin&action=kelolaKategori" class="btn-sidebar">Kelola Kategori</a>
        </div>
    </div>

    <!-- Tabel Data User -->
    <div class="card" style="flex: 3; box-sizing: border-box;">
        <div style="margin-bottom: 20px;">
            <span class="badge-count">Total User<br><strong style="font-size: 16px;"><?= count($userList); ?></strong></span>
            <h3 style="margin: 0; font-size: 18px;">kelola user</h3>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    <?php if (!empty($userList)): ?>
                        <?php foreach ($userList as $u): ?>
                        <tr style="border-bottom: 1px solid #333;">
                            <td style="padding: 12px 10px; font-weight: bold; width: 25%;">
                                <?= htmlspecialchars($u['nama']); ?>
                                <?php if (!empty($u['kelas'])): ?>
                                    <br><small style="color: #888; font-weight: normal;"><?= htmlspecialchars($u['kelas']); ?></small>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 12px 10px; color: #aaa; font-size: 14px;">
                                <?= htmlspecialchars($u['email']); ?>
                                <?php if (!empty($u['nis'])): ?>
                                    | <span style="color: #3498db;">NIS: <?= htmlspecialchars($u['nis']); ?></span>
                                <?php endif; ?>
                                <span style="font-size: 12px; color: #666;">(<?= htmlspecialchars($u['role']); ?>)</span>
                            </td>
                            <td style="padding: 12px 10px; text-align: right;">
                                <button type="button" class="btn-action btn-edit" onclick='openEditModal(<?= json_encode($u); ?>)'>Edit</button>
                                <a href="index.php?page=admin&action=hapusUser&id=<?= $u['id_user']; ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?');">🗑️</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #888; padding: 20px;">Belum ada data user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Tambah User -->
        <div style="margin-top: 20px;">
            <a href="#" onclick="openAddModal()" style="color: #3498db; text-decoration: none; font-size: 14px; font-weight: bold;">+ Tambah User</a>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div id="modalTambahUser" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeAddModal()">&times;</span>
        <div style="font-size: 40px; margin-bottom: 10px;">👤</div>
        <h3 style="margin-top: 0; margin-bottom: 20px;">Tambah User</h3>

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

            <button type="submit" class="btn btn-blue" style="width: 100%; margin-top: 10px; border-radius: 20px; padding: 10px;">TAMBAH</button>
        </form>
    </div>
</div>

<!-- Modal Edit User -->
<div id="modalEditUser" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditModal()">&times;</span>
        <div style="font-size: 40px; margin-bottom: 10px;">✏️</div>
        <h3 style="margin-top: 0; margin-bottom: 20px;">Edit User</h3>

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

            <button type="submit" class="btn btn-blue" style="width: 100%; margin-top: 10px; border-radius: 20px; padding: 10px;">SIMPAN PERUBAHAN</button>
        </form>
    </div>
</div>

<script>
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