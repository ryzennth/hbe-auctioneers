<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pendataan Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  <style>
    body { background-color: #f8f9fa; }
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
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar position-fixed">
    <div class="text-center mb-4">
      <div class="profile-img mb-3"></div>
      <img class="profile-pic" src="../img/1.jpg">
      <h5>Admin Name</h5>
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
        <input type="date" name="tanggal" class="form-control">
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
            <th>Foto</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <!-- Contoh Row Barang -->
          <tr>
            <td>1</td>
            <td>Barang A</td>
            <td>Deskripsi barang A</td>
            <td>2025-05-10</td>
            <td><img src="foto_barang_a.jpg" alt="Foto Barang A" width="50"></td>
            <td>
              <a href="editbarang.php?id=1" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-fill"></i> Edit
              </a>
              <a href="hapusbarang.php?id=1" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">
                <i class="bi bi-trash-fill"></i> Hapus
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>