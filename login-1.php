<?php 
	session_start();
	include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<!--Page login -->
	<div class="page-login">
		
		<!-- box -->
		<div class="box box-login">

			<!-- box header -->
			<div class="box-header text-center">
				Login
			</div>

			<!-- box body -->
			<div class="box-body">
				
				<?php
					if(isset($_GET['msg'])){
						echo "<div class='alert alert-error'>".$_GET['msg']."</div>";
					}
				?>
				<!--Form login -->
				<form action="" method="post">
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="user" placeholder="Username" class="input-control">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="pass" placeholder="Password" class="input-control">
					</div>
					<input type="submit" name="submit" value="Login" class="btn">				
				</form>
				<?php
				if(isset($_POST['submit'])){
					$user = mysqli_real_escape_string($conn, $_POST['user']);
					$pass = mysqli_real_escape_string($conn, $_POST['pass']);

					$cek = mysqli_query($conn, "SELECT * FROM tb_petugas WHERE username='".$user."'");
					if(mysqli_num_rows($cek) >0){
						$d=mysqli_fetch_object($cek);
						if(md5($pass) == $d->password){

							$_SESSION['status_login'] = true;
							$_SESSION['uid']=$d->id_petugas;
							$_SESSION['uname']=$d->nama_petugas;
							$_SESSION['ulevel']=$d->level;
							
							echo "<script>window.location='admin/index.php'</script>";
							
						}else{
							echo '<div class="alert alert-error">Password salah</div>';
						}

					}else{
						echo '<div class="alert alert-error"> User tidak ditemukan</div>';
					}
				}
				?>
			</div>

			<!-- box footer -->
			<div class="box-footer">
				<a href="index.php">Halaman Utama </a>
			</div>
			
		</div>
	</div>
</body>
</html>