<?php include 'views/layout/header.php'; ?>

<style>
    .modal-card {
        background-color: #242424;
        padding: 30px;
        border-radius: 20px;
        width: 350px;
        margin: 50px auto;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
    }
</style>

<!-- Header Bar -->
<div class="header-bar">
    <div>Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (siswa)</div>
    <div>
        <a href="index.php?page=siswa&action=dashboard" class="btn btn-blue" style="margin-right: 10px;">Kembali</a>
        <a href="index.php?page=logout" class="btn btn-red">Logout</a>
    </div>
</div>

<div class="modal-card">
    <div style="font-size: 40px; margin-bottom: 10px;">📚</div>
    <h3 style="margin-top: 0; margin-bottom: 20px;">Form Ajukan Pinjam</h3>

    <form method="POST" action="index.php?page=siswa&action=prosesPinjam">
        <input type="hidden" name="id_buku" value="<?= htmlspecialchars($buku['id_buku']); ?>">

        <div style="text-align: left; margin-bottom: 15px;">
            <label style="color: #aaa; font-size: 12px;">Nama Buku:</label>
            <input type="text" value="<?= htmlspecialchars($buku['nama_buku']); ?>" class="input-dark" readonly style="background-color: #444; cursor: not-allowed;">
        </div>

        <div style="text-align: left; margin-bottom: 15px;">
            <label style="color: #aaa; font-size: 12px;">Jumlah Pinjam:</label>
            <input type="number" name="jumlah" min="1" max="<?= $buku['stok']; ?>" value="1" class="input-dark" required>
        </div>

        <div style="text-align: left; margin-bottom: 20px;">
            <label style="color: #aaa; font-size: 12px;">Tanggal Pengembalian:</label>
            <input type="date" name="tgl_kembali" class="input-dark" required>
        </div>

        <button type="submit" class="btn btn-blue" style="width: 100%; border-radius: 20px; padding: 10px;">AJUKAN PINJAMAN</button>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>