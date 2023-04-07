<?php
      if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    class Connection {
        public $host = "localhost";
        public $user = "root";
        public $password = "";
        public $db_name = "buku_kita";
        public $conn;
    
        public function __construct() {
            $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->db_name);
            if (!$this->conn) {
                die("Failed to connect to database: " . mysqli_connect_error());
            }
        }
    }
    
    // class untuk register
        class Register extends Connection{
            public function registration($nik, $nama, $username, $password, $cpass){
                $duplicate=mysqli_query($this->conn, "SELECT * FROM user WHERE id ='$nik'");
                    if(mysqli_num_rows($duplicate)>0){
                    return 10;
                    //nik has already taken
                    }
                else{
                if($password==$cpass){
                    $query ="INSERT INTO user (id, nama, username, password) VALUES ('$nik', '$nama', '$username', md5('$password'))";
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

        //class untuk login
        class Login extends Connection{
            public $id;
            public $level; // tambahkan properti level
            
            public function loginan($username, $password,$level){
                $result = mysqli_query($this->conn, "SELECT * FROM user WHERE username ='$username' and password='$password' and level='$level'");
                $row = mysqli_fetch_assoc($result);
                if(mysqli_num_rows($result)>0){
                    if($password==$row["password"]){
                        $this->id=$row["id"];
                        $this->level=$row["level"];  // set properti level dengan nilai level dari database
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
                public function addCategory($id,$kategori){
                    $duplicate=mysqli_query($this->conn, "SELECT * FROM kategori WHERE id ='$id'");
                        if(mysqli_num_rows($duplicate)>0){
                        return 10;
                        //nik has already taken
                        }
                    else{
                    if($kategori){
                        $query ="INSERT INTO kategori (id,nama_kategori) VALUES ('$id', '$kategori')";
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

            class profil extends Connection{
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
                    public function editProfil($nama,$tlp, $alamat,$foto, $user_id){
                        $query ="update user set nama='$nama',tlp='$tlp', alamat='$alamat', foto='$foto' WHERE id='$user_id'";
                        mysqli_query($this->conn, $query);
                        return 1; 
                        }

                        public function tambahProfil($id, $judul,$penerbit, $pengarang, $tahun, $kategori,$harga, $foto){
                            $query = "INSERT INTO user (id, judul, penerbit, pengarang, tahun,kategori_id,harga, foto) VALUES ('$id', '$judul', '$penerbit', '$pengarang', '$tahun', '$kategori', '$harga', '$foto')";
                            mysqli_query($this->conn, $query);
                            return 1; 
                        }
            }
            // class untuk Kategori
            class CrudKategori extends Connection{
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
                public function insertKategori($nama, $username, $password, $telp, $level){
                $query ="INSERT INTO petugas (nama_petugas, username, password, telp, level) values ('$nama','$username','$password','$telp','$level')";
                mysqli_query($this->conn, $query);
                return 1; 
                }
                public function tampilKategori(){
                $sql="SELECT * FROM kategori";
                $perintah=$this->query($sql);
                return $perintah;
                }
                
                public function detailDataKategori($data){
                $sql="SELECT id, nama_kategori FROM kategori WHERE id=?";
                if($stmt=$this->conn->prepare($sql)):
                $stmt->bind_param("i",$param_data);
                $param_data=$data;
                if($stmt->execute()):
                $stmt->store_result();
                $stmt->bind_result($this->id, $this->nama_kategori);
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
                public function updateKategori($nama_petugas, $username, $password, $telp,$level, $data){
                $query ="update petugas set nama_petugas='$nama_petugas',username='$username', password='$password', telp='$telp', level='$level' WHERE id_petugas='$data'";
                mysqli_query($this->conn, $query);
                return 1; 
                }
                public function deleteKategori($data){
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





            // class untuk Buku
            class Buku extends Connection{
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
                            public function insertBuku($id, $judul,$penerbit, $pengarang, $tahun, $kategori,$harga, $foto){
                                $query = "INSERT INTO buku (id, judul, penerbit, pengarang, tahun,kategori_id,harga, foto) VALUES ('$id', '$judul', '$penerbit', '$pengarang', '$tahun', '$kategori', '$harga', '$foto')";
                                mysqli_query($this->conn, $query);
                                return 1; 
                            }
            
                            public function tampilBuku($halaman, $per_halaman) {
                                // Hitung offset berdasarkan halaman yang diminta
                                $offset = ($halaman - 1) * $per_halaman;
                                
                                $sql = "SELECT buku.*, kategori.nama_kategori as nama_kategori, kategori.id as id_kategori 
                                        FROM buku 
                                        INNER JOIN kategori ON buku.kategori_id = kategori.id
                                        LIMIT $per_halaman OFFSET $offset";
                                        
                                $perintah = $this->query($sql); 
                                return $perintah;
                            }
                            
                            public function detailDataBuku($data){
                            $sql="SELECT id,judul,penerbit,pengarang,tahun,kategori_id,harga FROM buku WHERE id=?";
                            if($stmt=$this->conn->prepare($sql)):
                            $stmt->bind_param("i",$param_data);
                            $param_data=$data;
                            if($stmt->execute()):
                            $stmt->store_result();
                            $stmt->bind_result($this->id, $this->judul, $this->penerbit, $this->pengarang, $this->tahun, $this->kategori_id, $this->harga);
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
                            public function updateBuku($judul, $penerbit, $pengarang, $tahun,$kategori_id,$harga, $data){
                            $query ="update buku set judul='$judul', penerbit='$penerbit', pengarang='$pengarang',tahun='$tahun', kategori_id='$kategori_id',  harga='$harga' WHERE id='$data'";
                            mysqli_query($this->conn, $query);
                            return 1; 
                            }
                            public function deleteBuku($data){
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
                            public function searchBuku($keyword, $halaman, $per_halaman) {
                                $offset = ($halaman - 1) * $per_halaman;
                                $sql = "SELECT buku.*, kategori.nama_kategori 
                                        FROM buku 
                                        INNER JOIN kategori ON buku.kategori_id = kategori.id 
                                        WHERE judul LIKE ? OR penerbit LIKE ? OR pengarang LIKE ? OR tahun LIKE ? OR kategori.nama_kategori LIKE ? OR harga LIKE ?
                                        LIMIT ? OFFSET ?";
                                $stmt = $this->conn->prepare($sql);
                                if (!$stmt) {
                                    die("Terjadi kesalahan pada prepare statement".$this->conn->error);
                                }
                                $searchTerm = "%" . $keyword . "%";
                                $stmt->bind_param("ssssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $per_halaman, $offset);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                return $result;
                            }
                            
                            public function countBuku() {
                                $query = "SELECT COUNT(*) AS total FROM buku";
                                $result = $this->conn->query($query);
                                $data = $result->fetch_assoc();
                                return $data['total'];
                            }
                            
                            public function countSearchBuku($keyword, $halaman, $per_halaman) {
                                $offset = ($halaman - 1) * $per_halaman;
                                $sql = "SELECT COUNT(*) AS total 
                                        FROM buku 
                                        INNER JOIN kategori ON buku.kategori_id = kategori.id 
                                        WHERE judul LIKE ? OR penerbit LIKE ? OR pengarang LIKE ? OR tahun LIKE ? OR kategori.nama_kategori LIKE ? OR harga LIKE ?
                                        LIMIT ? OFFSET ?";
                                $stmt = $this->conn->prepare($sql);
                                if (!$stmt) {
                                    die("Terjadi kesalahan pada prepare statement".$this->conn->error);
                                }
                                $searchTerm = "%" . $keyword . "%";
                                $stmt->bind_param("ssssssii", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $per_halaman, $offset);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $data = $result->fetch_assoc();
                                return $data['total'];
                            }
                            
                            
                            
                            
                           }

    
?>