<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Perpustakaan</title>
    <style>
        /* Definisi Variabel Warna untuk Tema Terang & Gelap */
        :root {
            --bg-body: #f8f9fa;
            --bg-card: #ffffff;
            --text-main: #333333;
            --text-muted: #6c757d;
            --border-color: #e0e0e0;
            --input-bg: #f1f3f5;
            --input-border: #ced4da;
            --input-text: #495057;
            --input-placeholder: #adb5bd;
            --btn-bg: #007bff;
            --btn-hover: #0056b3;
            --btn-border: transparent;
            --link-color: #007bff;
            --shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        [data-theme="dark"] {
            --bg-body: #121212;
            --bg-card: #242424;
            --text-main: #ffffff;
            --text-muted: #d1d1d1;
            --border-color: #333333;
            --input-bg: #7d7d7d;
            --input-border: transparent;
            --input-text: #ffffff;
            --input-placeholder: #d1d1d1;
            --btn-bg: #4a4a4a;
            --btn-hover: #666666;
            --btn-border: #7d7d7d;
            --link-color: #3498db;
            --shadow: 0 4px 15px rgba(0,0,0,0.6);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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

        .login-card {
            background-color: var(--bg-card);
            padding: 30px;
            border-radius: 20px;
            width: 320px;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
            transition: background-color 0.3s, border-color 0.3s;
        }
        .user-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .input-box {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-text);
            padding: 12px 15px;
            border-radius: 12px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
            outline: none;
            transition: background-color 0.3s, color 0.3s;
        }
        .input-box::placeholder {
            color: var(--input-placeholder);
        }
        .btn-submit {
            background-color: var(--btn-bg);
            color: white;
            border: 1px solid var(--btn-border);
            padding: 10px 30px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.2s;
        }
        .btn-submit:hover {
            background-color: var(--btn-hover);
        }
        .links {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .links a {
            color: var(--link-color);
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .alert-error {
            background-color: #e74c3c;
            color: white;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<!-- Tombol Ganti Tema -->
<div class="theme-toggle-container">
    <button id="themeToggle" class="theme-toggle-btn" onclick="toggleTheme()">🌙 Dark Mode</button>
</div>

<div class="login-card">
    <div class="user-icon">👤</div>
    <h2 style="margin-top: 0; margin-bottom: 20px; color: var(--text-main);">LOGIN</h2>

    <?php if (isset($error)): ?>
        <div class="alert-error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?page=login">
        <input type="email" name="email" placeholder="Email" class="input-box" required>
        <input type="password" name="password" placeholder="Password" class="input-box" required>

        <div class="links">
            <a href="#">Lupa password</a>
            <a href="index.php?page=register">Belum punya akun</a>
        </div>

        <button type="submit" class="btn-submit">LOGIN</button>
    </form>
</div>

<!-- Script untuk Mengatur & Menyimpan Preferensi Tema -->
<script>
    const htmlElement = document.documentElement;
    const themeToggleBtn = document.getElementById('themeToggle');

    // Cek LocalStorage saat halaman dimuat agar preferensi tetap tersimpan
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