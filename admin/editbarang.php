

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
        <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $barang['nama_barang']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $barang['deskripsi']; ?></textarea>
      </div>
      <div class="mb-3">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $barang['tanggal']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="foto" class="form-label">Foto Barang</label>
        <input type="file" class="form-control" id="foto" name="foto">
        <small>Foto saat ini: <img src="<?php echo $barang['foto']; ?>" alt="Foto Barang" width="100"></small>
      </div>
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>