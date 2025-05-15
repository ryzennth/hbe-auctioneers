<?php
session_start();

// Cek apakah user sudah login dan memiliki level admin
if (!isset($_SESSION['id_petugas']) || $_SESSION['level'] != 1) { // 1 adalah ID level admin
  header("Location: ../login/login.php"); // Arahkan ke halaman login jika bukan admin
  exit;
}

// Halaman dashboard admin bisa ditampilkan di sini
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

    .card-stat i {
      font-size: 1.5rem;
      display: block;
      margin-bottom: 10px;
    }

  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar position-fixed">
    <div class="text-center mb-4">
      <div class="profile-img mb-3"></div>
      <img class="profile-pic" src="../img/1.jpg">
      <h5>Admin Name</i></h5>
    </div>
    <nav>
      <a href="dashboard.php"><i class="bi bi-house-door-fill"></i> Dashboard</a>
      <a href="bukatutup.php"><i class="bi bi-pencil-square"></i> Buka/Tutup Lelang</a>
      <a href="laporan.php"><i class="bi bi-bar-chart-line-fill"></i> Laporan</a>
      <a href="pendataanbarang.php"><i class="bi bi-box-seam"></i> Pendataan Barang</a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h4>DASHBOARD</h4>
    <hr>
    <p>Selamat Datang,<br><strong>ADMIN HBE AUCTIONEERS</strong></p>

    <div class="row g-3 mt-4">
      <div class="col-md-3">
        <div class="card-stat bg-purple text-white">
          <i class="bi bi-person"></i>
          <div>15</div>
          <div>Admin/Petugas</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat bg-green">
          <i class="bi bi-people"></i>
          <div>50</div>
          <div>User Aktif</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat bg-red text-white">
          <i class="bi bi-list-ul"></i>
          <div>200</div>
          <div>Barang Terdaftar</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat bg-yellow">
          <i class="bi bi-activity"></i>
          <div>15</div>
          <div>Lelang Aktif</div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>