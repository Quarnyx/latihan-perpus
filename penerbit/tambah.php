<?php
$page_title = 'Tambah Data Penerbit';
$current_menu = 'penerbit';
require_once '../koneksi.php';
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $kode = mysqli_real_escape_string($conn, $_POST['kode_penerbit']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama_penerbit']);
  $sql = "INSERT INTO penerbit(kode_penerbit,nama_penerbit) VALUES('$kode','$nama')";
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
  <h4 class="mb-0"><i class="bi bi-building me-2"></i>Tambah Data Penerbit</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if (isset($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card">
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Kode *</label><input type="text"
            name="kode_penerbit" class="form-control" placeholder="Masukkan kode" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Nama Penerbit *</label><input type="text"
            name="nama_penerbit" class="form-control" placeholder="Masukkan nama penerbit" required></div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Simpan</button>
        <a href="index.php" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>