<?php
$page_title = 'Tambah Data Penuli';
$current_menu = 'penulis';
require_once '../koneksi.php';
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kode = mysqli_real_escape_string($conn, $_POST['kode_penulis']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama_penulis']);
  $sql = "INSERT INTO penulis(kode_penulis,nama_penulis) VALUES('$kode','$nama')";
  if (mysqli_query($conn, $sql)) {
    $_SESSION['pesan'] = 'Data berhasil ditambahkan!';
    header('Location:index.php');
    exit;
  } else {
    $error = 'Gagal: ' . mysqli_error($conn);
  }
}
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Tambah Data Penulis</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if (isset($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card">
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Kode *</label><input type="text" name="kode_penulis"
            class="form-control" placeholder="Masukkan kode" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Nama Penulis *</label><input type="text"
            name="nama_penulis" class="form-control" placeholder="Masukkan nama penulis" required></div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Simpan</button>
        <a href="index.php" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>