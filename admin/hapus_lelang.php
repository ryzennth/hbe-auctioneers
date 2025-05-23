<?php
// filepath: c:\xampp\htdocs\lelang online\admin\hapus_lelang.php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../login/login.php");
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id) {
    mysqli_query($conn, "DELETE FROM tb_lelang WHERE id_lelang='$id'");
}

echo "<script>alert('Data lelang berhasil dihapus!'); window.location.href='lelang.php';</script>";
exit;
?>