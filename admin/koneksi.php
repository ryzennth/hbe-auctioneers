<?php
$host = "localhost";
$user = "root";
$pass = ""; // sesuaikan jika ada password
$db   = "lelang_online";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>