<?php
include "../../conf/conn.php";
if($_POST)
{
$id = $_POST['id'];
$nim = $_POST['nim'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$jurusan = $_POST['jurusan'];
$query = ("UPDATE mahasiswa SET nim='$nim',nama='$nama',kelas='$kelas',jurusan='$jurusan' WHERE id_mahasiswa ='$id'");
echo $query;

if(!mysqli_query($koneksi, "$query")){
    die(mysqli_error($koneksi));
    }else{
echo '<script>alert("Data Berhasil Diubah !!!");
window.location.href="../../index.php?page=data_mahasiswa"</script>';
}


}

?>