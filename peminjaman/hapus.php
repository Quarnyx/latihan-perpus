<?php
session_start();
require_once '../koneksi.php';
if (!isset($_SESSION['petugas_id'])) {
    header("Location:../login.php");
    exit;
}
$id = (int) $_GET['id'];
$p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT buku_id,status FROM peminjaman WHERE id=$id"));
if ($p && $p['status'] == 'dipinjam') {
    mysqli_query($conn, "UPDATE buku SET stok=stok+1 WHERE id={$p['buku_id']}");
}
mysqli_query($conn, "DELETE FROM peminjaman WHERE id=$id");
$_SESSION['pesan'] = "Peminjaman berhasil dihapus!";
header("Location:index.php");
exit;
?>