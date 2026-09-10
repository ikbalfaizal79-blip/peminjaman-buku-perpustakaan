<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Buku</title>
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header HANYA muncul jika user SUDAH LOGIN -->
        <?php if (isset($_SESSION['user'])): ?>
            <div style="background-color: #2b2b2b; padding: 15px 25px; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h3 style="margin: 0; color: #fff; font-weight: normal;">Hallo <?= htmlspecialchars($_SESSION['user']['nama']) ?></h3>
                <a href="index.php?action=logout" class="btn" style="background-color: #e64a19; color: white; font-weight: bold;">Logout</a>
            </div>
        <?php endif; ?>

        <!-- Content dari View dengan fallback path aman -->
        <?php 
            if (isset($viewFile) && file_exists($viewFile)) {
                include $viewFile;
            } elseif (file_exists('views/admin/akhiri_pinjam.php')) {
                include 'views/admin/akhiri_pinjam.php';
            } else {
                echo "<div style='color: red; padding: 20px;'>File tampilan tidak ditemukan: " . htmlspecialchars($viewFile) . "</div>";
            }
        ?>
    </div>
</body>
</html>