<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "lelang_online");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Cek di tabel petugas (TANPA HASH)
  $query = "SELECT * FROM tb_petugas WHERE username = ?";
  $stmt = $koneksi->prepare($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && $user['password'] === $password) {
    $_SESSION['id_petugas'] = $user['id_petugas'];
    $_SESSION['id_user'] = $user['id_petugas']; // untuk keperluan umum
    $_SESSION['username'] = $user['username'];
    $_SESSION['level'] = $user['id_level'];

    if ($user['id_level'] == 1) {
      header("Location: ../admin/dashboard.php");
    } else {
      header("Location: ../index.php");
    }
    exit;
  }

  // Cek di masyarakat (PAKAI HASH)
  $sql = "SELECT * FROM tb_masyarakat WHERE username = ?";
  $stmt = $koneksi->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $masyarakat = $result->fetch_assoc();

  if ($masyarakat && password_verify($password, $masyarakat['password'])) {
    $_SESSION['id_user'] = $masyarakat['id_user'];
    $_SESSION['username'] = $masyarakat['username'];
    $_SESSION['nama_lengkap'] = $masyarakat['nama_lengkap'];
    $_SESSION['level'] = 'masyarakat';

    header("Location: ../index.php");
    exit;
  }

  // Jika gagal login
  $_SESSION['error'] = "Username atau password salah.";
  header("Location: login.php");
  exit;
}
?>
