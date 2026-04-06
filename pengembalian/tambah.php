<?php
$page_title = 'Proses Pengembalian';
$current_menu = 'pengembalian';
require_once '../koneksi.php';
require_once '../includes/header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $pm_id = (int) $_POST['peminjaman_id'];
  $tgl_real = mysqli_real_escape_string($conn, $_POST['tanggal_pengembalian']);
  $ptg = (int) $_SESSION['petugas_id'];
  $pm = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM peminjaman WHERE id=$pm_id"));
  $plan = strtotime($pm['tanggal_kembali']);
  $real = strtotime($tgl_real);
  $denda = 0;
  if ($real > $plan) {
    $hari = floor(($real - $plan) / 86400);
    $denda = $hari * 1000;
  }
  $sql = "INSERT INTO pengembalian(peminjaman_id,tanggal_pengembalian,denda,petugas_id)
          VALUES($pm_id,'$tgl_real',$denda,$ptg)";
  if (mysqli_query($conn, $sql)) {
    mysqli_query($conn, "UPDATE peminjaman SET status='dikembalikan' WHERE id=$pm_id");
    mysqli_query($conn, "UPDATE buku SET stok=stok+1 WHERE id={$pm['buku_id']}");
    $msg = "Pengembalian berhasil!";
    if ($denda > 0)
      $msg .= " Denda: Rp " . number_format($denda, 0, ',', '.');
    $_SESSION['pesan'] = $msg;
    header("Location:index.php");
    exit;
  } else {
    $error = "Gagal: " . mysqli_error($conn);
  }
}
$today = date('Y-m-d');
?>
<div class="page-header d-flex justify-content-between align-items-center">
  <h4 class="mb-0"><i class="bi bi-arrow-down-circle me-2"></i>Proses Pengembalian</h4>
  <a href="index.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<?php if (isset($error)): ?>
  <div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
<div class="card">
  <div class="card-body">
    <form method="POST" id="formKembali">
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label fw-semibold">Pilih Peminjaman Aktif *</label>
          <select name="peminjaman_id" id="pilihPinjam" class="form-select" required onchange="updateInfo(this)">
            <option value="">-- Pilih Kode Peminjaman --</option>
            <?php
            $q = mysqli_query($conn, "SELECT pm.id,pm.kode_pinjam,pm.tanggal_kembali,a.nama_anggota,b.nama_buku
                                FROM peminjaman pm JOIN anggota a ON pm.anggota_id=a.id JOIN buku b ON pm.buku_id=b.id
                                WHERE pm.status='dipinjam' ORDER BY pm.tanggal_kembali");
            while ($r = mysqli_fetch_assoc($q)):
              $late = strtotime($r['tanggal_kembali']) < time() ? '  ⚠ TERLAMBAT' : '';
              ?>
              <option value="<?= $r['id'] ?>" data-anggota="<?= htmlspecialchars($r['nama_anggota']) ?>"
                data-buku="<?= htmlspecialchars($r['nama_buku']) ?>" data-due="<?= $r['tanggal_kembali'] ?>">
                <?= $r['kode_pinjam'] ?> - <?= htmlspecialchars($r['nama_anggota']) ?><?= $late ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="col-md-6"><label class="form-label fw-semibold">Tanggal Pengembalian</label>
          <input type="date" name="tanggal_pengembalian" id="tglKembali" class="form-control" value="<?= $today ?>"
            required onchange="hitungDenda()">
        </div>
      </div>
      <div id="infoBox" class="mt-3 d-none">
        <div class="alert alert-light border">
          <div class="row g-2 mb-2">
            <div class="col-md-4"><small class="text-muted d-block">Anggota</small><strong id="iAnggota">-</strong>
            </div>
            <div class="col-md-4"><small class="text-muted d-block">Buku</small><strong id="iBuku">-</strong></div>
            <div class="col-md-4"><small class="text-muted d-block">Batas Kembali</small><strong id="iDue">-</strong>
            </div>
          </div>
          <hr class="my-2">
          <div class="row g-2">
            <div class="col-md-6"><small class="text-muted d-block">Keterlambatan</small><strong id="iTelat">0
                hari</strong></div>
            <div class="col-md-6"><small class="text-muted d-block">Estimasi Denda</small><strong id="iDenda">Rp
                0</strong></div>
          </div>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-circle me-1"></i>Proses
          Pengembalian</button>
        <a href="index.php" class="btn btn-light">Batal</a>
      </div>
    </form>
  </div>
</div>
<script>
  function updateInfo(sel) {
    const o = sel.options[sel.selectedIndex];
    if (!o.value) { document.getElementById('infoBox').classList.add('d-none'); return; }
    document.getElementById('infoBox').classList.remove('d-none');
    document.getElementById('iAnggota').textContent = o.dataset.anggota;
    document.getElementById('iBuku').textContent = o.dataset.buku;
    document.getElementById('iDue').textContent = new Date(o.dataset.due).toLocaleDateString('id-ID');
    hitungDenda();
  }
  function hitungDenda() {
    const sel = document.getElementById('pilihPinjam');
    const o = sel.options[sel.selectedIndex];
    if (!o.value) return;
    const due = new Date(o.dataset.due), act = new Date(document.getElementById('tglKembali').value);
    const hari = Math.max(0, Math.floor((act - due) / 86400000));
    const denda = hari * 1000;
    document.getElementById('iTelat').textContent = hari + ' hari';
    document.getElementById('iDenda').textContent = 'Rp ' + denda.toLocaleString('id-ID');
    document.getElementById('iTelat').className = hari > 0 ? 'text-danger fw-bold' : 'text-success fw-bold';
    document.getElementById('iDenda').className = denda > 0 ? 'text-danger fw-bold' : 'text-success fw-bold';
  }
</script>
<?php require_once '../includes/footer.php'; ?>