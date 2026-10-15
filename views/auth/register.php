<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Perpustakaan</title>
    <style>
        /* Definisi Variabel Warna untuk Tema Terang & Gelap */
        :root {
            --bg-body: #f8f9fa;
            --bg-card: #ffffff;
            --text-main: #333333;
            --text-muted: #6c757d;
            --border-color: #e0e0e0;
            --input-bg: #ffffff;
            --input-border: #ced4da;
            --input-text: #495057;
            --input-placeholder: #adb5bd;
            --btn-blue-bg: #007bff;
            --btn-blue-hover: #0056b3;
            --link-color: #007bff;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        [data-theme="dark"] {
            --bg-body: #121212;
            --bg-card: #242424;
            --text-main: #ffffff;
            --text-muted: #aaa;
            --border-color: #333333;
            --input-bg: #7d7d7d;
            --input-border: transparent;
            --input-text: #ffffff;
            --input-placeholder: #d1d1d1;
            --btn-blue-bg: #4a4a4a;
            --btn-blue-hover: #666666;
            --link-color: #3498db;
            --shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Tombol Switch Tema di Pojok */
        .theme-toggle-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .theme-toggle-btn {
            background-color: var(--bg-card);
            color: var(--text-main);
            border: 1px solid var(--border-color);
            padding: 8px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            box-shadow: var(--shadow);
            transition: background-color 0.2s;
        }
        .theme-toggle-btn:hover {
            opacity: 0.9;
        }

        /* Styling Input Kustom Menggunakan Variabel */
        .input-dark {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-text);
            padding: 10px;
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

        /* Tombol Biru (Daftar) */
        .btn-blue {
            background-color: var(--btn-blue-bg);
            color: white;
            border: 1px solid var(--border-color);
            padding: 10px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            font-size: 14px;
            transition: background-color 0.2s;
        }
        .btn-blue:hover {
            background-color: var(--btn-blue-hover);
        }

        /* Card Container */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: background-color 0.3s, border-color 0.3s;
        }
    </style>
</head>
<body>

<?php include 'views/layout/header.php'; ?>

<!-- Tombol Ganti Tema -->
<div class="theme-toggle-container">
    <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>
</div>

<div class="card" style="max-width: 400px; margin: 50px auto; padding: 30px; text-align: center;">
    <div style="font-size: 40px; margin-bottom: 10px;">📖</div>
    <h2 style="margin-bottom: 20px; color: var(--text-main);">Daftar Akun Siswa</h2>

    <?php if (isset($error)): ?>
        <p style="background-color: #e74c3c; color: white; padding: 8px 12px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=register">
        <input type="text" name="nama" placeholder="Nama Lengkap" class="input-dark" required style="margin-bottom: 15px;">
        
        <input type="email" name="email" placeholder="Email" class="input-dark" required style="margin-bottom: 15px;">
        
        <input type="text" name="nis" placeholder="NIS (Nomor Induk Siswa)" class="input-dark" required style="margin-bottom: 15px;">
        
        <input type="text" name="kelas" placeholder="Kelas (contoh: XI RPL 1)" class="input-dark" required style="margin-bottom: 15px;">
        
        <input type="password" name="password" placeholder="Password" class="input-dark" required style="margin-bottom: 20px;">

        <button type="submit" class="btn btn-blue">DAFTAR</button>
    </form>

    <p style="margin-top: 20px; font-size: 14px; color: var(--text-muted);">
        Sudah punya akun? <a href="index.php?page=login" style="color: var(--link-color); text-decoration: none;">Login di sini</a>
    </p>
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

</body>
</html>