<?php
require_once('../php/config.php');
$obj = new CrudKategori;
if(!$obj->detailDataKategori($_GET['id']))die("Eror: id not found");
$result = $obj->deleteKategori($_GET['id']);
if($result==1){
echo "<script>alert('Data berhasil dihapus');</script>";
header("location:../tampil_k.php");
}
?>