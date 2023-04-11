<?php
session_start();
class Connection{
public $host="localhost";
public $user ="root";
public $password="";
public $db_name="buku_kita";
public $conn;
public function __construct(){
    $this->conn = mysqli_connect($this->host, $this->user, $this->password,$this->db_name);
        if($this->conn==false)die("tidak dapat tersambung ke database".$this->conn->connect_error());
            return $this->conn;
    }
}
class Register extends Connection{
public function registration($id, $nama, $username, $password, $cpass, $level){
$duplicate=mysqli_query($this->conn, "SELECT * FROM user WHERE id ='$id'");
    if(mysqli_num_rows($duplicate)>0){
        return 10;
    }
        else{
                if($password==$cpass){
                     $query ="INSERT INTO user (id, nama, username, password, level) VALUES ('$id', '$nama', '$username', md5('$password'), '$level')";
                mysqli_query($this->conn, $query);
            return 1;
        }
            else{
                return 100;
            //password does not match
            }
        }
    }
}

class Login extends Connection{
public $id;
public $level;

public function loginan($username, $password, $level){
    $result = mysqli_query($this->conn, "SELECT * FROM user WHERE username ='$username' and password='$password' and level='$level'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result)>0){
        if($password==$row["password"]){
            $this->id=$row["id"];
            $this->level=$row["level"];
            return 1;
// login success
}
else{
return 10;
//wrong password
    }
}
else{
return 100;
//user not registered
    }
}

public function idUser(){
return $this->id;
    }

public function getLevel(){
return $this->level;
    }

}

class Tambah extends Connection{
    public function addcategory($id, $kategori){
    $duplicate=mysqli_query($this->conn, "SELECT * FROM kategori WHERE id ='$id'");
    if(mysqli_num_rows($duplicate)>0){
    return 10;
    //nik has already taken
    }
    else{
    if($kategori==$kategori){
    $query ="INSERT INTO kategori (id, nama_kategori) VALUES ('$id', '$kategori')";
    mysqli_query($this->conn, $query);
    return 1;
    //register successful
    }
    else{
    return 100;
    //password does not match
                }
            }
        }
    }


class Crudkategori extends Connection {
        public function prepare($data){
            $perintah = $this->conn->prepare($data);
            if(!$perintah)die("Terjadi kesalahan pada prepare statement".$this->conn->error);
            return $perintah;
        }
    public function query($data){
        $perintah = $this->conn->query($data);
        if(!$perintah)die("Terjadi kesalahan pada query statement".$this->conn->error);
            return $perintah;
        }
        public function insertkategori($id, $nama){
        $query ="INSERT INTO kategori (id, nama_pengaduan) values ('$id','$nama')";
        mysqli_query($this->conn, $query);
        return 1; 
        }
        public function tampilkategori(){
        $sql="SELECT id, nama_kategori FROM kategori";
        $perintah=$this->query($sql);
        return $perintah;
        }
        public function detailDatakategori($data){
        $sql="SELECT id, nama_kategori FROM kategori WHERE id=?";
        if($stmt=$this->conn->prepare($sql)):
        $stmt->bind_param("i",$param_data);
        $param_data=$data;
        if($stmt->execute()):
        $stmt->store_result();
        $stmt->bind_result($this->id, $this->kategori);
        $stmt->fetch();
        if($stmt->num_rows==1):
        return true;
        else: 
        return false;
        endif;
        endif;
        endif; 
        $stmt->close();
        }
        public function updateKategori($id, $namaKategori){
        $query ="update Kategori set id='$id',namaKategori='$namaKategori'";
        mysqli_query($this->conn, $query);
        return 1; 
        }
        public function deletekategori($data){
        $sql="DELETE FROM kategori WHERE id=?";
        if($stmt=$this->prepare($sql)):
        $stmt->bind_param("i",$param_data);
        $param_data=$data;
        if($stmt->execute()):
        return true;
        else: 
        return false;
        endif;
        endif;
        $stmt->close();
        }
       }


