<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman Buku</title>
    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .card {
            background-color: #2b2b2b;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }
        .btn {
            background-color: #555;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover { background-color: #777; }
        .btn-blue { background-color: #3498db; }
        .btn-red { background-color: #e74c3c; }
        .input-dark {
            background-color: #3a3a3a;
            border: 1px solid #555;
            color: white;
            padding: 10px;
            border-radius: 10px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
        }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; }
        tr { border-bottom: 1px solid #333; }
    </style>
</head>
<body>
    