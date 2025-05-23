<?php
session_start();
include 'koneksi.php';

// Cek login dan level jika perlu
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data barang dari tb_barang
$query = mysqli_query($conn, "SELECT id_barang, nama_barang, tgl, harga_awal, deskripsi_barang FROM tb_barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Barang Terdaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Barang Terdaftar</h2>
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    <table class="table table-bordered table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Harga Awal</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id_barang']); ?></td>
            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
            <td><?php echo htmlspecialchars($row['tgl']); ?></td>
            <td><?php echo htmlspecialchars(number_format($row['harga_awal'], 0, ',', '.')); ?></td>
            <td><?php echo htmlspecialchars($row['deskripsi_barang']); ?></td>
            <td>
                <a href="editbarang.php?id=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="hapusbarang.php?id=<?php echo urlencode($row['id_barang']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</div>
</body>
</html>