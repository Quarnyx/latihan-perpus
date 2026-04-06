<?php
$page_title='Dashboard'; $current_menu='dashboard';
require_once 'koneksi.php'; require_once 'includes/header.php';
$total_anggota    = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM anggota"))[0];
$total_buku       = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM buku"))[0];
$total_dipinjam   = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM peminjaman WHERE status='dipinjam'"))[0];
$total_kembali    = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM pengembalian"))[0];
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
  <span class="text-muted small"><?= date('l, d F Y') ?></span>
</div>
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <div class="card text-white bg-primary h-100"><div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div><p class="mb-1 small opacity-75">Total Anggota</p><h2 class="mb-0 fw-bold"><?= $total_anggota ?></h2></div>
        <i class="bi bi-people" style="font-size:2.5rem;opacity:.4;"></i>
      </div>
    </div></div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card text-white bg-success h-100"><div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div><p class="mb-1 small opacity-75">Total Buku</p><h2 class="mb-0 fw-bold"><?= $total_buku ?></h2></div>
        <i class="bi bi-book" style="font-size:2.5rem;opacity:.4;"></i>
      </div>
    </div></div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card text-white bg-warning h-100"><div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div><p class="mb-1 small opacity-75">Sedang Dipinjam</p><h2 class="mb-0 fw-bold"><?= $total_dipinjam ?></h2></div>
        <i class="bi bi-arrow-up-circle" style="font-size:2.5rem;opacity:.4;"></i>
      </div>
    </div></div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card text-white bg-info h-100"><div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div><p class="mb-1 small opacity-75">Total Pengembalian</p><h2 class="mb-0 fw-bold"><?= $total_kembali ?></h2></div>
        <i class="bi bi-arrow-down-circle" style="font-size:2.5rem;opacity:.4;"></i>
      </div>
    </div></div>
  </div>
</div>
<h5 class="mb-3">Menu Utama</h5>
<div class="row g-3 mb-4">
  <div class="col-6 col-md-3">
    <a href="anggota/index.php" class="text-decoration-none">
      <div class="card h-100 text-center p-3 border-2 border-primary" style="transition:.2s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <i class="bi bi-people text-primary" style="font-size:3rem;"></i>
        <h6 class="mt-2 text-dark">Data Anggota</h6>
        <small class="text-muted">Kelola anggota perpustakaan</small>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-3">
    <a href="peminjaman/index.php" class="text-decoration-none">
      <div class="card h-100 text-center p-3 border-2 border-warning" style="transition:.2s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <i class="bi bi-arrow-up-circle text-warning" style="font-size:3rem;"></i>
        <h6 class="mt-2 text-dark">Pinjam Buku</h6>
        <small class="text-muted">Transaksi peminjaman buku</small>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-3">
    <a href="pengembalian/index.php" class="text-decoration-none">
      <div class="card h-100 text-center p-3 border-2 border-info" style="transition:.2s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <i class="bi bi-arrow-down-circle text-info" style="font-size:3rem;"></i>
        <h6 class="mt-2 text-dark">Pengembalian Buku</h6>
        <small class="text-muted">Proses pengembalian buku</small>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-3">
    <a href="buku/index.php" class="text-decoration-none">
      <div class="card h-100 text-center p-3 border-2 border-success" style="transition:.2s" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
        <i class="bi bi-book text-success" style="font-size:3rem;"></i>
        <h6 class="mt-2 text-dark">Data Buku</h6>
        <small class="text-muted">Kelola koleksi buku</small>
      </div>
    </a>
  </div>
</div>
<div class="card">
  <div class="card-header bg-white d-flex justify-content-between align-items-center">
    <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Peminjaman Aktif Terbaru</h6>
    <a href="peminjaman/index.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Kode Pinjam</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr></thead>
        <tbody>
        <?php
        $sql="SELECT p.kode_pinjam,a.nama_anggota,b.nama_buku,p.tanggal_pinjam,p.tanggal_kembali,p.status
              FROM peminjaman p JOIN anggota a ON p.anggota_id=a.id JOIN buku b ON p.buku_id=b.id
              WHERE p.status='dipinjam' ORDER BY p.id DESC LIMIT 5";
        $res=mysqli_query($conn,$sql);
        if(mysqli_num_rows($res)>0): while($r=mysqli_fetch_assoc($res)):
            $late=strtotime($r['tanggal_kembali'])<time();
        ?>
        <tr>
          <td><span class="badge bg-secondary"><?=$r['kode_pinjam']?></span></td>
          <td><?=htmlspecialchars($r['nama_anggota'])?></td>
          <td><?=htmlspecialchars($r['nama_buku'])?></td>
          <td><?=date('d/m/Y',strtotime($r['tanggal_pinjam']))?></td>
          <td><?=date('d/m/Y',strtotime($r['tanggal_kembali']))?></td>
          <td><?php if($late):?><span class="badge bg-danger">Terlambat</span>
              <?php else:?><span class="badge bg-warning text-dark">Dipinjam</span><?php endif;?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="6" class="text-center py-3 text-muted">Tidak ada peminjaman aktif.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>
