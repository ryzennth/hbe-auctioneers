<?php
session_start();
include 'koneksi.php'; // pastikan file koneksi sudah benar

// Cek apakah user sudah login dan memiliki level admin/petugas
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
  header("Location: ../login/login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Laporan Lelang</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <!-- Custom Styles -->
  <style>
    body {
      background-color: #f8f9fa;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color: #00b3ad;
      color: white;
      min-height: 100vh;
      padding: 20px 10px;
      position: fixed;
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

    .sidebar a.active {
    background-color: #17a2b8; /* Bisa kamu ganti sesuai warna yang diinginkan */
    font-weight: 700;
    box-shadow: 0 0 8px rgba(23, 162, 184, 0.7);
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 40px;
    }

    /* Table Header */
    .table th {
      background-color: #00b3ad;
      color: white;
    }

    /* Button Styles */
    .btn-primary, .btn-success {
      background-color: #00b3ad;
      border: none;
    }

    .btn-primary:hover, .btn-success:hover {
      background-color: #008c89;
    }

    .profile-pic {
      width:150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 16px;
      margin-left: auto;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="text-center mb-4">
    <div class="profile-img mb-3"></div>
    <img class="profile-pic" src="../img/1.jpg">
      <h5><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?></h5>
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

  <!-- Main Content -->
  <div class="main-content">
    <h2 class="mb-4">Laporan Lelang</h2>

    <!-- Filter Tanggal -->
    <div class="row mb-4">
      <div class="col-md-4">
        <label for="tanggalMulai" class="form-label">Dari Tanggal</label>
        <input type="date" class="form-control" id="tanggalMulai">
      </div>
      <div class="col-md-4">
        <label for="tanggalAkhir" class="form-label">Sampai Tanggal</label>
        <input type="date" class="form-control" id="tanggalAkhir">
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button class="btn btn-primary w-100">
          <i class="bi bi-funnel-fill"></i> Filter
        </button>
      </div>
    </div>

    <!-- Tabel Laporan -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Pemenang</th>
            <th>Harga Awal - Harga Akhir</th>
            <th>Tanggal Lelang</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Teko</td>
            <td>Joko</td>
            <td>Rp 12.000.000</td>
            <td>2025-05-01</td>
            <td><span class="badge bg-success">Selesai</span></td>
          </tr>
          <tr>
            <td>2</td>
            <td>Sepeda Gunung</td>
            <td>Siti</td>
            <td>Rp 3.500.000</td>
            <td>2025-05-03</td>
            <td><span class="badge bg-success">Selesai</span></td>
          </tr>
          <!-- Tambahkan baris lain jika perlu -->
        </tbody>
      </table>
    </div>

    <!-- Tombol Ekspor -->
    <div class="mt-4">
      <button class="btn btn-success">
        <i class="bi bi-printer-fill"></i> Cetak Laporan
      </button>
      <button class="btn btn-primary">
        <i class="bi bi-file-earmark-excel-fill"></i> Ekspor ke Excel
      </button>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>