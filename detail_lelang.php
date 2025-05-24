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

include 'database/koneksi.php';

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
    <meta charset="UTF-8" />
    <title>Detail Lelang - <?= htmlspecialchars($lelang['nama_barang']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f4f7fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 12px;
        }
        .product-img {
            max-height: 350px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }
        a.btn-primary:hover {
    background-color: #0056b3;
    box-shadow: 0 6px 12px rgba(0, 86, 179, 0.4);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}
      .table {
        width: 1100px;
        font-size: 11pt;
        margin: 4rem;
        
      }

      table th, table td {
        border: 1px solid #000 !important;
        padding: 8px !important;
        text-align: center !important;
        
      }

        .info-label {
            font-weight: 600;
            color: #555;
        }
        .winner-card {
            background: linear-gradient(135deg, #4caf50, #81c784);
            color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(72, 187, 120, 0.6);
        }
        .winner-card h5 {
            margin-bottom: 1rem;
            font-weight: 700;
        }
        .history-table th, .history-table td {
            vertical-align: middle;
        }
        @media (max-width: 768px) {
            .product-img {
                max-height: 250px;
            }
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <a href="index.php" class="btn btn-primary btn-lg mb-4 d-inline-flex align-items-center shadow-sm" style="gap: 8px;">
    <i class="bi bi-arrow-left-circle-fill"></i> Kembali
</a>


        <div class="row g-4">
            <!-- Gambar dan Deskripsi Barang -->
            <!-- Gambar dan Deskripsi Barang -->
<div class="col-md-5">
    <div class="card">
        <?php if (!empty($lelang['foto'])): ?>
            <img src="admin/upload/<?= htmlspecialchars($lelang['foto']) ?>" alt="<?= htmlspecialchars($lelang['nama_barang']) ?>" class="product-img w-100" style="max-height: 250px; object-fit: contain; border-radius: 12px 12px 0 0;">
        <?php else: ?>
            <div class="text-center py-5 bg-light text-muted">Tidak ada gambar</div>
        <?php endif; ?>
        <div class="card-body">
            <h3 class="card-title"><?= htmlspecialchars($lelang['nama_barang']) ?></h3>
            <p class="card-text"><?= nl2br(htmlspecialchars($lelang['deskripsi_barang'])) ?></p>
        </div>
    </div>
</div>

<!-- Detail Lelang & Info Pemenang -->
<div class="col-md-7">
    <div class="card p-4 mb-4">
        <h4 class="mb-3">Detail Lelang</h4>
        <p><span class="info-label">Harga Awal:</span> $<?= number_format($lelang['harga_awal'],0,',','.') ?></p>
        <p><span class="info-label">Harga Akhir:</span> $<?= number_format($lelang['harga_akhir'],0,',','.') ?></p>
        <p><span class="info-label">Petugas:</span> <?= htmlspecialchars($lelang['petugas']) ?></p>
        <p><span class="info-label">Tanggal Lelang:</span> <?= date('d-m-Y', strtotime($lelang['tgl_lelang'])) ?></p>
    </div>

    <div class="winner-card">
        <h5>Informasi Pemenang</h5>
        <p><strong>Nama:</strong> <?= htmlspecialchars($lelang['pemenang']) ?></p>
        <p><strong>Telepon:</strong> <?= htmlspecialchars($lelang['telp_pemenang']) ?></p>
        <?php if (!empty($lelang['email_pemenang'])): ?>
            <p><strong>Email:</strong> <?= htmlspecialchars($lelang['email_pemenang']) ?></p>
        <?php endif; ?>
    </div>
</div>
            </div>
        </div>
        <h4 class="mt-5 mb-3" style="margin: 8rem" >History Penawaran</h4>
        <div class="table">
            <table class="table">
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
                        <?php $no=1; while ($row = mysqli_fetch_assoc($history)): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td>$<?= number_format($row['penawaran_harga'],0,',','.') ?></td>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>