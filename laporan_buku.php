<?php
require '../php/config.php';
require_once('php/tcpdf/tcpdf.php');
$obj=new Buku();

// buat objek TCPDF baru
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// atur judul laporan
$pdf->SetTitle('Laporan Buku');

// atur margin halaman
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// tambahkan halaman baru
$pdf->AddPage();

// tampilkan data buku dalam format tabel
$html = '<table border="1">';
$html .= '<tr><th>No</th><th>Id</th><th>Judul</th><th>Penerbit</th><th>Pengarang</th><th>Tahun</th><th>Id Kategori</th><th>Harga</th></tr>';
$no = 1;
$data = $obj->tampilBuku();
while ($row = $data->fetch_array()) {
    $html .= '<tr>';
    $html .= '<td>' . $no++ . '</td>';
    $html .= '<td>' . $row['id'] . '</td>';
    $html .= '<td>' . $row['judul'] . '</td>';
    $html .= '<td>' . $row['penerbit'] . '</td>';
    $html .= '<td>' . $row['pengarang'] . '</td>';
    $html .= '<td>' . $row['tahun'] . '</td>';
    $html .= '<td>' . $row['kategori_id'] . '</td>';
    $html .= '<td>' . $row['harga'] . '</td>';
    $html .= '</tr>';
}
$html .= '</table>';

// tampilkan data tabel di dalam file PDF
$pdf->writeHTML($html, true, false, true, false, '');

// simpan file PDF di server
$pdf->Output('laporan_buku.pdf', 'D');

?>
