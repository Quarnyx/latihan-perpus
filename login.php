<?php
session_start();
require_once 'koneksi.php';
$error = '';
if (isset($_SESSION['petugas_id'])) {
  header("Location: dashboard.php");
  exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = $_POST['password'];
  $sql = "SELECT * FROM petugas WHERE username='$username' AND status='aktif'";
  $result = mysqli_query($conn, $sql);
  if ($result && mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    if (md5($password) == $user['password'] || $password == $user['password']) {
      $_SESSION['petugas_id'] = $user['id'];
      $_SESSION['nama_petugas'] = $user['nama_petugas'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['level'] = $user['level'];
      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Password salah!";
    }
  } else {
    $error = "Username tidak ditemukan atau akun tidak aktif!";
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - Perpustakaan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #0d6efd, #0a58ca);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      border-radius: 16px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
    }

    .login-header {
      background: #0d6efd;
      color: #fff;
      border-radius: 16px 16px 0 0;
      padding: 30px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="login-card bg-white">
    <div class="login-header">
      <i class="bi bi-book-fill" style="font-size:3rem;"></i>
      <h4 class="mt-2 mb-0">Perpustakaan</h4>
      <p class="mb-0 opacity-75 small">Sistem Manajemen Perpustakaan</p>
    </div>
    <div class="p-4">
      <h5 class="mb-4 text-center text-muted">Masuk ke Akun Anda</h5>
      <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show">
          <i class="bi bi-exclamation-circle me-2"></i><?= $error ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>
      <form method="POST">
        <div class="mb-3">
          <label class="form-label fw-semibold">Username</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person"></i></span>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required
              value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
          </div>
        </div>
        <div class="mb-4">
          <label class="form-label fw-semibold">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
          <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </button>
        <button type="button" class="btn btn-danger">Danger</button>
      </form>
      <p class="text-center text-muted small mt-3">Default: username <strong>admin</strong> / password
        <strong>admin123</strong>
      </p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>