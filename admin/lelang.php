<?php
session_start();
include 'koneksi.php';

// Cek login dan level jika perlu
if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data lelang dengan JOIN ke tabel barang, masyarakat, dan petugas
$query = mysqli_query($conn, "
    SELECT 
        l.id_lelang, 
        b.nama_barang, 
        l.tgl_lelang, 
        l.harga_akhir, 
        m.nama_lengkap AS nama_penawar,
        p.nama_petugas,
        l.status
    FROM tb_lelang l
    LEFT JOIN tb_barang b ON l.id_barang = b.id_barang
    LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
    LEFT JOIN tb_petugas p ON l.id_petugas = p.id_petugas
    ORDER BY l.tgl_lelang DESC
");

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
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table th {
            white-space: nowrap;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>Daftar Lelang</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID Lelang</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Lelang</th>
                    <th>Harga Tertinggi</th>
                    <th>Penawar Tertinggi</th>
                    <th>Petugas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id_lelang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_barang'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['tgl_lelang']) ?></td>
                    <td>Rp <?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['nama_penawar'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['nama_petugas'] ?? '-') ?></td>
                    <td><?= statusLelang($row['status']) ?></td>
                    <td>
                        <a href="hapus_lelang.php?id=<?= urlencode($row['id_lelang']) ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Yakin ingin menghapus data lelang ini?');">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>