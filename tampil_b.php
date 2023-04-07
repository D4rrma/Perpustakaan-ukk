<?php
require_once 'php/config.php';
include('template/header.php');

$buku = new Buku();

// Set jumlah data per halaman
$per_halaman = 10;

// Ambil halaman saat ini
if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
} else {
    $halaman = 1;
}

if (isset($_GET['cari'])) {
    $keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
    $result = $buku->searchBuku($keyword, $halaman, $per_halaman);
    $total_data = $buku->countSearchBuku($keyword, $halaman, $per_halaman);
} else {
    $result = $buku->tampilBuku($halaman, $per_halaman);
    $total_data = $buku->countBuku();
}

// Hitung jumlah halaman
$total_halaman = ceil($total_data / $per_halaman);

?>

<div class="container-fluid d-flex flex-column justify-content-center align-items-center">
    <div class="card shadow mb-5 w-100 pb-5">
        <div class="card-header row d-flex align-items-center ">
            <div class="col-md-8">
                <div class="d-flex justify-content-start">
                    <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <form method="get" action="" class="form-inline my-2 my-lg-0">
                    <div class="input-group">
                        <input type="text" name="cari" class="form-control bg-light border-0 small"
                            placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" value="Cari">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            if (isset($_GET['cari'])) {
                $cari = $_GET['cari'];
                echo "<div class='col-md-12 mt-3 d-flex justify-content-end'><b0>Hasil pencarian : " . $cari . "</b0></div>";
            }
            ?>

        </div>
        <div class="w-100">
            <div class="p-5">
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="tambah_b.php" class="btn btn-primary mr-2">
                        <i class="fas fa-plus-circle"></i> Tambah Buku
                    </a>
                    <a href="detail-buku.php" class="btn btn-secondary">
                        <i class="fas fa-info-circle"></i> Laporan Buku
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-5">Data Buku</h1>

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr>
                                <th>No.</th>
                                <th>Judul Buku</th>
                                <th>Penerbit</th>
                                <th>Pengarang</th>
                                <th>Tahun Terbit</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Foto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $per_halaman * ($halaman - 1) + 1;
                            while ($data = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $no++; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['judul']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['penerbit']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['pengarang']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['tahun']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['nama_kategori']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['harga']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['foto']; ?>
                                    </td>
                                    <?php if($_SESSION['level']=='admin'){?>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-info btn-circle mr-2" data-toggle="modal"
                                            data-target="#detailModal<?php echo $data['id']; ?>">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                        
                                        <a href="edit-buku.php?id=<?php echo $data['id']; ?>"
                                            class="btn btn-warning btn-circle mr-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="hapus-buku.php?id=<?php echo $data['id']; ?>"
                                            class="btn btn-danger btn-circle"
                                            onclick="return confirm('Anda yakin ingin menghapus buku ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    <?php }elseif($_SESSION['level']=='user'){?>
                                    <td class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-info btn-circle mr-2" data-toggle="modal"
                                            data-target="#detailModal<?php echo $data['id']; ?>">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <!-- isi data tabel disini -->
                                <div class="modal fade" id="detailModal<?php echo $data['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="detailModalLabel<?php echo $data['id']; ?>"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="detailModalLabel<?php echo $data['id']; ?>">
                                                    Detail Buku</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <img src="img/<?php echo $data['foto']; ?>"
                                                            alt="<?php echo $data['judul']; ?>" class="img-fluid">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p><strong>Judul:</strong>
                                                            <?php echo $data['judul']; ?>
                                                        </p>
                                                        <p><strong>Penulis:</strong>
                                                            <?php echo $data['pengarang']; ?>
                                                        </p>
                                                        <p><strong>Penerbit:</strong>
                                                            <?php echo $data['penerbit']; ?>
                                                        </p>
                                                        <p><strong>Tahun Terbit:</strong>
                                                            <?php echo $data['tahun']; ?>
                                                        </p>
                                                        <p><strong>Kategori:</strong>
                                                            <?php echo $data['nama_kategori']; ?>
                                                        </p>
                                                        <p><strong>Harga:</strong>
                                                            <?php echo $data['harga']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
                <!-- Tombol halaman -->
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <?php
                                if ($halaman > 1) {
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?halaman=<?php echo $halaman - 1; ?>"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>

                                <?php
                                for ($i = 1; $i <= $total_halaman; $i++) {
                                    ?>
                                    <li class="page-item <?php if ($halaman == $i) {
                                        echo 'active';
                                    } ?>"><a class="page-link"
                                            href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                    <?php
                                }
                                ?>

                                <?php
                                if ($halaman < $total_halaman) {
                                    ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?halaman=<?php echo $halaman + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <!-- End of Content Wrapper -->

</div>
</div>
<?php include('template/footer.php'); ?>