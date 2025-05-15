<?php
$conn = mysqli_connect("localhost", "root", "", "lelang_online");
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Penawaran Barang - Lelang Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4>Penawaran Barang: <?= $barang['nama_barang'] ?></h4>
    </div>
    <div class="card-body">
      <p><strong>Deskripsi:</strong> <?= $barang['deskripsi'] ?></p>
      <p><strong>Harga Awal:</strong> Rp<?= number_format($barang['harga_awal'], 0, ',', '.') ?></p>
      <p><strong>Penawaran Tertinggi Saat Ini:</strong> Rp<?= number_format($penawaran_tertinggi['max_bid'] ?? $barang['harga_awal'], 0, ',', '.') ?></p>
      
      <form action="simpan_penawaran.php" method="POST">
        <input type="hidden" name="id_barang" value="<?= $barang['id'] ?>">
        <div class="mb-3">
          <label for="nominal" class="form-label">Masukkan Penawaran Anda</label>
          <input type="number" class="form-control" name="nominal" required>
        </div>
        <button type="submit" class="btn btn-success">Tawar Sekarang</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
