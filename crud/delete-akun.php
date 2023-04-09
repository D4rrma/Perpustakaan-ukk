<?php
require_once('../php/config.php');
$obj = new profil;
if (!$obj->tampilAkun($_GET['id']))
    die("Eror: id not found");
$result = $obj->deleteAkun($_GET['id']);
if ($result == 1) {
    echo "<script>alert('Data berhasil dihapus');</script>";
    header("location:../akun.php");
}
?>