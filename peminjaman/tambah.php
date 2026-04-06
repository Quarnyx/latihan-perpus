<?php
$page_title = 'Tambah Peminjaman';
$current_menu = 'peminjaman';
require_once '../koneksi.php';
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $ang = (int) $_POST['anggota_id'];
  $buk = (int) $_POST['buku_id'];
  $tp = mysqli_real_escape_string($conn, $_POST['tanggal_pinjam']);
  $tk = mysqli_real_escape_string($conn, $_POST['tanggal_kembali']);
  $ptg = (int) $_SESSION['petugas_id'];
  $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM buku WHERE id=$buk"));
  if ($cek['stok'] < 1) {
    $error = "Stok buku habis! Tidak bisa dipinjam.";
  } else {
    $last = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM peminjaman ORDER BY id DESC LIMIT 1"));
    $no = ($last ? $last['id'] + 1 : 1);
    $kode = 'PJM-' . str_pad($no, 3, '0', STR_PAD_LEFT);
    $sql = "INSERT INTO peminjaman(tanggal_pinjam,tanggal_kembali,kode_pinjam,anggota_id,petugas_id,buku_id,status)
              VALUES('$tp','$tk','$kode',$ang,$ptg,$buk,'dipinjam')";
    if (mysqli_query($conn, $sql)) {
      mysqli_query($conn, "UPDATE buku SET stok=stok-1 WHERE id=$buk");
      $_SESSION['pesan'] = "Peminjaman berhasil! Kode: $kode";
      header("Location:index.php");
      exit;
    } else {
      $error = "Gagal: " . mysqli_error($conn);
    }
  }
}
$today = date('Y-m-d');
$due = date('Y-m-d', strtotime('+7 days'));
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-arrow-up-circle me-2"></i>Tambah Peminjaman</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if (isset($error)): ?>
  <div class="alert alert-danger"><i class="bi bi-exclamation-circle me-2"></i><?= $error ?></div><?php endif; ?>
<div class="card">
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Anggota *</label>
          <select name="anggota_id" class="form-select" required>
            <option value="">-- Pilih Anggota --</option>
            <?php $q = mysqli_query($conn, "SELECT id,nis,nama_anggota FROM anggota WHERE status='aktif' ORDER BY nama_anggota");
            while ($r = mysqli_fetch_assoc($q)): ?>
              <option value="<?= $r['id'] ?>"><?= $r['nis'] ?> - <?= htmlspecialchars($r['nama_anggota']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Buku *</label>
          <select name="buku_id" class="form-select" required>
            <option value="">-- Pilih Buku (stok tersedia) --</option>
            <?php $q = mysqli_query($conn, "SELECT id,kode_buku,nama_buku,stok FROM buku WHERE stok>0 ORDER BY nama_buku");
            while ($r = mysqli_fetch_assoc($q)): ?>
              <option value="<?= $r['id'] ?>">[<?= $r['kode_buku'] ?>] <?= htmlspecialchars($r['nama_buku']) ?> (Stok:
                <?= $r['stok'] ?>)</option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Pinjam</label><input type="date"
            name="tanggal_pinjam" class="form-control" value="<?= $today ?>" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Kembali</label><input type="date"
            name="tanggal_kembali" class="form-control" value="<?= $due ?>" required></div>
        <div class="col-12">
          <div class="alert alert-info mb-0"><i class="bi bi-info-circle me-2"></i>Denda keterlambatan: <strong>Rp
              1.000/hari</strong>. Kode dibuat otomatis.</div>
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