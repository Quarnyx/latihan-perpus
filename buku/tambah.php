<?php
$page_title='Tambah Buku'; $current_menu='buku';
require_once '../koneksi.php'; require_once '../includes/header.php';
$data=[];
if($_SERVER['REQUEST_METHOD']=='POST'){
    $data=$_POST;
    $kode=mysqli_real_escape_string($conn,$_POST['kode_buku']);
    $nama=mysqli_real_escape_string($conn,$_POST['nama_buku']);
    $hal=(int)$_POST['halaman']; $stok=(int)$_POST['stok'];
    $rak=mysqli_real_escape_string($conn,$_POST['rak']);
    $dim=mysqli_real_escape_string($conn,$_POST['dimensi']);
    $pnr=(int)$_POST['penerbit_id']; $pnl=(int)$_POST['penulis_id'];
    $sup=(int)$_POST['supplier_id']; $thn=(int)$_POST['tahun'];
    $kat=(int)$_POST['kategori_id']; $ptg=(int)$_SESSION['petugas_id'];
    $bar=mysqli_real_escape_string($conn,$_POST['barcode']);
    $sql="INSERT INTO buku(kode_buku,halaman,nama_buku,stok,rak,dimensi,penerbit_id,penulis_id,supplier_id,tahun,kategori_id,petugas_id,barcode)
          VALUES('$kode',$hal,'$nama',$stok,'$rak','$dim',$pnr,$pnl,$sup,$thn,$kat,$ptg,'$bar')";
    if(mysqli_query($conn,$sql)){$_SESSION['pesan']="Buku berhasil ditambahkan!";header("Location:index.php");exit;}
    else{$error="Gagal: ".mysqli_error($conn);}
}
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-book me-2"></i>Tambah Buku</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if(isset($error)):?><div class="alert alert-danger"><?=$error?></div><?php endif;?>
<div class="card"><div class="card-body"><form method="POST">
<div class="row g-3">
  <div class="col-md-6"><label class="form-label fw-semibold">Kode Buku *</label><input type="text" name="kode_buku" class="form-control" value="<?=htmlspecialchars($data['kode_buku']??'')?>" placeholder="Contoh: BK-0001" required></div>
  <div class="col-md-6"><label class="form-label fw-semibold">Nama Buku *</label><input type="text" name="nama_buku" class="form-control" value="<?=htmlspecialchars($data['nama_buku']??'')?>" placeholder="Judul buku" required></div>
  <div class="col-md-6"><label class="form-label fw-semibold">Penulis *</label>
    <select name="penulis_id" class="form-select" required>
      <option value="">-- Pilih Penulis --</option>
      <?php $q=mysqli_query($conn,"SELECT * FROM penulis ORDER BY nama_penulis");
      while($r=mysqli_fetch_assoc($q)):?>
      <option value="<?=$r['id']?>" <?=($data['penulis_id']??'')==$r['id']?'selected':''?>><?=htmlspecialchars($r['nama_penulis'])?></option>
      <?php endwhile;?>
    </select>
  </div>
  <div class="col-md-6"><label class="form-label fw-semibold">Penerbit *</label>
    <select name="penerbit_id" class="form-select" required>
      <option value="">-- Pilih Penerbit --</option>
      <?php $q=mysqli_query($conn,"SELECT * FROM penerbit ORDER BY nama_penerbit");
      while($r=mysqli_fetch_assoc($q)):?>
      <option value="<?=$r['id']?>" <?=($data['penerbit_id']??'')==$r['id']?'selected':''?>><?=htmlspecialchars($r['nama_penerbit'])?></option>
      <?php endwhile;?>
    </select>
  </div>
  <div class="col-md-6"><label class="form-label fw-semibold">Kategori *</label>
    <select name="kategori_id" class="form-select" required>
      <option value="">-- Pilih Kategori --</option>
      <?php $q=mysqli_query($conn,"SELECT * FROM kategori ORDER BY nama_kategori");
      while($r=mysqli_fetch_assoc($q)):?>
      <option value="<?=$r['id']?>" <?=($data['kategori_id']??'')==$r['id']?'selected':''?>><?=htmlspecialchars($r['nama_kategori'])?></option>
      <?php endwhile;?>
    </select>
  </div>
  <div class="col-md-6"><label class="form-label fw-semibold">Supplier *</label>
    <select name="supplier_id" class="form-select" required>
      <option value="">-- Pilih Supplier --</option>
      <?php $q=mysqli_query($conn,"SELECT * FROM supplier ORDER BY nama_supplier");
      while($r=mysqli_fetch_assoc($q)):?>
      <option value="<?=$r['id']?>" <?=($data['supplier_id']??'')==$r['id']?'selected':''?>><?=htmlspecialchars($r['nama_supplier'])?></option>
      <?php endwhile;?>
    </select>
  </div>
  <div class="col-md-4"><label class="form-label fw-semibold">Halaman</label><input type="number" name="halaman" class="form-control" value="<?=$data['halaman']??''?>"></div>
  <div class="col-md-4"><label class="form-label fw-semibold">Stok *</label><input type="number" name="stok" class="form-control" value="<?=$data['stok']??''?>" required></div>
  <div class="col-md-4"><label class="form-label fw-semibold">Tahun Terbit *</label><input type="number" name="tahun" class="form-control" value="<?=$data['tahun']??''?>" placeholder="<?=date('Y')?>" required></div>
  <div class="col-md-6"><label class="form-label fw-semibold">Rak</label><input type="text" name="rak" class="form-control" value="<?=htmlspecialchars($data['rak']??'')?>" placeholder="Contoh: A-01"></div>
  <div class="col-md-6"><label class="form-label fw-semibold">Dimensi</label><input type="text" name="dimensi" class="form-control" value="<?=htmlspecialchars($data['dimensi']??'')?>" placeholder="Contoh: 21x14 cm"></div>
  <div class="col-md-6"><label class="form-label fw-semibold">Barcode</label><input type="text" name="barcode" class="form-control" value="<?=htmlspecialchars($data['barcode']??'')?>"></div>
</div>
<div class="mt-4 d-flex gap-2">
  <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Simpan</button>
  <a href="index.php" class="btn btn-light">Batal</a>
</div>
</form></div></div>
<?php require_once '../includes/footer.php'; ?>
