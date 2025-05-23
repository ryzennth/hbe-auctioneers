<?php
session_start();
include 'koneksi.php';

// Cek login dan level jika perlu
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data lelang dari tb_lelang
$query = mysqli_query($conn, "SELECT id_lelang, id_barang, tgl_lelang, harga_akhir, id_user, id_petugas, status FROM tb_lelang");

function statusLelang($status) {
    return $status === 'dibuka' ? 'Aktif' : 'Tidak Aktif';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Lelang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Lelang</h2>
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    <table class="table table-bordered table-striped mt-3">
    <thead class="table-dark">
        <tr>
            <th>ID Lelang</th>
            <th>ID Barang</th>
            <th>Tanggal Lelang</th>
            <th>Harga Tertinggi</th>
            <th>ID User Penawar Tertinggi</th>
            <th>ID Petugas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id_lelang']); ?></td>
            <td><?php echo htmlspecialchars($row['id_barang']); ?></td>
            <td><?php echo htmlspecialchars($row['tgl_lelang']); ?></td>
            <td><?php echo htmlspecialchars(number_format($row['harga_akhir'], 0, ',', '.')); ?></td>
            <td><?php echo htmlspecialchars($row['id_user']); ?></td>
            <td><?php echo htmlspecialchars($row['id_petugas']); ?></td>
            <td><?php echo statusLelang($row['status']); ?></td>
            <td>
                <a href="hapus_lelang.php?id=<?php echo urlencode($row['id_lelang']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data lelang ini?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
</body>
</html>