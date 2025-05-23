<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login dan memiliki level admin/petugas
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
  header("Location: ../login/login.php");
  exit;
}

// Ambil data barang, filter tanggal jika ada
$where = "";
if (isset($_GET['tanggal']) && $_GET['tanggal'] != "") {
    $tanggal = $_GET['tanggal'];
    $where = "WHERE tgl = '$tanggal'";
}
$query = mysqli_query($conn, "SELECT id_barang, nama_barang, deskripsi_barang, tgl, harga_awal, foto FROM tb_barang $where");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pendataan Barang</title>
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
    <div class="mb-3">
      <h4>Pendataan Barang</h4>
    </div>
    <hr>
    <div class="mb-3">
      <a href="tambahbarang.php" class="btn btn-primary mb-2">
        <i class="bi bi-plus-lg"></i> Tambah
      </a>
      <!-- Filter Tanggal -->
      <form method="GET" class="d-flex align-items-center gap-2">
        <input type="date" name="tanggal" class="form-control" value="<?php echo isset($_GET['tanggal']) ? htmlspecialchars($_GET['tanggal']) : ''; ?>">
        <button type="submit" class="btn btn-outline-primary">Filter</button>
      </form>
    </div>

    <!-- Tabel Data Barang -->
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Nama Barang</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Harga Awal</th>
            <th>Foto</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row = mysqli_fetch_assoc($query)): ?>
          <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
            <td><?php echo htmlspecialchars($row['deskripsi_barang']); ?></td>
            <td><?php echo htmlspecialchars($row['tgl']); ?></td>
            <td><?php echo htmlspecialchars(number_format($row['harga_awal'], 0, ',', '.')); ?></td>
            <td>
              <?php if (!empty($row['foto'])): ?>
                <img src="upload/<?php echo htmlspecialchars($row['foto']); ?>" alt="Foto Barang" width="50">
              <?php else: ?>
                <span class="text-muted">Tidak ada foto</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="editbarang.php?id=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i> Edit
              </a>
              <a href="hapusbarang.php?id=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                <i class="bi bi-trash-fill"></i> Hapus
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>