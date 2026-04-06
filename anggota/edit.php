<?php
$page_title='Edit Anggota'; $current_menu='anggota';
require_once '../koneksi.php'; require_once '../includes/header.php';
$id=(int)$_GET['id'];
$data=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM anggota WHERE id=$id"));
if(!$data){echo "<div class='alert alert-danger'>Data tidak ditemukan!</div>";require_once '../includes/footer.php';exit;}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nis=mysqli_real_escape_string($conn,$_POST['nis']);
    $nama=mysqli_real_escape_string($conn,$_POST['nama_anggota']);
    $telp=mysqli_real_escape_string($conn,$_POST['no_telp']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $tempat=mysqli_real_escape_string($conn,$_POST['tempat_lahir']);
    $tgl=mysqli_real_escape_string($conn,$_POST['tanggal_lahir']);
    $jk=mysqli_real_escape_string($conn,$_POST['jenis_kelamin']);
    $status=mysqli_real_escape_string($conn,$_POST['status']);
    $pass_sql='';
    if(!empty($_POST['password'])){$p=md5($_POST['password']);$pass_sql=",password='$p'";}
    $sql="UPDATE anggota SET nis='$nis',nama_anggota='$nama',no_telp='$telp',email='$email',
          tempat_lahir='$tempat',tanggal_lahir='$tgl',jenis_kelamin='$jk',status='$status'$pass_sql WHERE id=$id";
    if(mysqli_query($conn,$sql)){$_SESSION['pesan']="Anggota berhasil diperbarui!";header("Location:index.php");exit;}
    else{$error="Gagal: ".mysqli_error($conn);}
}
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Anggota</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if(isset($error)):?><div class="alert alert-danger"><?=$error?></div><?php endif;?>
<div class="card"><div class="card-body"><form method="POST">
  <div class="row g-3">
    <div class="col-md-6"><label class="form-label fw-semibold">NIS</label><input type="number" name="nis" class="form-control" value="<?=$data['nis']?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Nama Lengkap</label><input type="text" name="nama_anggota" class="form-control" value="<?=htmlspecialchars($data['nama_anggota'])?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">No. Telepon</label><input type="text" name="no_telp" class="form-control" value="<?=$data['no_telp']?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Email</label><input type="email" name="email" class="form-control" value="<?=$data['email']?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Tempat Lahir</label><input type="text" name="tempat_lahir" class="form-control" value="<?=htmlspecialchars($data['tempat_lahir'])?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Lahir</label><input type="date" name="tanggal_lahir" class="form-control" value="<?=$data['tanggal_lahir']?>" required></div>
    <div class="col-md-6"><label class="form-label fw-semibold">Jenis Kelamin</label>
      <select name="jenis_kelamin" class="form-select">
        <option value="Laki-laki" <?=$data['jenis_kelamin']=='Laki-laki'?'selected':''?>>Laki-laki</option>
        <option value="Perempuan" <?=$data['jenis_kelamin']=='Perempuan'?'selected':''?>>Perempuan</option>
      </select>
    </div>
    <div class="col-md-6"><label class="form-label fw-semibold">Status</label>
      <select name="status" class="form-select">
        <option value="aktif" <?=$data['status']=='aktif'?'selected':''?>>Aktif</option>
        <option value="nonaktif" <?=$data['status']=='nonaktif'?'selected':''?>>Nonaktif</option>
      </select>
    </div>
    <div class="col-md-6"><label class="form-label fw-semibold">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label><input type="password" name="password" class="form-control"></div>
  </div>
  <div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Simpan</button>
    <a href="index.php" class="btn btn-light">Batal</a>
  </div>
</form></div></div>
<?php require_once '../includes/footer.php'; ?>
