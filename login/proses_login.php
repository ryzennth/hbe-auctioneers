<?php
session_start();

// Koneksi database
$koneksi = new mysqli("localhost", "root", "", "lelang_online");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Cek di tabel petugas
  $query = "SELECT * FROM tb_petugas WHERE username = ?";
  $stmt = $koneksi->prepare($query);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user) {
    if ($user['password'] === $password) {
      $_SESSION['id_petugas'] = $user['id_petugas'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['level'] = $user['id_level'];

      if ($user['id_level'] == 1) {
        header("Location: ../admin/dashboard.php");
      } else {
        header("Location: ../index.php");
      }
      exit;
    } else {
      $_SESSION['error'] = "password salah.";
      header("Location: login.php");
      exit;
    }
  } else {
    // Cek di masyarakat
    $sql = "SELECT * FROM `tb_masyarakat` WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $masyarakat = $result->fetch_assoc();

    if ($masyarakat) {
      if ($masyarakat['password'] === $password) {
        $_SESSION['id_masyarakat'] = $masyarakat['id_masyarakat'];
        $_SESSION['username'] = $masyarakat['username'];
        $_SESSION['nama_lengkap'] = $masyarakat['nama_lengkap'];
        $_SESSION['level'] = 'masyarakat';

        header("Location: ../index.php");
        exit;
      } else {
        $_SESSION['error'] = "password salah.";
        header("Location: login.php");
        exit;
      }
    } else {
      $_SESSION['error'] = "username tidak ditemukan.";
      header("Location: login.php");
      exit;
    }
  }
}
?>