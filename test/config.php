<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "buku_kita";
    protected $koneksi;
 
    public function __construct(){
        if (!isset($this->koneksi)) {
            $this->koneksi = new mysqli($this->host, $this->username, $this->password, $this->database);
            if (!$this->koneksi) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }
        return $this->koneksi;
    }
}
 
class Buku extends Database {
    public function tampilBuku(){
        $sql = "SELECT * FROM buku";
        $perintah = $this->koneksi->query($sql);
        return $perintah;
    }
 
    public function searchBuku($keyword){
        $sql = "SELECT * FROM buku WHERE judul LIKE '%$keyword%' OR penerbit LIKE '%$keyword%' OR pengarang LIKE '%$keyword%' OR tahun LIKE '%$keyword%' OR kategori_id LIKE '%$keyword%' OR harga LIKE '%$keyword%'";
        $perintah = $this->koneksi->query($sql);
        return $perintah;
    }
}
?>
