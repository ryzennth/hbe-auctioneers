<?php
include 'koneksi.php';

// Ambil ID barang dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
    echo "<script>alert('ID barang tidak ditemukan!'); window.location.href='barang.php';</script>";
    exit;
}

// Ambil data barang dari database
$result = mysqli_query($conn, "SELECT * FROM tb_barang WHERE id_barang='$id'");
$barang = mysqli_fetch_assoc($result);

if (!$barang) {
    echo "<script>alert('Data barang tidak ditemukan!'); window.location.href='barang.php';</script>";
    exit;
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];

    // Cek apakah ada upload foto baru
    if ($_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($foto, PATHINFO_EXTENSION);
        $nama_baru = uniqid('barang_') . '.' . $ext;
        $target_dir = "upload/";
        $target_file = $target_dir . $nama_baru;
        if (move_uploaded_file($tmp_name, $target_file)) {
            // Hapus foto lama jika ada
            if (!empty($barang['foto']) && file_exists("upload/" . $barang['foto'])) {
                unlink("upload/" . $barang['foto']);
            }
            $foto_update = ", foto='$nama_baru'";
        } else {
            echo "<script>alert('Gagal upload foto baru!');</script>";
            $foto_update = "";
        }
    } else {
        $foto_update = "";
    }

    $query = "UPDATE tb_barang SET nama_barang='$nama_barang', deskripsi_barang='$deskripsi', tgl='$tanggal' $foto_update WHERE id_barang='$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data barang berhasil diupdate!'); window.location.href='barang.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal update data barang!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Barang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
</head>
<body>
  <div class="container mt-5">
    <h2>Edit Barang</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama_barang" class="form-label">Nama Barang</label>
        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo htmlspecialchars($barang['nama_barang']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($barang['deskripsi_barang']); ?></textarea>
      </div>
      <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo htmlspecialchars($barang['tgl']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="foto" class="form-label">Foto Barang</label>
        <input type="file" class="form-control" id="foto" name="foto">
        <small>Foto saat ini: 
          <?php if (!empty($barang['foto'])): ?>
            <img src="upload/<?php echo htmlspecialchars($barang['foto']); ?>" alt="Foto Barang" width="100">
          <?php else: ?>
            Tidak ada foto
          <?php endif; ?>
        </small>
      </div>
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="barang.php" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>