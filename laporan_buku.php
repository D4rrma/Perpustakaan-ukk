<?php
require 'php/config.php';
if (file_exists('php/tcpdf/tcpdf.php')) {
    require_once 'php/tcpdf/tcpdf.php';
} else {
    echo 'File TCPDF tidak ditemukan.';
}

$buku = new Buku();
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Menghitung total data yang ditemukan
$total_data = $buku->countBuku($cari);

// Menentukan jumlah data per halaman
$per_halaman = 5;

// Menghitung jumlah halaman
$total_halaman = ceil($total_data / $per_halaman);

// Menentukan halaman yang ditampilkan
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman = max($halaman, 1); // Halaman minimum adalah 1
$halaman = min($halaman, $total_halaman); // Halaman maksimum adalah total halaman

// Mengambil data buku berdasarkan kata kunci pencarian
$result = $buku->searchBuku($cari, $halaman, $per_halaman);

// Membuat objek TCPDF dan menentukan konfigurasi awal
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetMargins(10, 15, 15);
$pdf->AddPage();

// Menambahkan judul laporan
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Data Buku', 0, true, 'C');

// Menambahkan keterangan jumlah data yang ditemukan
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, 'Jumlah data: ' . $total_data, 0, 1, 'R');

// Menambahkan keterangan kata kunci pencarian
if (!empty($cari)) {
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 5, 'Kata kunci pencarian: ' . $cari, 0, 1, 'R');
}

$pdf->Ln(10);

// Menambahkan header tabel
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(10, 7, 'No.', 1, 0, 'C');
$pdf->Cell(45, 7, 'Judul Buku', 1, 0, 'C');
$pdf->Cell(30, 7, 'Penerbit', 1, 0, 'C');
$pdf->Cell(30, 7, 'Pengarang', 1, 0, 'C');
$pdf->Cell(20, 7, 'Tahun', 1, 0, 'C');
$pdf->Cell(30, 7, 'Kategori', 1, 0, 'C');
$pdf->Cell(30, 7, 'Harga', 1, 1, 'C');

// Menambahkan data buku ke dalam tabel
$no = ($halaman - 1) * $per_halaman;

$pdf->SetFont('helvetica', '', 10);

while ($row = mysqli_fetch_assoc($result)) {
    $no++;
    $pdf->Cell(10
, 7, $no, 1, 0, 'C');
$pdf->Cell(45, 7, $row['judul'], 1, 0);
$pdf->Cell(30, 7, $row['penerbit'], 1, 0);
$pdf->Cell(30, 7, $row['pengarang'], 1, 0);
$pdf->Cell(20, 7, $row['tahun'], 1, 0, 'C');
$pdf->Cell(30, 7, $row['nama_kategori'], 1, 0);
$pdf->Cell(30, 7, 'Rp. ' . number_format($row['harga'], 0, ',', '.'), 1, 1, 'R');
}

// Menambahkan pagination
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, 'Halaman ' . $halaman . ' dari ' . $total_halaman, 0, 1, 'C');
$pdf->Cell(0, 5, '', 0, 1, 'C');
$pdf->Cell(0, 5, '', 0, 1, 'C');
$pdf->Cell(0, 5, '', 0, 1, 'C');
$pdf->Cell(0, 5, '', 0, 1, 'C');

if ($total_halaman > 1) {
$pdf->Ln(10);
$pdf->SetFont('helvetica', '', 10);

// Menambahkan link pagination untuk halaman sebelumnya
if ($halaman > 1) {
    $pdf->Cell(30, 7, '<<', 1, 0, 'C', false, '?cari=' . $cari . '&halaman=' . ($halaman - 1));
} else {
    $pdf->Cell(30, 7, '<<', 1, 0, 'C', false, '');
}

// Menambahkan nomor halaman dan link pagination
for ($i = 1; $i <= $total_halaman; $i++) {
    $pdf->Cell(10, 7, $i, 1, 0, 'C', false, '?cari=' . $cari . '&halaman=' . $i);
}

// Menambahkan link pagination untuk halaman berikutnya
if ($halaman < $total_halaman) {
    $pdf->Cell(30, 7, '>>', 1, 0, 'C', false, '?cari=' . $cari . '&halaman=' . ($halaman + 1));
} else {
    $pdf->Cell(30, 7, '>>', 1, 0, 'C', false, '');
}
}

// Menampilkan hasil dalam format PDF dan mengakhiri sesi
$pdf->Output('laporan-data-buku.pdf', 'I');
exit();


?>
