<?php 
require 'php/config.php';

$register=new Tambah();
if(isset($_POST["submit"])){
	$result = $register->addCategory($_POST["id_p"],$_POST["nama"]);
	if($result==1){
		header("Refresh: 1; url=tampil_k.php");
		echo "<script>alert('Register Sukses , Silahkan Login Ulang');</script>";
	}
	elseif($result==10){
		echo "<script>alert('Username or Email Has Alrady Taken');</script>";
	}
	elseif($result==100){
	echo "<script>alert('Password does not match');</script>";
	}
}
include('template/header.php'); 
?>

<div class="container-fluid d-flex justify-content-center align-items-center">

                    <div class="card shadow mb-5 w-100 pb-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                    <!-- Page Heading -->
                    <div class="w-100">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-5">Create an Account!</h1>
                            </div>
                            <form method="post" class="user">
                            <div class="form-group">
                                    <input type="hidden" name="id_p" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Nama">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nama" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Nama Kategori">
                                </div>
                                <button name="submit" type="submit" value="submit" class="w-25 btn btn-primary btn-user btn-block">
                                    Tambah Kategori
                                </button>
                            </form>
                        </div>
                    </div>
                <!-- /.container-fluid -->

            </div>
                </div>

                <?php include('template/footer.php'); ?>