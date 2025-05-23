<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

include '../database/koneksi.php';

$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

$sql = "SELECT 
            l.id_lelang,
            b.nama_barang,
            b.harga_awal,
            l.harga_akhir,
            m.nama_lengkap AS pemenang,
            p.nama_petugas AS petugas,
            l.tgl_lelang
        FROM tb_lelang l
        JOIN tb_barang b ON l.id_barang = b.id_barang
        LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
        LEFT JOIN tb_petugas p ON l.id_petugas = p.id_petugas
        WHERE l.status = 'ditutup' AND l.id_user IS NOT NULL";

if (!empty($start_date) && !empty($end_date)) {
    $sql .= " AND DATE(l.tgl_lelang) BETWEEN ? AND ?";
    $params = [$start_date, $end_date];
} elseif (!empty($start_date)) {
    $sql .= " AND DATE(l.tgl_lelang) >= ?";
    $params = [$start_date];
} elseif (!empty($end_date)) {
    $sql .= " AND DATE(l.tgl_lelang) <= ?";
    $params = [$end_date];
}

$sql .= " ORDER BY l.tgl_lelang DESC";
$stmt = mysqli_prepare($conn, $sql);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Laporan Lelang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background-color: #f8f9fa;
    }

    .sidebar {
      width: 250px;
      background-color: #00b3ad;
      color: white;
      min-height: 100vh;
      padding: 20px 10px;
    }

    .sidebar a {
      color: white;
      display: block;
      padding: 10px 15px;
      text-decoration: none;
      font-weight: 500;
    }

    .sidebar a:hover {
      background-color: #17a2b8;
    }

    .sidebar i {
      margin-right: 10px;
    }

    .profile-pic {
      width:150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 16px;
      margin-left: auto;
    }

    .main-content {
      margin-left: 250px;
      padding: 40px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .table th, .table td {
      white-space: nowrap;
      vertical-align: middle;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }

      .main-content {
        margin-left: 0;
        padding: 20px;
      }

      .sidebar img {
        width: 100px;
        height: 100px;
      }
    }

    /* CSS khusus untuk cetak (print) */
    @media print {
      body {
        background: white !important;
        color: #000 !important;
        font-size: 12pt;
      }

      /* Sembunyikan elemen yang tidak perlu saat cetak */
      .sidebar, 
      .no-print,
      form,
      nav,
      .btn, 
      a.btn {
        display: none !important;
      }

      /* Atur margin halaman cetak */
      @page {
        margin: 20mm;
      }

      /* Bikin main content penuh halaman */
      .main-content {
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        width: 100% !important;
      }

      /* Table full lebar dan rapi */
      table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 11pt;
      }

      table th, table td {
        border: 1px solid #000 !important;
        padding: 8px !important;
        text-align: center !important;
        white-space: normal !important; /* supaya teks bisa wrap */
      }

      /* Header cetak */
      h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 18pt;
      }
    }
  </style>
</head>
<body>
<main>
  <div class="sidebar position-fixed">
    <div class="text-center mb-4">
      <img class="profile-pic" src="../img/1.jpg" alt="Profile Picture">
      <h5><?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?></h5>
    </div>
    <nav>
      <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">
        <i class="bi bi-house-door-fill"></i> Dashboard
      </a>
      <a href="bukatutup.php" class="<?= basename($_SERVER['PHP_SELF']) == 'bukatutup.php' ? 'active' : '' ?>">
        <i class="bi bi-pencil-square"></i> Buka/Tutup Lelang
      </a>
      <a href="laporan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>">
        <i class="bi bi-bar-chart-line-fill"></i> Laporan
      </a>
      <a href="pendataanbarang.php" class="<?= basename($_SERVER['PHP_SELF']) == 'pendataanbarang.php' ? 'active' : '' ?>">
        <i class="bi bi-box-seam"></i> Pendataan Barang
      </a>
      <a href="../index.php">
        <i class="bi bi-arrow-left-circle"></i> Kembali
      </a>
    </nav>
  </div>
</main>

<section>
  <div class="main-content">
    <h2 class="text-center mb-4">Laporan Lelang yang Sudah Dimenangkan</h2>

    <form method="GET" action="" class="row g-3 align-items-end mb-3">
      <div class="col-md-3">
        <label for="start_date" class="form-label">Dari Tanggal</label>
        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= htmlspecialchars($start_date) ?>">
      </div>
      <div class="col-md-3">
        <label for="end_date" class="form-label">Sampai Tanggal</label>
        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= htmlspecialchars($end_date) ?>">
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
        <a href="laporan.php" class="btn btn-secondary w-100">Reset</a>
      </div>
    </form>

    <div class="no-print d-flex gap-2 mb-3">
      <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
      <a href="export_laporan.php?type=excel" class="btn btn-success">Export ke Excel</a>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga Awal</th>
            <th>Harga Akhir</th>
            <th>Pemenang</th>
            <th>Petugas</th>
            <th>Tanggal Lelang</th>
            <th class="no-print">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td>$<?= number_format($row['harga_awal'], 0, ',', '.') ?></td>
                <td>$<?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['pemenang']) ?></td>
                <td><?= htmlspecialchars($row['petugas']) ?></td>
                <td><?= date('d-m-Y', strtotime($row['tgl_lelang'])) ?></td>
                <td class="no-print">
                  <a href="detail_lelang.php?id=<?= $row['id_lelang'] ?>" class="btn btn-primary btn-sm">Detail</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center">Belum ada data lelang yang dimenangkan</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
