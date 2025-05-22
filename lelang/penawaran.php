<?php
session_start();
include '../database/koneksi.php';
$id_barang = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_barang <= 0) {
  die("ID barang tidak valid.");
}
// Ambil data barang & lelang
$sql = "SELECT b.*, l.id_lelang, l.harga_akhir, l.status, l.tgl_lelang
        FROM tb_barang b
        JOIN tb_lelang l ON l.id_barang = b.id_barang
        WHERE b.id_barang = $id_barang AND l.status = 'dibuka'
        LIMIT 1";
$result = mysqli_query($conn, $sql);
$barang = mysqli_fetch_assoc($result);
if (!$barang) {
  die("Data barang/lelang tidak ditemukan.");
}
// Penawaran tertinggi
$sql_bid = "SELECT MAX(penawaran_harga) AS max_bid FROM history_lelang WHERE id_barang = $id_barang";
$res_bid = mysqli_query($conn, $sql_bid);
$penawaran_tertinggi = mysqli_fetch_assoc($res_bid);
if (isset($_GET['status']) && $_GET['status'] == 'failed'): ?>
  <div><?= "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Gagal!',
            text: 'penawaran harus lebih tinggi!',
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff',
            allowOutsideClick: false
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '#';
            }
          });
        });
      </script>";?></div>
<?php elseif (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
  <div><?= "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Berhasil!',
            text: 'penawaran berhasil dilakukan',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff',
            allowOutsideClick: false
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '#';
            }
          });
        });
      </script>";?></div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Penawaran Barang - Lelang Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .btn-black {
      background-color: #000;
      color: #fff;
      border-radius: 6px;
      padding: 8px 16px;
      transition: 0.3s;
    }
    .btn-black:hover {
      background-color: #333;
    }
    .product-img {
      width: 100%;
      max-width: 100%;
      border-radius: 8px;
    }
  </style>
<body class="bg-light">
  
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <?php if (!empty($barang['foto'])): ?>
      <img src="../admin/upload/<?= htmlspecialchars($barang['foto']) ?>" alt="<?= htmlspecialchars($barang['nama_barang']) ?>" class="img-fluid mb-3" style="max-width:300px;">
      <?php endif; ?>
      <h4>Penawaran Barang: <?= $barang['nama_barang'] ?></h4>
    </div>
    <div class="card-body">
      <p><strong>Deskripsi:</strong> <?= $barang['deskripsi_barang'] ?></p>
      <p><strong>Harga Awal:</strong> $<?= number_format($barang['harga_awal'], 0, ',', '.') ?></p>
      <h5>Penawaran Tertinggi</h5>
<table class="table table-bordered mt-3">
  <thead class="table-secondary">
    <tr>
      <th>Username</th>
      <th>Nominal</th>
      <th>Waktu</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql_top_bid = "SELECT h.penawaran_harga, h.created_at, m.username 
                    FROM history_lelang h
                    JOIN tb_masyarakat m ON h.id_user = m.id_user
                    WHERE h.id_barang = $id_barang
                    ORDER BY h.penawaran_harga DESC 
                    LIMIT 5";
    $res_top_bid = mysqli_query($conn, $sql_top_bid);
    if (mysqli_num_rows($res_top_bid) > 0) {
    while ($top_bid = mysqli_fetch_assoc($res_top_bid)) {
    echo "<tr>
            <td>" . htmlspecialchars($top_bid['username']) . "</td>
            <td>$" . number_format($top_bid['penawaran_harga'], 0, ',', '.') . "</td>
            <td>" . $top_bid['created_at'] . "</td>
          </tr>";
  }
} else {
  echo "<tr><td colspan='3' class='text-center'>Belum ada penawaran</td></tr>";
}

    ?>
  </tbody>
</table>

      <form action="simpan_penawaran.php" method="POST">
  <input type="hidden" name="id_lelang" value="<?= $barang['id_lelang'] ?>">
  <input type="hidden" name="id_barang" value="<?= $barang['id_barang'] ?>">
  <?php if (isset($_SESSION['id_user'])): ?>
  <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">
<?php else: ?>
  <div class="alert alert-warning">Anda harus login terlebih dahulu untuk menawar.</div>
<?php endif; ?>
   <!-- pastikan user login -->
  <div class="mb-3">
    <label for="nominal" class="form-label">Masukkan Penawaran Anda</label>
    <input type="number" class="form-control" name="nominal" required>
  </div>
  <button type="submit" class="btn btn-success">Tawar Sekarang</button>
  <a href="../index.php"><button class="btn-black" type="button">Kembali</button></a>
</form>
    </div>
  </div>
</div>
</body>
</html>
