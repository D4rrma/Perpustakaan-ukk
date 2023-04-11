<?php
require_once 'php/config.php';
include('template/header.php');
$user = new Connection();
$id = $_SESSION["id"];


$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($user->conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

$query1 = "SELECT COUNT(*) as buku FROM buku";
$result = mysqli_query($user->conn, $query1);
$jumlahbuku = mysqli_fetch_assoc($result);

$query2 = "SELECT COUNT(*) as kategori FROM kategori";
$result = mysqli_query($user->conn, $query2);
$jumlahkategori = mysqli_fetch_assoc($result);
?>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <?php echo '<h1 class="h3 mb-0 text-gray-800">Selamat Datang '.$data["nama"].' di Dashboard Perpustakaan</h1> '?>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahbuku['buku']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                           <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Kategori</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $jumlahkategori['kategori']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

<?php include('template/footer.php'); ?>