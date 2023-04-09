<?php
// include koneksi database
require_once "../php/config.php";

// cek apakah form telah di-submit
if (isset($_POST["reset_password_submit"])) {
    // ambil data dari form
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // buat objek koneksi ke database
    $connection = new Connection();

    // query untuk mencari username yang diinputkan
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($connection->conn, $query);

    // cek apakah username ditemukan
    if (mysqli_num_rows($result) == 1) {
        // jika ditemukan, update password
        $row = mysqli_fetch_assoc($result);
        $query = "UPDATE user SET password = md5('$password') WHERE id = " . $row["id"];
        $result = mysqli_query($connection->conn, $query);

        // cek apakah password berhasil di-update
        if ($result) {
            // redirect ke halaman login dengan pesan sukses
            header("location: login.php?success=Password berhasil di-reset. Silahkan login dengan password baru.");
        } else {
            // jika gagal di-update, tampilkan pesan error
            $error_msg = "Terjadi kesalahan saat meng-update password. Silahkan coba lagi.";
        }
    } else {
        // jika username tidak ditemukan, tampilkan pesan error
        $error_msg = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

</head>
<style>
    .image{
        background: url(../img/4.jpg);
    background-position: center;
    background-size: cover;
    }
</style>
<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Reset Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your username below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <?php if (isset($error_msg)) { ?>
                                        <p>
                                            <?php echo $error_msg; ?>
                                        </p>
                                    <?php } ?>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="username"
                                                name="username" placeholder="Enter Username...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password"
                                                name="password" placeholder="Enter New Password...">
                                        </div>
                                        <button type="submit" name="reset_password_submit" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>