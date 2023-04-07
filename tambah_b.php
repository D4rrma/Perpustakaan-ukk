<?php 
require 'php/config.php';
$register = new Buku();
if(isset($_POST["submit"])){
    // Mendapatkan data dari form
    $id = $_POST["id"];
    $judul = $_POST["judul"];
    $penerbit = $_POST["penerbit"];
    $pengarang = $_POST["pengarang"];
    $tahun = $_POST["tahun"];
    $kategori = $_POST["kategori_id"];
    $harga = $_POST["harga"];
    $foto = $_FILES["foto"]["name"];
    $foto_type = $_FILES["foto"]["type"];
    $foto_size = $_FILES["foto"]["size"];

    // Validasi tipe file dan ukuran file
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    $max_size = 5 * 1024 * 1024; // 5MB
    if (!in_array($foto_type, $allowed_types) || $foto_size > $max_size) {
        echo "<script>alert('Tipe atau ukuran file tidak sesuai');</script>";
        exit;
    }

    // Proses upload foto
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $i = 0;
    while (file_exists($target_file)) {
        $i++;
        $target_file = $target_dir . pathinfo($foto, PATHINFO_FILENAME) . '_' . $i . '.' . pathinfo($foto, PATHINFO_EXTENSION);
    }
    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
    $foto = basename($target_file);

    // Menambahkan data buku ke database
    $result = $register->insertBuku($id, $judul,$penerbit, $pengarang, $tahun, $kategori,$harga, $foto);
    if($result==1){
        header("Refresh: 1; url=tampil_b.php");
        echo "<script>alert('Register Sukses , Silahkan Login Ulang');</script>";
    }
    else{
        echo "<script>alert('Register Gagal');</script>";
    }
};



include('template/header.php'); 
?>

<div class="container-fluid d-flex justify-content-center align-items-center">

                    <div class="card shadow mb-5 w-100 pb-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tambah Data Buku</h6>
                        </div>
                    <!-- Page Heading -->
                    <div class="w-100">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Create an Account!</h1>
                            </div>
                            <form method="post" class="user" enctype="multipart/form-data">

                            <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" id="exampleInputEmail"
                                        placeholder="id">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control" id="exampleInputEmail"
                                        placeholder="Judul">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" id="exampleInputEmail"
                                        placeholder="Penerbit">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Pengarang</label>
                                    <input type="text" name="pengarang" class="form-control" id="exampleInputEmail"
                                        placeholder="Kategori">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Tahun</label>
                                    <input type="text" name="tahun" class="form-control" id="exampleInputEmail"
                                        placeholder="Tahun">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Nama Kategori</label>
                                <select class="form-control" name="kategori_id">
                                <?php
                                $crudKategori = new CrudKategori();
                                $result = $crudKategori->tampilKategori();
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nama_kategori'] . "</option>";
                                }
                                ?>
                            </select>
                                </div>
                                <div class="form-group">
                                   <label for="exampleFormControlFile1">Harga</label>
                                    <input type="text" name="harga" class="form-control" id="exampleInputEmail"
                                        placeholder="Harga">
                                </div>
                                <div class="form-group">
    <label for="exampleFormControlFile1">Foto</label>
    <input type="file" name="foto" class="form-control-file" id="exampleFormControlFile1">
</div>
                                <button name="submit" type="submit" value="submit" class="w-25 btn btn-primary btn-user btn-block">
                                    Tambah Kategori
                                </button> 
                            </form>
                        </div>
                    </div>
                <!-- /.container-fluid -->

            </div>
        </div>

                <?php include('template/footer.php'); ?>