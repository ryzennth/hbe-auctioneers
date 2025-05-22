<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login dan sebagai admin/petugas
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$id_lelang = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_lelang <= 0) {
    die("ID lelang tidak valid");
}

include '../database/koneksi.php';

// Query untuk mendapatkan detail lelang
$sql = "SELECT 
            l.id_lelang,
            b.nama_barang,
            b.deskripsi_barang,
            b.foto,
            b.harga_awal,
            l.harga_akhir,
            m.nama_lengkap AS pemenang,
            m.telp AS telp_pemenang,
            p.nama_petugas AS petugas,
            l.tgl_lelang
        FROM tb_lelang l
        JOIN tb_barang b ON l.id_barang = b.id_barang
        LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
        LEFT JOIN tb_petugas p ON l.id_petugas = p.id_petugas
        WHERE l.id_lelang = ? AND l.status = 'ditutup'";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_lelang);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$lelang = mysqli_fetch_assoc($result);

if (!$lelang) {
    die("Data lelang tidak ditemukan");
}

// Query untuk mendapatkan history penawaran
$sql_history = "SELECT 
                    h.penawaran_harga,
                    m.nama_lengkap,
                    m.username,
                    h.created_at
                FROM history_lelang h
                JOIN tb_masyarakat m ON h.id_user = m.id_user
                WHERE h.id_lelang = ?
                ORDER BY h.penawaran_harga DESC";

$stmt_history = mysqli_prepare($conn, $sql_history);
mysqli_stmt_bind_param($stmt_history, "i", $id_lelang);
mysqli_stmt_execute($stmt_history);
$history = mysqli_stmt_get_result($stmt_history);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Lelang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Detail Lelang</h2>
        
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4><?= htmlspecialchars($lelang['nama_barang']) ?></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <?php if (!empty($lelang['foto'])): ?>
                            <img src="../admin/upload/<?= htmlspecialchars($lelang['foto']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($lelang['nama_barang']) ?>">
                        <?php else: ?>
                            <div class="text-center py-3 bg-light">Tidak ada gambar</div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-8">
                        <p><strong>Deskripsi:</strong> <?= htmlspecialchars($lelang['deskripsi_barang']) ?></p>
                        <p><strong>Harga Awal:</strong> Rp<?= number_format($lelang['harga_awal'], 0, ',', '.') ?></p>
                        <p><strong>Harga Akhir:</strong> Rp<?= number_format($lelang['harga_akhir'], 0, ',', '.') ?></p>
                        <p><strong>Pemenang:</strong> <?= htmlspecialchars($lelang['pemenang']) ?></p>
                        <p><strong>Telepon Pemenang:</strong> <?= htmlspecialchars($lelang['telp_pemenang']) ?></p>
                        <p><strong>Petugas:</strong> <?= htmlspecialchars($lelang['petugas']) ?></p>
                        <p><strong>Tanggal Lelang:</strong> <?= date('d-m-Y', strtotime($lelang['tgl_lelang'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3">History Penawaran</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Penawar</th>
                        <th>Username</th>
                        <th>Penawaran</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($history) > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = mysqli_fetch_assoc($history)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td>Rp<?= number_format($row['penawaran_harga'], 0, ',', '.') ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada history penawaran</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <a href="laporan.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>