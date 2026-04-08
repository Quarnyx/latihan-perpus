<?php
session_start();
require_once '../koneksi.php';
if (!isset($_SESSION['petugas_id'])) {
    header("Location:../login.php");
    exit;
}
$id = (int) $_GET['id'];
$pg = mysqli_fetch_assoc(mysqli_query($conn, "SELECT peminjaman_id FROM pengembalian WHERE id=$id"));
if ($pg) {
    $pm = mysqli_fetch_assoc(mysqli_query($conn, "SELECT buku_id FROM peminjaman WHERE id={$pg['peminjaman_id']}"));
    mysqli_query($conn, "UPDATE peminjaman SET status='dipinjam' WHERE id={$pg['peminjaman_id']}");
    if ($pm)
        mysqli_query($conn, "UPDATE buku SET stok=stok-1 WHERE id={$pm['buku_id']}");
    mysqli_query($conn, "DELETE FROM pengembalian WHERE id=$id");
}
$_SESSION['pesan'] = "Data pengembalian berhasil dihapus!";
header("Location:index.php");
exit;
?>