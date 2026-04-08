<?php
$page_title = 'Peminjaman Buku';
$current_menu = 'peminjaman';
require_once '../koneksi.php';
require_once '../includes/header.php';
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);
$f = isset($_GET['filter']) ? $_GET['filter'] : 'semua';
$where = '';
if ($f == 'dipinjam')
  $where = "WHERE p.status='dipinjam'";
if ($f == 'dikembalikan')
  $where = "WHERE p.status='dikembalikan'";
if ($f == 'terlambat')
  $where = "WHERE p.status='dipinjam' AND p.tanggal_kembali < CURDATE()";
$sql = "SELECT p.*,b.nama_buku,a.nama_anggota FROM peminjaman p
      JOIN buku b ON p.buku_id=b.id JOIN anggota a ON p.anggota_id=a.id $where ORDER BY p.id DESC";
$result = mysqli_query($conn, $sql);
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-arrow-up-circle me-2"></i>Data Peminjaman</h4>
  <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah Peminjaman</a>
</div>
<?php if ($pesan): ?>
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?= $pesan ?><button
      type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<div class="mb-3">
  <a href="?filter=semua" class="btn btn-sm <?= $f == 'semua' ? 'btn-primary' : 'btn-outline-secondary' ?>">Semua</a>
  <a href="?filter=dipinjam"
    class="btn btn-sm <?= $f == 'dipinjam' ? 'btn-warning' : 'btn-outline-warning' ?>">Dipinjam</a>
  <a href="?filter=terlambat"
    class="btn btn-sm <?= $f == 'terlambat' ? 'btn-danger' : 'btn-outline-danger' ?>">Terlambat</a>
  <a href="?filter=dikembalikan"
    class="btn btn-sm <?= $f == 'dikembalikan' ? 'btn-success' : 'btn-outline-success' ?>">Dikembalikan</a>
</div>
<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          if (mysqli_num_rows($result) > 0):
            while ($r = mysqli_fetch_assoc($result)):
              $late = $r['status'] == 'dipinjam' && strtotime($r['tanggal_kembali']) < time();
              ?>
              <tr class="<?= $late ? 'table-danger' : '' ?>">
                <td><?= $no++ ?></td>
                <td><span class="badge bg-secondary"><?= $r['kode_pinjam'] ?></span></td>
                <td><?= htmlspecialchars($r['nama_anggota']) ?></td>
                <td><?= htmlspecialchars($r['nama_buku']) ?></td>
                <td><?= date('d/m/Y', strtotime($r['tanggal_pinjam'])) ?></td>
                <td><?= date('d/m/Y', strtotime($r['tanggal_kembali'])) ?></td>
                <td>
                  <?php if ($late): ?><span class="badge bg-danger">Terlambat</span>
                  <?php elseif ($r['status'] == 'dipinjam'): ?><span class="badge bg-warning text-dark">Dipinjam</span>
                  <?php else: ?><span class="badge bg-success">Dikembalikan</span><?php endif; ?>
                </td>
                <td>
                  <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                  <a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php endwhile; else: ?>
            <tr>
              <td colspan="8" class="text-center py-3 text-muted">Belum ada data peminjaman.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>