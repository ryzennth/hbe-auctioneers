<?php
// Koneksi ke database
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
  header("Location: ../login/login.php");
  exit;
}

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi_barang'];
    $harga_awal = $_POST['harga_awal'];
    $tanggal = $_POST['tanggal'];

    // Mengupload gambar
    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($foto);

    if ($_FILES['foto']['error'] === 0) {
    $ext = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_baru = uniqid('barang_') . '.' . $ext;
    $target_file = $target_dir . $nama_baru;
    }
    if (move_uploaded_file($tmp_name, $target_file)) {
        $query = "INSERT INTO tb_barang (nama_barang, deskripsi_barang, harga_awal, tgl, foto) 
                  VALUES ('$nama_barang', '$deskripsi', '$harga_awal', '$tanggal', '$nama_baru')";
        if (mysqli_query($conn, $query)) {
            echo "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Barang berhasil ditambahkan',
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
            echo "<script>alert('Gagal menambahkan data ke database.');</script>";
        }
    } else {
        echo "<script>alert('Gagal memindahkan file ke folder uploads.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tambah Barang</title>
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
      <h5><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Admin'; ?></h5>
    </div>
    <nav>
      <a href="dashboard.php"><i class="bi bi-house-door-fill"></i> Dashboard</a>
      <a href="bukatutup.php"><i class="bi bi-pencil-square"></i> Buka/Tutup Lelang</a>
      <a href="laporan.php"><i class="bi bi-bar-chart-line-fill"></i> Laporan</a>
      <a href="pendataanbarang.php"><i class="bi bi-box-seam"></i> Pendataan Barang</a>
      <a href="../index.php"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <h4>Tambah Barang</h4>
    <hr>
    <!-- Form Tambah Barang -->
<form method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="nama_barang" class="form-label">Nama Barang</label>
    <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
  </div>
  <div class="mb-3">
    <label for="deskripsi" class="form-label">Deskripsi</label>
    <textarea class="form-control" id="deskripsi" name="deskripsi_barang" rows="3" required></textarea>
  </div>
  <div class="mb-3">
    <label for="harga_awal" class="form-label">Harga Awal</label>
    <input type="number" class="form-control" id="harga_awal" name="harga_awal" required>
  </div>
  <div class="mb-3">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="date" class="form-control" id="tgl" name="tanggal" required>
  </div>
  <div class="mb-3">
    <label for="foto" class="form-label">Foto Barang</label>
    <input type="file" class="form-control" id="foto" name="foto" required>
  </div>
  <button type="submit" class="btn btn-primary">Simpan Barang</button>
</form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>