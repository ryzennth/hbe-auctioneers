<?php
$conn = mysqli_connect("localhost", "root", "", "lelang_online");
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
