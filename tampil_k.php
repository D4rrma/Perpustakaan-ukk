<?php
require 'php/config.php';
include('template/header.php');
$obj = new CrudKategori;
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
                    <a href="crud/tambah_k.php" class="btn btn-primary mr-2">
                        <i class="fas fa-plus-circle"></i> Tambah Kategori
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-5">Create an Account!</h1>
                </div>
                <div class="table-responsive">
                    <table class="table text-center" width="100%">
                        <thead class="thead-primary">
                            <tr>
                                <th>No</th>
                                <th>Id</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $no = 1;
                        $data = $obj->tampilKategori();
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
                                    <?php echo $row['nama_kategori']; ?>
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
<?php include 'template/footer.php' ?>