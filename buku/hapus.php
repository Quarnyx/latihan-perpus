<?php
session_start(); require_once '../koneksi.php';
if(!isset($_SESSION['petugas_id'])){header("Location:../login.php");exit;}
$id=(int)$_GET['id'];
mysqli_query($conn,"DELETE FROM buku WHERE id=$id");
$_SESSION['pesan']="Buku berhasil dihapus!";
header("Location:index.php"); exit;
?>
