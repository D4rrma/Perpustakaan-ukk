<?php
require_once 'config.php';
 
$buku = new Buku();
if(isset($_GET['cari'])){
    $keyword = isset($_GET['cari']) ? $_GET['cari'] : '';
    $result = $buku->searchBuku($keyword);
} else {
    $result = $buku->tampilBuku();
}
?>
 
 
<form method="get">
    <label>Cari :</label>
    <input type="text" name="cari">
    <input type="submit" value="Cari">
</form>
 
<?php 
if(isset($_GET['cari'])){
    $cari = $_GET['cari'];
    echo "<b>Hasil pencarian : ".$cari."</b>";
}
?>
 
<table border="1">
    <tr>
        <th>No</th>
        <th>Judul</th>
        <th>Penerbit</th>
        <th>Pengarang</th>
        <th>Tahun</th>
        <th>Id Kategori</th>
        <th>Harga</th>
    </tr>
    <?php 
    $no=1;
    while ($row = $result->fetch_array()){ 
    ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['judul']; ?></td>
            <td><?php echo $row['penerbit']; ?></td>
            <td><?php echo $row['pengarang']; ?></td>
            <td><?php echo $row['tahun']; ?></td>
            <td><?php echo $row['kategori_id']; ?></td>
            <td><?php echo $row['harga']; ?></td>
        </tr> 
    <?php
    } 
    ?>
</table>
