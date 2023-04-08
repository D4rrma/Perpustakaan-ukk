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

?>
<div class="h1 pl-3">Selamat Datang
    <?php echo $data["nama"] ?>
</div>

<?php include('template/footer.php'); ?>