class Tambahbuku extends Connection{
        public function addbuku($id,$judul,$deskripsi,$penerbit,$pengarang,$tahun,$kategori_id,$harga){
        $duplicate=mysqli_query($this->conn, "SELECT * FROM buku WHERE id ='$id'");
        if(mysqli_num_rows($duplicate)>0){
        return 10;
        //nik has already taken
        }
        else{
        if($judul==$judul){
        $query ="INSERT INTO buku (id, judul, deskripsi, penerbit, pengarang, tahun, kategori_id, harga) VALUES ('$id','$judul','$deskripsi','$penerbit','$pengarang','$tahun','$kategori_id','$harga')";
        mysqli_query($this->conn, $query);
        return 1;
        //register successful
        }
        else{
        return 100;
        //password does not match
                    }
                }
            }
        }


class Crudbuku extends Connection {
        public function prepare($data){
            $perintah = $this->conn->prepare($data);
            if(!$perintah)die("Terjadi kesalahan pada prepare statement".$this->conn->error);
            return $perintah;
        }
    public function query($data){
        $perintah = $this->conn->query($data);
        if(!$perintah)die("Terjadi kesalahan pada query statement".$this->conn->error);
            return $perintah;
        }
        public function insertbuku($id,$judul,$deskripsi,$penerbit,$pengarang,$tahun,$kategori_id,$harga){
        $query ="INSERT INTO buku (id, judul, deskripsi, penerbit, pengarang, tahun, kategori_id, harga) values ('$id','$judul', '$deskripsi','$penerbit','$pengarang','$tahun','$kategori_id','$harga')";
        mysqli_query($this->conn, $query);
        return 1; 
        }
        public function tampilBuku(){
            $sql = "SELECT buku.*, kategori.nama_kategori as nama_kategori, kategori.id as id_kategori FROM buku INNER JOIN kategori ON buku.kategori_id = kategori.id";
            $perintah = $this->conn->query($sql);
            return $perintah;
        }
        public function detailDatabuku($data){
        $sql="SELECT id, judul, deskripsi, penerbit, pengarang, tahun, kategori_id, harga FROM buku WHERE id=?";
        if($stmt=$this->conn->prepare($sql)):
        $stmt->bind_param("i",$param_data);
        $param_data=$data;
        if($stmt->execute()):
        $stmt->store_result();
        $stmt->bind_result($this->id, $this->judul,$this->deskripsi,$this->penerbit,$this->pengarang,$this->tahun,$this->kategori_id,$this->harga);
        $stmt->fetch();
        if($stmt->num_rows==1):
        return true;
        else: 
        return false;
        endif;
        endif;
        endif; 
        $stmt->close();
        }
        public function updatebuku($id,$judul,$deskripsi,$penerbit,$pengarang,$tahun,$kategori_id,$harga){
        $query ="update buku set id ='$id',judul='$judul',deskripsi='$deskripsi', penerbit='$penerbit', pengarang='$pengarang', tahun='$tahun', kategori_id='$kategori_id', harga='$harga' WHERE id='$id'";
        mysqli_query($this->conn, $query);
        return 1; 
        }
        public function deletebuku($data){
        $sql="DELETE FROM buku WHERE id=?";
        if($stmt=$this->prepare($sql)):
        $stmt->bind_param("i",$param_data);
        $param_data=$data;
        if($stmt->execute()):
        return true;
        else: 
        return false;
        endif;
        endif;
        $stmt->close();
        }
        
        public function searchBuku($keyword){
            $sql = "SELECT buku.*, kategori.nama_kategori AS nama_kategori, kategori.id AS id_kategori 
            FROM buku 
            INNER JOIN kategori 
            ON buku.kategori_id = kategori.id 
            WHERE buku.judul LIKE '%$keyword%' OR buku.penerbit LIKE '%$keyword%' OR buku.pengarang LIKE '%$keyword%' OR buku.tahun LIKE '%$keyword%' OR kategori.nama_kategori LIKE '%$keyword%' OR buku.harga LIKE '%$keyword%'";
            $perintah = $this->conn->query($sql);
            return $perintah;
        }
    }
    
    class profil extends Connection
    {
        public function prepare($data)
        {
            $perintah = $this->conn->prepare($data);
            if (!$perintah)
                die("Terjadi kesalahan pada prepare statement" . $this->conn->error);
            return $perintah;
        }
        public function query($data)
        {
            $perintah = $this->conn->query($data);
            if (!$perintah)
                die("Terjadi kesalahan pada query statement" . $this->conn->error);
            return $perintah;
        }
        public function editProfil($nama,$username, $user_id)
        {
            $query = "update user set nama='$nama',username='$username' WHERE id='$user_id'";
            mysqli_query($this->conn, $query);
            return 1;
        }
    }
?>

