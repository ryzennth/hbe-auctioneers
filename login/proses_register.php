<?php
include '../database/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // HASH PASSWORD
  $nama_lengkap = $_POST['nama_lengkap'];
  $telp = $_POST['telp'];

  // Cek apakah username sudah ada
  $cek = mysqli_query($conn, "SELECT * FROM tb_masyarakat WHERE username = '$username'");
  if (mysqli_num_rows($cek) > 0) {
    session_start();
    $_SESSION['error'] = "Username sudah digunakan!";
    header("Location: register.php");
    exit;
  }

  $sql = "INSERT INTO tb_masyarakat (username, password, nama_lengkap, telp)
          VALUES ('$username', '$password', '$nama_lengkap', '$telp')";

  if (mysqli_query($conn, $sql)) {
    header("Location: login.php");
  } else {
    echo "Gagal mendaftar: " . mysqli_error($conn);
  }
}
?>
