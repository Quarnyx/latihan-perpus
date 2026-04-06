<form method="post">
    <label>Nama</label>
    <input type="text" name="identitas">
    <label>kelas</label>
    <input type="text" name="kelas">
    <label>alamat</label>
    <input type="text" name="alamat">
    <button type="submit">Kirim</button>
</form>
<?php
$nama = $_POST['identitas'];
$kelas = $_POST['kelas'];
$alamat = $_POST['alamat'];
echo "Halo " . $nama . "kelas " . $kelas . "alamat " . $alamat;
?>