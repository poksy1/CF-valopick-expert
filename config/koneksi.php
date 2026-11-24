<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_sispak_valorant";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>