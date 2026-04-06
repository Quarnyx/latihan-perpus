<?php
$page_title = 'Edit Peminjaman';
$current_menu = 'peminjaman';
require_once '../koneksi.php';
require_once '../includes/header.php';
$id = (int) $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM peminjaman WHERE id=$id"));
if (!$data) {
  echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>";
  require_once '../includes/footer.php';
  exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $tk = mysqli_real_escape_string($conn, $_POST['tanggal_kembali']);
  $st = mysqli_real_escape_string($conn, $_POST['status']);
  mysqli_query($conn, "UPDATE peminjaman SET tanggal_kembali='$tk',status='$st' WHERE id=$id");
  $_SESSION['pesan'] = "Peminjaman berhasil diperbarui!";
  header("Location:index.php");
  exit;
}
$ang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_anggota FROM anggota WHERE id={$data['anggota_id']}"));
$buk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_buku FROM buku WHERE id={$data['buku_id']}"));
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Peminjaman</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card">
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Kode Pinjam</label><input type="text"
            class="form-control" value="<?= $data['kode_pinjam'] ?>" disabled></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Anggota</label><input type="text"
            class="form-control" value="<?= htmlspecialchars($ang['nama_anggota']) ?>" disabled></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Buku</label><input type="text" class="form-control"
            value="<?= htmlspecialchars($buk['nama_buku']) ?>" disabled></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Pinjam</label><input type="date"
            class="form-control" value="<?= $data['tanggal_pinjam'] ?>" disabled></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Kembali *</label><input type="date"
            name="tanggal_kembali" class="form-control" value="<?= $data['tanggal_kembali'] ?>" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Status</label>
          <select name="status" class="form-select">
            <option value="dipinjam" <?= $data['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
            <option value="dikembalikan" <?= $data['status'] == 'dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
          </select>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Simpan</button>
        <a href="index.php" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>