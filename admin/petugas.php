<?php
session_start();
include 'koneksi.php';

// Cek login dan level jika perlu
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data admin & petugas dari tb_petugas
$query = mysqli_query($conn, "SELECT id_petugas, nama_petugas, username, id_level FROM tb_petugas WHERE id_level IN (1,2)");

function getOtoritas($level) {
    if ($level == 1) return 'Administrator';
    if ($level == 2) return 'Petugas';
    return 'Tidak diketahui';
}

if (isset($_POST['tambah']) && $_SESSION['level'] == 1) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_petugas']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $id_level = intval($_POST['id_level']);

    // Cek username unik
    $cek = mysqli_query($conn, "SELECT id_petugas FROM tb_petugas WHERE username='$username'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO tb_petugas (nama_petugas, username, password, id_level) VALUES ('$nama', '$username', '$password', $id_level)");
        echo "<script>location.href='petugas.php';</script>";
        exit;
    } else {
        echo "<script>alert('Username sudah digunakan!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Admin & Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Admin & Petugas</h2>
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    <?php if ($_SESSION['level'] == 1): // Hanya admin ?>
    <!-- Tombol untuk membuka modal tambah -->
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPetugasModal">Tambah Admin/Petugas</button>
    <?php endif; ?>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Tingkat Otoritas</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($_SESSION['level'] == 1): ?>
            <!-- Modal Tambah Petugas -->
            <div class="modal fade" id="tambahPetugasModal" tabindex="-1" aria-labelledby="tambahPetugasLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="tambahPetugasLabel">Tambah Admin/Petugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tingkat Otoritas</label>
                        <select name="id_level" class="form-control" required>
                        <option value="1">Administrator</option>
                        <option value="2">Petugas</option>
                        </select>
                    </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <?php endif; ?>
            <?php if (isset($_POST['tambah'])): ?>
                <?php
                $nama_petugas = mysqli_real_escape_string($conn, $_POST['nama_petugas']);
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $id_level = (int)$_POST['id_level'];

                $query_tambah = "INSERT INTO tb_petugas (nama_petugas, username, password, id_level) VALUES ('$nama_petugas', '$username', '$password', '$id_level')";
                if (mysqli_query($conn, $query_tambah)) {
                    echo "<script>alert('Admin/Petugas berhasil ditambahkan!'); window.location.reload();</script>";
                } else {
                    echo "<script>alert('Gagal menambahkan Admin/Petugas!');</script>";
                }
                ?>
            <?php endif; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_petugas']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_petugas']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo getOtoritas($row['id_level']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>