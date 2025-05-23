<?php
session_start();
include '../database/koneksi.php';
$id_barang = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_barang <= 0) die("ID tidak valid.");

$sql = "SELECT b.*, l.id_lelang, l.harga_akhir, l.status, l.tgl_lelang
        FROM tb_barang b
        JOIN tb_lelang l ON l.id_barang = b.id_barang
        WHERE b.id_barang = $id_barang AND l.status = 'dibuka'
        LIMIT 1";
$result = mysqli_query($conn, $sql);
$barang = mysqli_fetch_assoc($result);
if (!$barang) die("Barang/lelang tidak ditemukan.");

$sql_top_bid = "SELECT h.penawaran_harga, h.created_at, m.username 
                FROM history_lelang h
                JOIN tb_masyarakat m ON h.id_user = m.id_user
                WHERE h.id_barang = $id_barang
                ORDER BY h.penawaran_harga DESC LIMIT 5";
$res_top_bid = mysqli_query($conn, $sql_top_bid);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($barang['nama_barang']) ?> - Penawaran</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #dff3fc, #e4ecf4);
      font-family: 'Segoe UI', sans-serif;
    }
    .product-card {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease-in-out;
    }
    .product-card:hover {
      transform: scale(1.01);
    }

    .product-img {
  object-fit: contain;
  max-height: 180px;
  width: auto; 
  max-width: 100%; 
}



    .price-tag {
      font-size: 1.5rem;
      color: #198754;
      font-weight: bold;
    }
    .gradient-header {
      background: linear-gradient(135deg, #74ebd5, #9face6);
      color: #fff;
      padding: 20px 30px;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
    }
    .btn-bid {
      background: linear-gradient(to right, #56ccf2, #2f80ed);
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 1rem;
      border-radius: 8px;
      transition: 0.3s;
    }
    .btn-bid:hover {
      background: linear-gradient(to right, #2f80ed, #56ccf2);
    }
    .bid-history table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10">
      <div class="card product-card">
        <div class="gradient-header d-flex justify-content-between align-items-center">
          <h3 class="mb-0"><?= htmlspecialchars($barang['nama_barang']) ?></h3>
          <a href="../index.php" class="btn btn-light">Kembali</a>
        </div>
        <div class="row g-0">
          <div class="col-md-4 d-flex justify-content-center align-items-center" style="background-color: #f8f9fa;">
            <img src="../admin/upload/<?= htmlspecialchars($barang['foto']) ?>" class="product-img" alt="<?= htmlspecialchars($barang['nama_barang']) ?>">
          </div>
          <div class="col-md-8 p-4">
            <h5>Deskripsi:</h5>
            <p><?= nl2br(htmlspecialchars($barang['deskripsi_barang'])) ?></p>
            <p class="price-tag">Harga Awal: Rp <?= number_format($barang['harga_awal'], 0, ',', '.') ?></p>

            <form action="simpan_penawaran.php" method="POST" class="mt-4">
              <input type="hidden" name="id_lelang" value="<?= $barang['id_lelang'] ?>">
              <input type="hidden" name="id_barang" value="<?= $barang['id_barang'] ?>">
              <?php if (isset($_SESSION['id_user'])): ?>
                <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
              <?php else: ?>
                <div class="alert alert-warning">Silakan login untuk melakukan penawaran.</div>
              <?php endif; ?>
              <div class="mb-3">
                <label for="nominal" class="form-label">Masukkan Penawaran Anda</label>
                <input type="number" class="form-control" name="nominal" required min="<?= $barang['harga_awal'] + 1 ?>">
              </div>
              <button type="submit" class="btn btn-bid">Tawar Sekarang</button>
            </form>
          </div>
        </div>

        <div class="p-4 bid-history">
          <h5 class="mb-3">Penawaran Tertinggi</h5>
          <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th>Username</th>
                <th>Nominal</th>
                <th>Waktu</th>
              </tr>
            </thead>
            <tbody>
              <?php if (mysqli_num_rows($res_top_bid) > 0): ?>
                <?php while ($bid = mysqli_fetch_assoc($res_top_bid)): ?>
                  <tr>
                    <td><?= htmlspecialchars($bid['username']) ?></td>
                    <td>Rp <?= number_format($bid['penawaran_harga'], 0, ',', '.') ?></td>
                    <td><?= $bid['created_at'] ?></td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr><td colspan="3" class="text-center">Belum ada penawaran</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        
      </div>
    </div>
  </div>
</div>
</body>
</html>
