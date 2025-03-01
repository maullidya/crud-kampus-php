<?php
ob_start();
include "../conf/conn.php";
require_once("../plugins/dompdf/autoload.inc.php");

use Dompdf\Dompdf;
$dompdf = new Dompdf();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE id_mahasiswa = $id LIMIT 1");

  if ($row = mysqli_fetch_array($query)) {
    $html = '<center><h3>Data Mahasiswa</h3></center><hr/><br/>';
    $html .= '<table border="1" width="100%">
    <tr><th>Nim</th><th>Nama</th><th>Kelas</th><th>Jurusan</th></tr>';
    $html .= "<tr><td>".$row['nim']."</td><td>".$row['nama']."</td><td>".$row['kelas']."</td><td>".$row['jurusan']."</td></tr>";

    $html .= "</table>";
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'potrait');
    $dompdf->render();
    $dompdf->stream('laporan_mahasiswa.pdf');
  } else {
    echo "Data mahasiswa tidak ditemukan.";
  }
} else {
  $query = mysqli_query($connection, "SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");

  $html = '<center><h3>Daftar Nama Mahasiswa</h3></center><hr/><br/>';
  $html .= '<table border="1" width="100%">
  <tr><th>Nim</th><th>Nama</th><th>Kelas</th><th>Jurusan</th></tr>';
  
  while ($row = mysqli_fetch_array($query)) {
    $html .= "<tr><td>".$row['nim']."</td><td>".$row['nama']."</td><td>".$row['kelas']."</td><td>".$row['jurusan']."</td></tr>";
  }

  $html .= "</table>";
  $dompdf->loadHtml($html);
  $dompdf->setPaper('A4', 'potrait');
  $dompdf->render();
  $dompdf->stream('daftar_nama_mahasiswa.pdf');
}
?>