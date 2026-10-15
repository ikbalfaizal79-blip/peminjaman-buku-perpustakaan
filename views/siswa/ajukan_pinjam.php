<?php include 'views/layout/header.php'; ?>

<style>
    /* Definisi Variabel Warna untuk Tema Terang & Gelap */
    :root {
        --bg-body: #f8f9fa;
        --bg-card: #ffffff;
        --bg-header: #ffffff;
        --text-main: #333333;
        --text-muted: #6c757d;
        --border-color: #e0e0e0;
        --input-bg: #ffffff;
        --input-border: #ced4da;
        --input-text: #495057;
        --input-placeholder: #adb5bd;
        --input-readonly-bg: #e9ecef;
        --btn-blue-bg: #007bff;
        --btn-blue-hover: #0056b3;
        --shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    [data-theme="dark"] {
        --bg-body: #121212;
        --bg-card: #242424;
        --bg-header: #1e1e1e;
        --text-main: #ffffff;
        --text-muted: #aaa;
        --border-color: #333333;
        --input-bg: #7d7d7d;
        --input-border: transparent;
        --input-text: #ffffff;
        --input-placeholder: #d1d1d1;
        --input-readonly-bg: #444444;
        --btn-blue-bg: #4a4a4a;
        --btn-blue-hover: #666666;
        --shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        font-family: Arial, sans-serif;
        margin: 0;
        transition: background-color 0.3s, color 0.3s;
    }

    /* Styling Header Bar */
    .header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: var(--bg-header);
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 20px;
        transition: background-color 0.3s, border-color 0.3s;
    }

    /* Tombol Switch Tema di Pojok */
    .theme-toggle-btn {
        background-color: var(--bg-card);
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 6px 12px;
        border-radius: 15px;
        cursor: pointer;
        font-size: 13px;
        font-weight: bold;
        box-shadow: var(--shadow);
        transition: background-color 0.2s;
    }
    .theme-toggle-btn:hover {
        opacity: 0.9;
    }

    .modal-card {
        background-color: var(--bg-card);
        padding: 30px;
        border-radius: 20px;
        width: 350px;
        margin: 50px auto;
        text-align: center;
        box-shadow: var(--shadow);
        border: 1px solid var(--border-color);
        transition: background-color 0.3s, border-color 0.3s;
    }

    /* Styling Input Kustom Menggunakan Variabel */
    .input-dark {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--input-text);
        padding: 10px 12px;
        border-radius: 12px;
        width: 100%;
        box-sizing: border-box;
        outline: none;
        font-size: 14px;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }
    .input-dark::placeholder {
        color: var(--input-placeholder);
    }
    .input-dark:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Tombol Umum */
    .btn {
        padding: 6px 14px;
        border-radius: 15px;
        text-decoration: none;
        font-weight: bold;
        display: inline-block;
        font-size: 13px;
        cursor: pointer;
        border: none;
        transition: opacity 0.2s;
    }
    .btn:hover {
        opacity: 0.85;
    }
    .btn-blue {
        background-color: var(--btn-blue-bg);
        color: white;
    }
    .btn-red {
        background-color: #dc3545;
        color: white;
    }
</style>

<!-- Header Bar -->
<div class="header-bar">
    <div style="color: var(--text-main); font-weight: 500;">Hallo <?= htmlspecialchars($_SESSION['user']['nama']); ?> (siswa)</div>
    <div style="display: flex; align-items: center; gap: 10px;">
        <!-- Tombol Ganti Tema -->
        <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>
        
        <a href="index.php?page=siswa&action=dashboard" class="btn btn-blue">Kembali</a>
        <a href="index.php?page=logout" class="btn btn-red">Logout</a>
    </div>
</div>

<div class="modal-card">
    <div style="font-size: 40px; margin-bottom: 10px;">📚</div>
    <h3 style="margin-top: 0; margin-bottom: 20px; color: var(--text-main);">Form Ajukan Pinjam</h3>

    <form method="POST" action="index.php?page=siswa&action=prosesPinjam">
        <input type="hidden" name="id_buku" value="<?= htmlspecialchars($buku['id_buku']); ?>">

        <div style="text-align: left; margin-bottom: 15px;">
            <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 5px;">Nama Buku:</label>
            <input type="text" value="<?= htmlspecialchars($buku['nama_buku']); ?>" class="input-dark" readonly style="background-color: var(--input-readonly-bg); cursor: not-allowed;">
        </div>

        <div style="text-align: left; margin-bottom: 15px;">
            <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 5px;">Jumlah Pinjam:</label>
            <input type="number" name="jumlah" min="1" max="<?= $buku['stok']; ?>" value="1" class="input-dark" required>
        </div>

        <div style="text-align: left; margin-bottom: 20px;">
            <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 5px;">Tanggal Pengembalian:</label>
            <input type="date" name="tgl_kembali" class="input-dark" required>
        </div>

        <button type="submit" class="btn btn-blue" style="width: 100%; border-radius: 20px; padding: 10px; font-size: 14px;">AJUKAN PINJAMAN</button>
    </form>
</div>

<?php include 'views/layout/footer.php'; ?>

<!-- Script untuk Mengatur & Menyimpan Preferensi Tema -->
<script>
    const htmlElement = document.documentElement;
    const themeToggleBtn = document.getElementById('themeToggle');

    // Cek LocalStorage saat halaman dimuat
    const savedTheme = localStorage.getItem('theme') || 'dark'; // Default diset dark sesuai aslinya
    if (savedTheme === 'light') {
        htmlElement.setAttribute('data-theme', 'light');
        themeToggleBtn.textContent = '🌙 Dark Mode';
    } else {
        htmlElement.setAttribute('data-theme', 'dark');
        themeToggleBtn.textContent = '☀️ Light Mode';
    }

    // Fungsi untuk mengganti tema
    function toggleTheme() {
        const currentTheme = htmlElement.getAttribute('data-theme');
        if (currentTheme === 'dark') {
            htmlElement.setAttribute('data-theme', 'light');
            localStorage.setItem('theme', 'light');
            themeToggleBtn.textContent = '🌙 Dark Mode';
        } else {
            htmlElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
            themeToggleBtn.textContent = '☀️ Light Mode';
        }
    }
</script>