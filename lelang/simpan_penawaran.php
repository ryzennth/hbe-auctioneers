<?php
include "koneksi.php";
session_start();

// Contoh: Ambil ID user dari session login
$id_user = $_SESSION['id_user'] ?? 1; // fallback ke 1 kalau belum login
$id_barang = $_POST['id_barang'];
$nominal = $_POST['nominal'];

// Ambil penawaran tertinggi
$result = mysqli_query($conn, "SELECT MAX(nominal) as max_bid FROM penawaran WHERE id_barang = $id_barang");
$data = mysqli_fetch_assoc($result);
$max_bid = $data['max_bid'] ?? 0;

if ($nominal > $max_bid) {
  mysqli_query($conn, "INSERT INTO penawaran (id_user, id_barang, nominal, tanggal) VALUES ($id_user, $id_barang, $nominal, NOW())");
  echo "<script>alert('Penawaran berhasil disimpan!'); window.location='penawaran.php?id=$id_barang';</script>";
} else {
  echo "<script>alert('Penawaran harus lebih tinggi dari sebelumnya!'); window.location='penawaran.php?id=$id_barang';</script>";
}
?>
