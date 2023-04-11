<?php
require_once 'config.php';
include('../template/header.php');
$buku = new CrudBuku();
if(isset($_GET['cari'])){
    $keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
    $result = $buku->searchBuku($keyword);
} else {
    $result = $buku->tampilbuku();
}
?>


     <!-- Begin Page Content -->
     <div class="container-fluid">
     <?php 
        if(isset($_GET['cari'])){
        $cari = $_GET['cari'];
        echo "<b class='p-3'>Hasil pencarian : ".$cari."</b>";
        }
      ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Buku</h1>
  <a href="tambah-b.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Tambah Buku</a>
</div>
</div>
 
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

<table class="table table-bordered table-striped text-center" id="dataTable" width="100%" cellspacing="0">
        <tr>
          <th>No</th>
          <th>id</th>
          <th>judul</th>
          <th>Penerbit</th>
          <th>Pengarang</th>
          <th>Tahun</th>
          <th>kategori</th>
          <th>Harga</th>
          <th>Aksi</th>
        </tr> 
      
<?php 
 $no=1;
 while ($row=$result->fetch_array()){ 
?>
 <tr>
  <td><?php echo $no++; ?></td>
  <td><?php echo $row['id']; ?></td>
  <td><?php echo $row['judul']; ?></td>
  <td><?php echo $row['penerbit']; ?></td>
  <td><?php echo $row['pengarang']; ?></td>
  <td><?php echo $row['tahun']; ?></td>
  <td><?php echo $row['nama_kategori']; ?></td>
  <td><?php echo $row['harga']; ?></td>
 <td>
  <a style="color:blue;" href="edit-b.php?id=<?php echo $row['id']; ?>">Edit | </a>
  <a style="color:blue;" href="hapus-b.php?id=<?php echo $row['id']; ?>"onclick="return confirm('Yakin Hapus?')">Hapus</a> 
 </td>
 </tr> 
<?php
 } 
?>

</table>

<!-- End of Page Wrapper -->

<?php include('../template/footer.php');?>