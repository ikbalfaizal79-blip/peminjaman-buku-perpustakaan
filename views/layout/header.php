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
        --table-border: #e9ecef;
        --table-header-color: #495057;
        --cover-placeholder-bg: #e9ecef;
        --btn-nav-bg: #e9ecef;
        --btn-nav-text: #495057;
        --btn-nav-hover: #dee2e6;
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
        --table-border: #333333;
        --table-header-color: #aaa;
        --cover-placeholder-bg: #444444;
        --btn-nav-bg: #34495e;
        --btn-nav-text: white;
        --btn-nav-hover: #2c3e50;
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

    .card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        box-shadow: var(--shadow);
        padding: 20px;
        box-sizing: border-box;
        transition: background-color 0.3s, border-color 0.3s;
    }

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

    .status-badge {
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: bold;
        text-transform: capitalize;
    }
    .status-menunggu { background-color: #f39c12; color: #fff; }
    .status-dipinjam { background-color: #27ae60; color: #fff; }
    .status-selesai { background-color: #2980b9; color: #fff; }
    .status-ditolak { background-color: #c0392b; color: #fff; }

    .btn-nav {
        background-color: var(--btn-nav-bg);
        color: var(--btn-nav-text);
        padding: 6px 14px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        margin-right: 8px;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.2s;
        border: 1px solid var(--border-color);
    }
    .btn-nav:hover {
        background-color: var(--btn-nav-hover);
    }

    .input-dark {
        background-color: var(--input-bg);
        border: 1px solid var(--input-border);
        color: var(--input-text);
        padding: 6px 12px;
        border-radius: 12px;
        outline: none;
        transition: background-color 0.3s, color 0.3s;
    }
    .input-dark::placeholder {
        color: var(--input-placeholder);
    }

    .btn-blue {
        background-color: var(--btn-blue-bg);
        color: white;
        border: none;
        padding: 6px 18px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-blue:hover {
        opacity: 0.85;
    }

    .btn-red {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 14px;
        border-radius: 15px;
        text-decoration: none;
        font-size: 13px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .btn-red:hover {
        opacity: 0.85;
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
    </style>
</head>
<body>
    