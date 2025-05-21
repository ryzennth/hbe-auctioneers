<?php
session_start();
include 'koneksi.php';

// Cek login dan level jika perlu
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data user dari tb_masyarakat
$query = mysqli_query($conn, "SELECT id_user, nama_lengkap, username, password, telp FROM tb_masyarakat");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar User Terdaftar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Daftar User Terdaftar</h2>
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID User</th>
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>No. Telp</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_user']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['telp']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>