<?php
$page_title = 'Data Buku';
$current_menu = 'buku';
require_once '../koneksi.php';
require_once '../includes/header.php';
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
$where = $cari ? "WHERE b.nama_buku LIKE '%$cari%' OR b.kode_buku LIKE '%$cari%' OR k.nama_kategori LIKE '%$cari%'" : '';
$sql = "SELECT b.*,k.nama_kategori,p.nama_penerbit,pu.nama_penulis FROM buku b
      LEFT JOIN kategori k ON b.kategori_id=k.id
      LEFT JOIN penerbit p ON b.penerbit_id=p.id
      LEFT JOIN penulis pu ON b.penulis_id=pu.id $where ORDER BY b.id DESC";
$result = mysqli_query($conn, $sql);
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-book me-2"></i>Data Buku</h4>
  <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah Buku</a>
</div>
<?php if ($pesan): ?>
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?= $pesan ?><button
      type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<div class="card mb-3">
  <div class="card-body py-2">
    <form method="GET" class="d-flex gap-2">
      <input type="text" name="cari" class="form-control" placeholder="Cari nama buku, kode, atau kategori..."
        value="<?= htmlspecialchars($cari) ?>">
      <button type="submit" class="btn btn-outline-primary px-4"><i class="bi bi-search"></i></button>
      <?php if ($cari): ?><a href="index.php" class="btn btn-outline-secondary">Reset</a><?php endif; ?>
    </form>
  </div>
</div>
<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Buku</th>
            <th>Penulis</th>
            <th>Penerbit</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Tahun</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          if (mysqli_num_rows($result) > 0):
            while ($r = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><span class="badge bg-secondary"><?= $r['kode_buku'] ?></span></td>
                <td><strong><?= htmlspecialchars($r['nama_buku']) ?></strong></td>
                <td><?= htmlspecialchars($r['nama_penulis'] ?? '-') ?></td>
                <td><?= htmlspecialchars($r['nama_penerbit'] ?? '-') ?></td>
                <td><span class="badge bg-info text-dark"><?= htmlspecialchars($r['nama_kategori'] ?? '-') ?></span></td>
                <td><span class="badge <?= $r['stok'] > 0 ? 'bg-success' : 'bg-danger' ?>"><?= $r['stok'] ?></span></td>
                <td><?= $r['tahun'] ?></td>
                <td>
                  <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                  <a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Yakin hapus buku ini?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php endwhile; else: ?>
            <tr>
              <td colspan="9" class="text-center py-3 text-muted">
                <?= $cari ? "Buku tidak ditemukan." : "Belum ada data buku." ?></td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>