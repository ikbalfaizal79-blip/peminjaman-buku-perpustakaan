<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Perpustakaan</title>
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background-color: #242424;
            padding: 30px;
            border-radius: 20px;
            width: 320px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.6);
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
        }
        .btn-submit:hover {
            background-color: #666;
        }
        .links {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .links a {
            color: #3498db;
            text-decoration: none;
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

<div class="login-card">
    <div class="user-icon">👤</div>
    <h2 style="margin-top: 0; margin-bottom: 20px;">LOGIN</h2>

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

</body>
</html>