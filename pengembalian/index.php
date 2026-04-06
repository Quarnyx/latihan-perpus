<?php
$page_title = 'Pengembalian Buku';
$current_menu = 'pengembalian';
require_once '../koneksi.php';
require_once '../includes/header.php';
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);
$sql = "SELECT pg.*,pm.kode_pinjam,b.nama_buku,a.nama_anggota,pt.nama_petugas
      FROM pengembalian pg
      JOIN peminjaman pm ON pg.peminjaman_id=pm.id
      JOIN buku b ON pm.buku_id=b.id
      JOIN anggota a ON pm.anggota_id=a.id
      JOIN petugas pt ON pg.petugas_id=pt.id
      ORDER BY pg.id DESC";
$result = mysqli_query($conn, $sql);
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-arrow-down-circle me-2"></i>Pengembalian Buku</h4>
  <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Proses Pengembalian</a>
</div>
<?php if ($pesan): ?>
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?= $pesan ?><button
      type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Pinjam</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Kembali</th>
            <th>Denda</th>
            <th>Petugas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          if (mysqli_num_rows($result) > 0):
            while ($r = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><span class="badge bg-secondary"><?= $r['kode_pinjam'] ?></span></td>
                <td><?= htmlspecialchars($r['nama_anggota']) ?></td>
                <td><?= htmlspecialchars($r['nama_buku']) ?></td>
                <td><?= date('d/m/Y', strtotime($r['tanggal_pengembalian'])) ?></td>
                <td><?php if ($r['denda'] > 0): ?><span class="badge bg-danger">Rp
                      <?= number_format($r['denda'], 0, ',', '.') ?></span>
                  <?php else: ?><span class="badge bg-success">Tidak ada</span><?php endif; ?></td>
                <td><?= htmlspecialchars($r['nama_petugas']) ?></td>
                <td><a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Yakin hapus?')"><i class="bi bi-trash"></i></a></td>
              </tr>
            <?php endwhile; else: ?>
            <tr>
              <td colspan="8" class="text-center py-3 text-muted">Belum ada data pengembalian.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>