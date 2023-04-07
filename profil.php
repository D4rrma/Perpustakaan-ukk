<?php
require_once 'php/config.php';

// Make sure the user is logged in and the session variable is set
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

// Set the values of the level, phone, and address field
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

<body class="bg-primary">
  <a href="index.php" class="btn btn-secondary position-absolute top-0 start-0 m-3"><i
      class="fas fa-arrow-left"></i></a>

  <div class="container w-50 mt-4 mb-4 p-3 d-flex justify-content-center">
    <a href="dashboard.php" class="btn btn-secondary position-absolute top-0 ms-3"><i class="fas fa-arrow-left"></i></a>
    <div class="card w-100 p-4">
      <div class="d-flex flex-row justify-content-center align-items-center mt-3">
        <h3 class="text-title">Profil User</h3>
      </div>

      <div class=" image d-flex flex-column justify-content-center align-items-center"> <button
          class="btn btn-secondary"> <img src="img/2.jpg" height="300" width="300" /></button> <span class="name mt-3">
          <?php echo $data['nama']; ?>/
          <?php echo $data['level']; ?>
        </span>
        <div class="d-flex flex-row justify-content-center align-items-center gap-2"> <span class="idd1"><?php echo $data['tlp']; ?></span></div>
        <div class="d-flex flex-row justify-content-center align-items-center mt-3"> <span class="number"> <?php echo $data['alamat']; ?></span> </div>
        <div class=" d-flex mt-2"> <a class="btn1 btn-dark" href="edit-buku.php?id=<?php echo $row['id']; ?>">Edit Profile</a> </div>
        <div class=" px-2 rounded mt-4 date "> <span class="join">Joined May,2021</span> </div>
      </div>
    </div>
  </div>
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