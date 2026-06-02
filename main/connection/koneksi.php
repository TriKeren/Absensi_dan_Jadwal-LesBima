<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "les_bima_db";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Error: " . mysqli_connect_errno() . " - " . mysqli_connect_error());
}
?>