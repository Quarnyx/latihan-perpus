<?php
session_start();
if (!isset($_SESSION['petugas_id'])) {
  header("Location: ../login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan - <?= $page_title ?? 'Dashboard' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
    }

    .navbar-brand {
      font-weight: 700;
      font-size: 1.3rem;
    }

    .sidebar {
      min-height: calc(100vh - 56px);
      background: #fff;
      border-right: 1px solid #dee2e6;
    }

    .sidebar .nav-link {
      color: #495057;
      border-radius: 6px;
      margin-bottom: 4px;
      padding: 8px 12px;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: #0d6efd;
      color: #fff;
    }

    .sidebar .nav-link i {
      margin-right: 8px;
    }

    .card {
      border: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .08);
    }

    .table thead th {
      background: #0d6efd;
      color: #fff;
    }

    .page-header {
      background: #fff;
      padding: 15px 20px;
      border-radius: 8px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../dashboard.php"><i class="bi bi-book-fill me-2"></i>Perpustakaan</a>
      <div class="ms-auto d-flex align-items-center">
        <span class="text-white me-3"><i
            class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['nama_petugas']) ?></span>
        <a href="../logout.php" class="btn btn-outline-light btn-sm"><i
            class="bi bi-box-arrow-right me-1"></i>Logout</a>
      </div>
    </div>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 sidebar py-3 d-none d-md-block">
        <nav class="nav flex-column">
          <a href="../dashboard.php" class="nav-link <?= ($current_menu ?? '') === 'dashboard' ? 'active' : '' ?>"><i
              class="bi bi-speedometer2"></i>Dashboard</a>
          <a href="../anggota/index.php" class="nav-link <?= ($current_menu ?? '') === 'anggota' ? 'active' : '' ?>"><i
              class="bi bi-people"></i>Data Anggota</a>
          <a href="../buku/index.php" class="nav-link <?= ($current_menu ?? '') === 'buku' ? 'active' : '' ?>"><i
              class="bi bi-book"></i>Data Buku</a>
          <a href="../peminjaman/index.php"
            class="nav-link <?= ($current_menu ?? '') === 'peminjaman' ? 'active' : '' ?>"><i
              class="bi bi-arrow-up-circle"></i>Pinjam Buku</a>
          <a href="../pengembalian/index.php"
            class="nav-link <?= ($current_menu ?? '') === 'pengembalian' ? 'active' : '' ?>"><i
              class="bi bi-arrow-down-circle"></i>Pengembalian</a>
        </nav>
      </div>
      <div class="col-md-10 py-4 px-4">