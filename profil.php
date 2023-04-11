<?php
require_once 'php/config.php';
$register = new profil();
if (!isset($_SESSION["id"])) {
  header("Location: login.php");
  exit();
}
$user = new Connection();
$id = $_SESSION["id"];

$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($user->conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

// update data profil
if (isset($_POST["submit"])) {
  // Mendapatkan data dari form
  $user_id = $_POST["id"];
  $nama = $_POST["nama"];
  $tlp = $_POST["tlp"];
  $alamat = $_POST["alamat"];
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

    $target_dir = "img/user-img/";
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
  $result = $register->editProfil($nama, $tlp, $alamat, $foto, $user_id);
  if ($result == 1) {
    header("Refresh: 1; url=profil.php");
    echo "<script>alert('Edit Behasil');</script>";
  } else {
    echo "<script>alert('Gagal');</script>";
  }
}
;

?>

<!doctype html>
<html lang="en">

<head>
  <title>Profil User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<style>
  body {
    background-color: #f9f9fa
  }

  .padding {
    padding: 3rem !important
  }

  .user-card-full {
    overflow: hidden;
  }

  .card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
    border: none;
    margin-bottom: 30px;
  }

  .m-r-0 {
    margin-right: 0px;
  }

  .m-l-0 {
    margin-left: 0px;
  }

  .user-card-full .user-profile {
    border-radius: 5px 0 0 5px;
  }

  .bg-c-lite-green {
    background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
    background: linear-gradient(to right, #ee5a6f, #f29263);
  }

  .user-profile {
    padding: 20px 0;
  }

  .card-block {
    padding: 1.25rem;
  }

  .m-b-25 {
    margin-bottom: 25px;
  }

  .img-radius {
    border-radius: 5px;
  }



  h6 {
    font-size: 14px;
  }

  .card .card-block p {
    line-height: 25px;
  }

  @media only screen and (min-width: 1400px) {
    p {
      font-size: 14px;
    }
  }

  .card-block {
    padding: 1.25rem;
  }

  .b-b-default {
    border-bottom: 1px solid #e0e0e0;
  }

  .m-b-20 {
    margin-bottom: 20px;
  }

  .p-b-5 {
    padding-bottom: 5px !important;
  }

  .card .card-block p {
    line-height: 25px;
  }

  .m-b-10 {
    margin-bottom: 10px;
  }

  .text-muted {
    color: #919aa3 !important;
  }

  .b-b-default {
    border-bottom: 1px solid #e0e0e0;
  }

  .f-w-600 {
    font-weight: 600;
  }

  .m-b-20 {
    margin-bottom: 20px;
  }

  .m-t-40 {
    margin-top: 20px;
  }

  .p-b-5 {
    padding-bottom: 5px !important;
  }

  .m-b-10 {
    margin-bottom: 10px;
  }

  .m-t-40 {
    margin-top: 20px;
  }

  .user-card-full .social-link li {
    display: inline-block;
  }

  .user-card-full .social-link li a {
    font-size: 20px;
    margin: 0 10px 0 0;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
  }
</style>

<body class="bg-primary d-flex align-items-center w-100 vh-100 ">
  <a href="index.php" style="top:0; left:0;" class="btn btn-secondary position-absolute  m-3"><i
      class="fas fa-arrow-left"></i></a>

  <div class="container w-50 p-0 bg-light rounded">
      <div class="col p-0 ">
      <div class="col bg-gradient-warning p-4 d-flex flex-column align-items-center rounded-top">
      <?php 
        // periksa apakah foto pengguna kosong
        if(empty($data['foto'])) {
          // gunakan foto avatar default jika kosong
          echo '<img src="img/user-img/avatar-default.svg" width="200px" height="200px" class="img-thumnail border-dark rounded-circle" alt="User-Profile-Image">';
        } else {
          // gunakan foto pengguna jika tidak kosong
          echo '<img src="img/user-img/'.$data['foto'].'" width="200px" height="200px" class="img-thumnail border-white border-3 rounded-circle" alt="User-Profile-Image">';
        }
      ?>
      <hr>  
      <h6 class="f-w-600">
          <?php echo $data['nama']; ?>
        </h6>
          </div>
          <br>
        <h6 class="m-b-10  pl-3 b-b-default f-w-600">Information</h6>
        <div class="row pl-3">
          <div class="col-sm-6">
            <p class="m-b-10 f-w-600">Username</p>
            <h6 class="text-muted f-w-400">
              <?php echo $data['username']; ?>
            </h6>
          </div>
          <div class="col-sm-6">
            <p class="m-b-10 f-w-600">Phone</p>
            <h6 class="text-muted f-w-400">
              <?php echo $data['tlp']; ?>
            </h6>
          </div>
          </div>
          <h6 class="m-b-10 mt-3 pl-3 b-b-default f-w-600">Adress</h6>
          <div class="row pl-3">
          <div class="col-sm-6">
            <p class="m-b-10 f-w-600">Recent</p>
            <h6 class="text-muted f-w-400">
              <?php echo $data['nama']; ?>
            </h6>
          </div>
          <div class="col-sm-6">
            <p class="m-b-10 f-w-600">From</p>
            <h6 class="text-muted f-w-400">
              <?php echo $data['alamat']; ?>
            </h6>
          </div>
          <button type="button" style="right:0; top:0;" class="btn btn-dark btn-circle position-absolute mr-3 mt-3 "
            data-toggle="modal" data-target="#editModal<?php echo $data['id']; ?>"><i
              class="fas fa-fw fa-cog"></i></button>
        </div>
      </div>
  </div>


  <div class="modal fade " id="editModal<?php echo $data['id']; ?>" tabindex="-1" role="dialog"
    aria-labelledby="editModalLabel<?php echo $data['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel<?php echo $data['id']; ?>">
            Edit Profil</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post" enctype="multipart/form-data" class="user">
          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="id" class="form-control" id="exampleInputEmail" placeholder="id"
                value="<?php echo $data["id"]; ?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlFile1">Nama User</label>
              <input type="text" name="nama" class="form-control" id="exampleInputEmail" placeholder="nama"
                value="<?php echo $data["nama"]; ?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlFile1">Nomor Telepon</label>
              <input type="text" name="tlp" class="form-control" id="exampleInputEmail" placeholder="Nomor Telepon"
                value="<?php echo $data["tlp"]; ?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlFile1">Alamat</label>
              <input type="text" name="alamat" class="form-control" id="exampleInputEmail" placeholder="Alamat"
                value="<?php echo $data["alamat"]; ?>">
            </div>
            <div class="form-group">
              <label for="exampleFormControlFile1">Foto</label>
              <input type="file" name="foto" class="form-control-file" id="exampleFormControlFile1">
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <script src="../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="../js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
  <script src="../js/demo/chart-pie-demo.js"></script>

</body>

</html>