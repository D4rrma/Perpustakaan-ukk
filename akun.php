<?php
require 'php/config.php';

$obj = new profil();

$register = new Register();
if (isset($_POST["submit"])) {
    $result = $register->registration($_POST["id"], $_POST["nama"], $_POST["username"], $_POST["password"], $_POST["cpass"], $_POST["level"]);
    if ($result == 1) {
        header("Refresh: 1; url=Akun.php");
        echo "<script>alert('Register Sukses , Silahkan Login Ulang');</script>";
    } elseif ($result == 10) {
        echo "<script>alert('Username or Email Has Alrady Taken');</script>";
    } elseif ($result == 100) {
        echo "<script>alert('Password does not match');</script>";
    }
}
include('template/header.php');
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
                    <!-- <a href="tambah_akun.php" class="btn btn-primary mr-2">
                        <i class="fas fa-plus-circle"></i> Tambah Akun
                    </a> -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        <i class="fas fa-plus-circle pr-1"></i>Tambah Akun Admin
                    </button>
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
                                <th>Level</th>
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
                                    <?php echo $row['level']; ?>
                                </td>
                                <td>
                                    <a href="crud/delete-akun.php?id=<?php echo $row['id']; ?>"
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

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Akun Admin</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form method="post" class="user">
                    <div class="form-group">
                        <input type="hidden" name="id" class="form-control form-control-user" placeholder="Id">
                    </div>
                    <div class="form-group">
                        <input type="text" name="nama" class="form-control form-control-user" placeholder="Nama">
                    </div>
                    <div class="form-group">
                        <input type="text" name="username" class="form-control form-control-user"
                            placeholder="Username">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" name="password" class="form-control form-control-user"
                                placeholder="Password">
                        </div>
                        <div class="col-sm-6">
                            <input type="password" name="cpass" class="form-control form-control-user"
                                placeholder="Repeat Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="level" class="form-control form-control-user" value="admin"
                            placeholder="level">
                    </div>
                    <button name="submit" href="login.html" class="btn btn-primary btn-user btn-block">
                        Register Account
                    </button>
                </form>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End of Main Content -->

<!-- Footer -->
<?php include 'template/footer.php' ?>