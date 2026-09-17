<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Perpustakaan</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-card {
            background-color: #242424;
            padding: 30px;
            border-radius: 20px;
            width: 320px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
        }
        .user-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .input-box {
            background-color: #7d7d7d;
            border: none;
            color: white;
            padding: 12px 15px;
            border-radius: 12px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
            outline: none;
            font-size: 14px;
        }
        .input-box::placeholder {
            color: #d1d1d1;
        }
        .btn-submit {
            background-color: #4a4a4a;
            color: white;
            border: 1px solid #7d7d7d;
            padding: 10px 30px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
            font-size: 14px;
            transition: background-color 0.2s;
        }
        .btn-submit:hover {
            background-color: #666666;
        }
        .links {
            margin-top: 15px;
            font-size: 13px;
        }
        .links a {
            color: #3498db;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .alert-error {
            background-color: #e74c3c;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 13px;
        }
    </style>
</head>
<body>

<?php include 'views/layout/header.php'; ?>

<div class="card" style="max-width: 400px; margin: 50px auto; padding: 30px; text-align: center;">
    <div style="font-size: 40px; margin-bottom: 10px;">📖</div>
    <h2 style="margin-bottom: 20px;">Daftar Akun Siswa</h2>

    <?php if (isset($error)): ?>
        <p style="color: #e74c3c; font-size: 14px;"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=register">
        <input type="text" name="nama" placeholder="Nama Lengkap" class="input-dark" required style="width: 100%; margin-bottom: 15px; padding: 10px; box-sizing: border-box;">
        
        <input type="email" name="email" placeholder="Email" class="input-dark" required style="width: 100%; margin-bottom: 15px; padding: 10px; box-sizing: border-box;">
        
        <input type="text" name="nis" placeholder="NIS (Nomor Induk Siswa)" class="input-dark" required style="width: 100%; margin-bottom: 15px; padding: 10px; box-sizing: border-box;">
        
        <input type="text" name="kelas" placeholder="Kelas (contoh: XI RPL 1)" class="input-dark" required style="width: 100%; margin-bottom: 15px; padding: 10px; box-sizing: border-box;">
        
        <input type="password" name="password" placeholder="Password" class="input-dark" required style="width: 100%; margin-bottom: 20px; padding: 10px; box-sizing: border-box;">

        <button type="submit" class="btn btn-blue" style="width: 100%; padding: 10px; border-radius: 20px;">DAFTAR</button>
    </form>

    <p style="margin-top: 20px; font-size: 14px; color: #aaa;">
        Sudah punya akun? <a href="index.php?page=login" style="color: #3498db; text-decoration: none;">Login di sini</a>
    </p>
</div>

<?php include 'views/layout/footer.php'; ?>
</body>
</html>