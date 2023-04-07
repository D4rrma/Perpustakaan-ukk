<?php
require_once('php/config.php');
$obj = new Buku();
if(isset($_POST["submit"])){
$result = $obj->updateBuku($_POST["judul"], $_POST["penerbit"], $_POST["pengarang"],
$_POST["tahun"], $_POST["kategori_id"], $_POST["harga"],
$_POST["id"]);
if($result==1){
echo "<script>alert('Data berhasil diperbaharui');</script>";
header("Refresh: 1; url=tampil_b.php");
}
}
if(!$obj->detailDataBuku($_GET['id']))die("Eror: id buku not found");
include('template/header.php'); 
?>

<div class="container-fluid d-flex justify-content-center align-items-center">

                    <div class="card shadow mb-5 w-100 pb-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Data Buku</h6>
                        </div>
                    <!-- Page Heading -->
                    <div class="w-100">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Masukkan Data Buku</h1>
                            </div>
                            <form method="post" class="user">
                            <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" id="exampleInputEmail"
                                        placeholder="Nama" value="<?php echo $obj->id;?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control" id="exampleInputEmail"
                                        placeholder="Judul"value="<?php echo $obj->judul;?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" id="exampleInputEmail"
                                        placeholder="Penerbit" value="<?php echo $obj->penerbit;?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Pengarang</label>
                                    <input type="text" name="pengarang" class="form-control" id="exampleInputEmail"
                                        placeholder="Kategori" value="<?php echo $obj->pengarang;?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Tahun</label>
                                    <input type="text" name="tahun" class="form-control" id="exampleInputEmail"
                                        placeholder="Tahun" value="<?php echo $obj->tahun;?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Kategori Id</label>
                                <select class="form-control" name="kategori_id">
                                <?php
                                $crudKategori = new CrudKategori();
                                $result = $crudKategori->tampilKategori();
                                while($row = mysqli_fetch_assoc($result)) {
                                    // tambahkan kondisi selected jika nilai id kategori sama dengan id kategori dari buku yang sedang diedit
                                    $selected = ($obj->kategori_id == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nama_kategori'] . "</option>";
                                }
                                ?>
                                </select>
                                </div>
                                <div class="form-group">
                                   <label for="exampleFormControlFile1">Harga</label>
                                    <input type="text" name="harga" class="form-control" id="exampleInputEmail"
                                        placeholder="Harga" value="<?php echo $obj->harga;?>">
                                </div>
                                <button name="submit" type="submit" value="submit" class="w-25 btn btn-primary btn-user btn-block">
                                    Konfirmasi
                                </button> 
                            </form>
                        </div>
                    </div>
                <!-- /.container-fluid -->

            </div>
        </div>

                <?php include('template/footer.php'); ?>