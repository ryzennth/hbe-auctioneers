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
    <h2 class="mb-4">Manajemen Sesi Lelang</h2>

    <!-- Buka Lelang -->
    <div class="card form-section shadow-sm">
      <div class="card-header bg-primary text-white">
        <i class="bi bi-plus-circle"></i> Buka Sesi Lelang
      </div>
      <div class="card-body">
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nama Barang</label>
              <input type="text" class="form-control" placeholder="Masukkan nama barang">
            </div>
            <div class="col-md-6">
              <label class="form-label">Waktu Dimulai</label>
              <input type="datetime-local" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Harga Awal</label>
              <input type="number" class="form-control" step="0.01" placeholder="0.00">
            </div>
            <div class="col-md-6 d-flex align-items-end">
              <button type="submit" class="btn btn-primary w-100">
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
        <form>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">ID Lelang Aktif</label>
              <input type="text" class="form-control" placeholder="Masukkan ID lelang">
            </div>
            <div class="col-md-6 d-flex align-items-end">
              <button type="submit" class="btn btn-danger w-100">
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