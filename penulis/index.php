<?php
$page_title = 'Data Penulis';
$current_menu = 'penulis';
require_once '../koneksi.php';
require_once '../includes/header.php';
$pesan = $_SESSION['pesan'] ?? '';
unset($_SESSION['pesan']);
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
$where = $cari ? "WHERE kode_penulis LIKE '%$cari%' OR nama_penulis LIKE '%$cari%'" : '';
$result = mysqli_query($conn, "SELECT * FROM penulis $where ORDER BY id DESC");
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Data Penulis</h4>
  <a href="tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Tambah</a>
</div>
<?php if ($pesan): ?>
  <div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?= $pesan ?><button
      type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
<div class="card mb-3">
  <div class="card-body py-2">
    <form method="GET" class="d-flex gap-2">
      <input type="text" name="cari" class="form-control" placeholder="Cari kode atau nama..."
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
            <th>Nama Penulis</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1;
          if (mysqli_num_rows($result) > 0):
            while ($r = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><span class="badge bg-secondary"><?= $r['kode_penulis'] ?></span></td>
                <td><?= htmlspecialchars($r['nama_penulis']) ?></td>
                <td>
                  <a href="edit.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                  <a href="hapus.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Yakin hapus data ini?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php endwhile; else: ?>
            <tr>
              <td colspan="4" class="text-center py-3 text-muted"><?= $cari ? 'Data tidak ditemukan.' : 'Belum ada data.' ?>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>