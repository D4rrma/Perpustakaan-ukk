<?php
require_once('php/config.php');
$obj = new Buku;
if(!$obj->detailDataBuku($_GET['id']))die("Eror: id not found");
$result = $obj->deleteBuku($_GET['id']);
if($result==1){
echo "<script>alert('Data berhasil dihapus');</script>";
header("location:tampil_b.php");
}
?>