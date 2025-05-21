<?php
session_start();
include '../database/koneksi.php';

$id_lelang = $_POST['id_lelang'];
$id_barang = $_POST['id_barang'];
$id_user = $_SESSION['id_user'] ?? null; // ambil dari session
$nominal = $_POST['nominal'];

if (!$id_lelang || !$id_barang || !$id_user || !$nominal) {
  die("Data tidak lengkap.");
}

// Ambil harga_awal dari barang
$query_barang = mysqli_query($conn, "SELECT harga_awal FROM tb_barang WHERE id_barang = '$id_barang'");
$data_barang = mysqli_fetch_assoc($query_barang);
$harga_awal = $data_barang['harga_awal'] ?? 0;

// Ambil penawaran tertinggi sebelumnya
$query_max = mysqli_query($conn, "SELECT MAX(penawaran_harga) as max_bid FROM history_lelang WHERE id_lelang = '$id_lelang'");
$data_max = mysqli_fetch_assoc($query_max);
$max_bid = $data_max['max_bid'];

// Tentukan acuan: jika belum ada penawaran, pakai harga_awal
$acuan = $max_bid ? $max_bid : $harga_awal;

// Validasi penawaran
if ($nominal > $acuan) {
  // Simpan penawaran baru
  mysqli_query($conn, "INSERT INTO history_lelang (id_lelang, id_barang, id_user, penawaran_harga)
                       VALUES ('$id_lelang', '$id_barang', '$id_user', '$nominal')");

  // Update harga_akhir & id_user pemenang sementara di tb_lelang
  mysqli_query($conn, "UPDATE tb_lelang SET harga_akhir = '$nominal', id_user = '$id_user' WHERE id_lelang = '$id_lelang'");

  header("Location: penawaran.php?id=$id_barang&status=success");
} else {
  header("Location: penawaran.php?id=$id_barang&status=failed");
}
?>
