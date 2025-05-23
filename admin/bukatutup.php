<?php
session_start();
include 'koneksi.php'; // pastikan file koneksi sudah benar

// Cek apakah user sudah login dan memiliki level admin/petugas
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
  header("Location: ../login/login.php");
  exit;
}

// Proses buka lelang
if (isset($_POST['buka_lelang'])) {
    $id_barang = $_POST['id_barang'];
    $waktu_mulai = date('Y-m-d H:i:s', strtotime($_POST['tgl_lelang']));
    $id_petugas = $_SESSION['id_petugas'];

    // Validasi id_barang
    $cek_barang = mysqli_query($conn, "SELECT * FROM tb_barang WHERE id_barang='$id_barang'");
    if (mysqli_num_rows($cek_barang) == 0) {
        echo "<script>alert('ID Barang tidak ditemukan!');</script>";
    } else {
        $query = "INSERT INTO tb_lelang (id_barang, tgl_lelang, harga_akhir, id_user, id_petugas, status) 
                  VALUES ('$id_barang', '$waktu_mulai', 0, NULL, '$id_petugas', 'dibuka')";
        if (mysqli_query($conn, $query)) {
      echo "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Lelang berhasil dibuka!',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff',
            allowOutsideClick: false
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'pendataanbarang.php';
            }
          });
        });
      </script>";
      exit;
        } else {
            die("Query Error: " . mysqli_error($conn));
        }
    }
}


// Proses tutup lelang
if (isset($_POST['tutup_lelang'])) {
    $id_lelang = $_POST['id_lelang'];
    $cek_lelang = mysqli_query($conn, "SELECT * FROM tb_lelang WHERE id_lelang='$id_lelang' AND status='dibuka'");
    if (mysqli_num_rows($cek_lelang) == 0) {
        echo "<script>alert('ID Lelang tidak ditemukan atau sudah ditutup!');</script>";
    } else {
        $query = "UPDATE tb_lelang SET status='ditutup' WHERE id_lelang='$id_lelang'";
        if (mysqli_query($conn, $query)) {
      echo "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Lelang berhasil ditutup!',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff',
            allowOutsideClick: false
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'pendataanbarang.php';
            }
          });
        });
      </script>";
      exit;
        } else {
            echo "<script>alert('Gagal menutup lelang!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buka/Tutup Lelang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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
      align-items: center;
      padding: 10px 15px;
      text-decoration: none;
      font-weight: 500;
      width: 100%;
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

    .card-header {
      font-weight: bold;
    }

    .form-section {
      margin-bottom: 2rem;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar position-fixed">
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
    <h2 class="mb-4">Manajemen Sesi Lelang</h2>

    <!-- Buka Lelang -->
    <div class="card form-section shadow-sm">
  <div class="card-header bg-primary text-white">
    <i class="bi bi-plus-circle"></i> Buka Sesi Lelang
  </div>
  <div class="card-body">
    <form method="POST" action="">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">ID Barang</label>
          <input type="text" class="form-control" name="id_barang" placeholder="Masukkan ID barang" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Waktu Dimulai</label>
          <input type="datetime-local" class="form-control" name="tgl_lelang" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-12 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100" name="buka_lelang">
            <i class="bi bi-check-circle"></i> Buka Lelang
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
    <!-- Tutup Lelang -->
    <div class="card form-section shadow-sm">
      <div class="card-header bg-danger text-white">
        <i class="bi bi-x-circle"></i> Tutup Sesi Lelang
      </div>
      <div class="card-body">
        <form method="POST" action="">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">ID Lelang Aktif</label>
              <input type="text" class="form-control" name="id_lelang" placeholder="Masukkan ID lelang" required>
            </div>
            <div class="col-md-6 d-flex align-items-end">
              <button type="submit" class="btn btn-danger w-100" name="tutup_lelang">
                <i class="bi bi-x-square"></i> Tutup Lelang
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>