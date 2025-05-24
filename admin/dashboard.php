<?php
session_start();
include 'koneksi.php'; // pastikan file koneksi sudah benar

// Cek apakah user sudah login dan memiliki level admin/petugas
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
  header("Location: ../login/login.php");
  exit;
}

// Query jumlah admin/petugas
$q1 = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_petugas WHERE id_level IN (1,2)");
$jumlah_petugas = mysqli_fetch_assoc($q1)['total'];

// Query jumlah user aktif
$q2 = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_masyarakat");
$jumlah_user = mysqli_fetch_assoc($q2)['total'];

// Query jumlah barang terdaftar
$q3 = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_barang");
$jumlah_barang = mysqli_fetch_assoc($q3)['total'];

// Query jumlah lelang aktif
$q4 = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_lelang WHERE status='dibuka'");
$jumlah_lelang = mysqli_fetch_assoc($q4)['total'];

$q5 = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_lelang WHERE status='ditutup'");
$jumlah_lelang_berakhir = mysqli_fetch_assoc($q5)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
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

    .sidebar a.active {
    background-color: #17a2b8; /* Bisa kamu ganti sesuai warna yang diinginkan */
    font-weight: 700;
    box-shadow: 0 0 8px rgba(23, 162, 184, 0.7);
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
    }

    .card-stat {
      color: #000;
      padding: 20px;
      border-radius: 5px;
      font-weight: 600;
      text-align: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .bg-purple { background-color: #7a7adb; }
    .bg-green { background-color: #3eff3e; }
    .bg-red { background-color: #ff5f5f; }
    .bg-yellow { background-color: #fff933; }
    .bg-ungu { background-color:rgb(89, 0, 255); }

    .card-stat i {
      font-size: 1.5rem;
      display: block;
      margin-bottom: 10px;
    }

    .card-stat {
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    }
    .card-stat:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 24px rgba(0,0,0,0.18);
    z-index: 2;
    }


  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar position-fixed">
    <div class="text-center mb-4">
      <div class="profile-img mb-3"></div>
      <img class="profile-pic" src="../img/1.jpg">
      <h5>
  <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?>
</h5>
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
    <h4>DASHBOARD</h4>
    <hr>
    <p>Selamat Datang,<br><strong>ADMIN HBE AUCTIONEERS</strong></p>

    <div class="row g-3 mt-4">
  <div class="col-md-3">
    <a href="petugas.php" style="text-decoration:none;">
      <div class="card-stat bg-purple text-white">
        <i class="bi bi-person"></i>
        <div><?php echo $jumlah_petugas; ?></div>
        <div>Admin/Petugas</div>
      </div>
    </a>
  </div>
  <div class="col-md-3">
    <a href="masyarakat.php" style="text-decoration:none;">
      <div class="card-stat bg-green">
        <i class="bi bi-people"></i>
        <div><?php echo $jumlah_user; ?></div>
        <div>User Aktif</div>
      </div>
    </a>
  </div>
  <div class="col-md-3">
    <a href="barang.php" style="text-decoration:none;">
      <div class="card-stat bg-red text-white">
        <i class="bi bi-list-ul"></i>
        <div><?php echo $jumlah_barang; ?></div>
        <div>Barang Terdaftar</div>
      </div>
    </a>
  </div>
  <div class="col-md-3">
    <a href="lelang.php" style="text-decoration:none;">
      <div class="card-stat bg-yellow">
        <i class="bi bi-activity"></i>
        <div><?php echo $jumlah_lelang; ?></div>
        <div>Lelang Aktif</div>
      </div>
    </a>
  </div>
  <div class="col-md-3">
    <a href="history.php" style="text-decoration:none;">
      <div class="card-stat bg-ungu">
        <i class="bi bi-activity"></i>
        <div><?php echo $jumlah_lelang_berakhir; ?></div>
        <div>History </div>
      </div>
    </a>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>