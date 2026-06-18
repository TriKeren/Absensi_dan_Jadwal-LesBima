<?php
$host     = "localhost";
$username = "root";
$password = "";
$database = "les_bima_db";
$koneksi = mysqli_connect($host, $username, $password, $database);

if (isset($_GET['id'])) {
    $id_guru = (int) $_GET['id'];
    
    $query_hapus = "DELETE FROM guru WHERE id_guru = $id_guru";
    $hasil_hapus = mysqli_query($koneksi, $query_hapus);

    if ($hasil_hapus) {
        header("Location: kontrolguru.php");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus data!'); window.location='kontrolguru.php';</script>";
    }
} else {
    header("Location: kontrolguru.php");
    exit;
}
?>