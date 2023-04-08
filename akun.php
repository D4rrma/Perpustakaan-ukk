<?php
require 'php/config.php';
include('template/header.php');
$obj = new profil();
?>


<!-- Begin Page Content -->
<div class="container-fluid d-flex justify-content-center align-items-center">

    <div class="card shadow mb-5 w-100 pb-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <!-- Page Heading -->
        <div class="w-100">
            <div class="p-5">
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="tambah_k.php" class="btn btn-primary mr-2">
                        <i class="fas fa-plus-circle"></i> Tambah Akun
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-5">Data Akun </h1>
                </div>
                <div class="table-responsive">
                    <table class="table text-center" width="100%">
                        <thead class="thead-primary">
                            <tr>
                                <th>No</th>
                                <th>Id</th>
                                <th>Nama </th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $no = 1;
                        $data = $obj->tampilAkun();
                        while ($row = $data->fetch_array()) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $no++; ?>
                                </td>
                                <td>
                                    <?php echo $row['id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['nama']; ?>
                                </td>
                                <td>
                                    <?php echo $row['username']; ?>
                                </td>
                                <td>
                                    <?php echo $row['password']; ?>
                                </td>
                                <td>
                                <a href="delete-buku.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-circle"
                                            onclick="return confirm('Anda yakin ingin menghapus buku ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bot bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
        </div>
    </div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/chart-area-demo.js"></script>
<script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>