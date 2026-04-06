<?php
$page_title = 'Tambah Anggota';
$current_menu = 'anggota';
require_once '../koneksi.php';
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nis = mysqli_real_escape_string($conn, $_POST['nis']);
  $nama = mysqli_real_escape_string($conn, $_POST['nama_anggota']);
  $telp = mysqli_real_escape_string($conn, $_POST['no_telp']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $tempat = mysqli_real_escape_string($conn, $_POST['tempat_lahir']);
  $tgl = mysqli_real_escape_string($conn, $_POST['tanggal_lahir']);
  $jk = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);
  $pass = md5($_POST['password']);
  $sql = "INSERT INTO anggota(nis,nama_anggota,no_telp,email,tempat_lahir,tanggal_lahir,jenis_kelamin,status,password)
          VALUES('$nis','$nama','$telp','$email','$tempat','$tgl','$jk','$status','$pass')";
  if (mysqli_query($conn, $sql)) {
    $_SESSION['pesan'] = "Anggota berhasil ditambahkan!";
    header("Location:index.php");
    exit;
  } else {
    $error = "Gagal: " . mysqli_error($conn);
  }
}
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-person-plus me-2"></i>Tambah Anggota</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if (isset($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card">
  <div class="card-body">
    <form method="POST">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">NIS *</label><input type="number" name="nis"
            class="form-control" placeholder="Nomor Induk Siswa" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Nama Lengkap *</label><input type="text"
            name="nama_anggota" class="form-control" placeholder="Nama lengkap" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">No. Telepon *</label><input type="text"
            name="no_telp" class="form-control" placeholder="08xxxxxxxxxx" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Email *</label><input type="email" name="email"
            class="form-control" placeholder="email@contoh.com" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Tempat Lahir *</label><input type="text"
            name="tempat_lahir" class="form-control" placeholder="Kota" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Lahir *</label><input type="date"
            name="tanggal_lahir" class="form-control" required></div>
        <div class="col-md-6"><label class="form-label fw-semibold">Jenis Kelamin *</label>
          <select name="jenis_kelamin" class="form-select" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Status</label>
          <select name="status" class="form-select">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Password *</label><input type="password"
            name="password" class="form-control" required></div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Simpan</button>
        <a href="index.php" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>