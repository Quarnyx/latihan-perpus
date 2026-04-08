<?php
$page_title='Edit Data Kategori'; $current_menu='kategori';
require_once '../koneksi.php'; require_once '../includes/header.php';
$id=(int)$_GET['id'];
$data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM kategori WHERE id=$id"));
if(!$data){echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>"; require_once '../includes/footer.php'; exit;}
if($_SERVER['REQUEST_METHOD']=='POST'){
  $kode=mysqli_real_escape_string($conn,$_POST['kode_kategori']);
  $nama=mysqli_real_escape_string($conn,$_POST['nama_kategori']);
  $sql="UPDATE kategori SET kode_kategori='$kode',nama_kategori='$nama' WHERE id=$id";
  if(mysqli_query($conn,$sql)){$_SESSION['pesan']='Data berhasil diperbarui!'; header('Location:index.php'); exit;}
  else {$error='Gagal: '.mysqli_error($conn);}
}
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-tags me-2"></i>Edit Data Kategori</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if(isset($error)):?><div class="alert alert-danger"><?=$error?></div><?php endif;?>
<div class="card"><div class="card-body">
<form method="POST">
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">Kode *</label><input type="text" name="kode_kategori" class="form-control" value="<?=$data['kode_kategori']?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Nama Kategori *</label><input type="text" name="nama_kategori" class="form-control" value="<?=htmlspecialchars($data['nama_kategori'])?>" required></div>
  </div>
  <div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Simpan</button>
    <a href="index.php" class="btn btn-light">Batal</a>
  </div>
</form>
</div></div>
<?php require_once '../includes/footer.php'; ?>
