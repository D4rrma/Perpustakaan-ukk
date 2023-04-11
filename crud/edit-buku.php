<?php
require_once('../php/config.php');
$obj = new Buku();
$user = new Connection();
$id = $_GET["id"];

$query = "SELECT * FROM buku WHERE id = ?";
$stmt = mysqli_prepare($user->conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);
if (!$data) {
  die("Eror: id buku not found");
}

if (isset($_POST["submit"])) {
    // Mendapatkan data dari form
    $id = $_POST["id"];
    $judul = $_POST["judul"];
    $penerbit = $_POST["penerbit"];
    $pengarang = $_POST["pengarang"];
    $tahun = $_POST["tahun"];
    $kategori_id = $_POST["kategori_id"];
    $harga = $_POST["harga"];
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] != UPLOAD_ERR_NO_FILE) {
      // Jika pengguna mengupload file baru, proses upload foto
      $foto = $_FILES["foto"]["name"];
      $foto_type = $_FILES["foto"]["type"];
      $foto_size = $_FILES["foto"]["size"];
  
      // Validasi tipe file dan ukuran file
      $allowed_types = array('image/jpeg', 'image/png', 'image/gif','image/svg');
      $max_size = 5 * 1024 * 1024; // 5MB
      if (!in_array($foto_type, $allowed_types) || $foto_size > $max_size) {
        echo "<script>alert('Tipe atau ukuran file tidak sesuai');</script>";
        exit;
      }
  
      $target_dir = "../img/img-buku/upload/";
      $target_file = $target_dir . basename($_FILES["foto"]["name"]);
      $i = 0;
      while (file_exists($target_file)) {
        $i++;
        $target_file = $target_dir . pathinfo($foto, PATHINFO_FILENAME) . '_' . $i . '.' . pathinfo($foto, PATHINFO_EXTENSION);
      }
      move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
      $foto = basename($target_file);
    } else {
      // Jika pengguna tidak mengupload file baru, gunakan nama file sebelumnya
      $foto = $data["foto"];
    }
  
    // Menambahkan data buku ke database
    $result = $obj->updateBuku($judul, $penerbit, $pengarang, $tahun, $kategori_id, $harga,$foto, $id);
    if ($result == 1) {
      header("Refresh: 1; url=../tampil_b.php");
      echo "<script>alert('Edit Behasil');</script>";
    } else {
      echo "<script>alert('Gagal');</script>";
    }
  }

include('../template/header-crud.php'); 
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
                            <form method="post" class="user" enctype="multipart/form-data">
                            <div class="form-group">
                                    <input type="hidden" name="id" class="form-control" id="exampleInputEmail"
                                        placeholder="Nama" value="<?php echo $data["id"];?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control" id="exampleInputEmail"
                                        placeholder="Judul"value="<?php echo $data["judul"];?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Penerbit</label>
                                    <input type="text" name="penerbit" class="form-control" id="exampleInputEmail"
                                        placeholder="Penerbit" value="<?php echo $data["penerbit"];?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Pengarang</label>
                                    <input type="text" name="pengarang" class="form-control" id="exampleInputEmail"
                                        placeholder="Kategori" value="<?php echo $data["pengarang"];?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Tahun</label>
                                    <input type="text" name="tahun" class="form-control" id="exampleInputEmail"
                                        placeholder="Tahun" value="<?php echo $data["tahun"];?>">
                                </div>
                                <div class="form-group">
                                <label for="exampleFormControlFile1">Kategori Id</label>
                                <select class="form-control" name="kategori_id">
                                <?php
                                $crudKategori = new CrudKategori();
                                $result = $crudKategori->tampilKategori();
                                while($row = mysqli_fetch_assoc($result)) {
                                    // tambahkan kondisi selected jika nilai id kategori sama dengan id kategori dari buku yang sedang diedit
                                    $selected = ($data['kategori_id'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nama_kategori'] . "</option>";
                                }
                                ?>
                                </select>
                                </div>
                                <div class="form-group">
                                   <label for="exampleFormControlFile1">Harga</label>
                                    <input type="text" name="harga" class="form-control" id="exampleInputEmail"
                                        placeholder="Harga" value="<?php echo $data["harga"];?>">
                                </div>
                                 <div class="form-group">
                        <label for="exampleFormControlFile1">Foto</label>
                        <input type="file" name="foto" class="form-control-file" id="exampleFormControlFile1">
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

                <?php include('../template/footer-crud.php'); ?>