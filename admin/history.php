<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

include '../database/koneksi.php';

// Ambil parameter filter tanggal dengan sanitasi
$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';

// Validasi format tanggal
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

// Query dasar untuk mendapatkan data lelang
$sql = "SELECT 
            l.id_lelang,
            b.nama_barang,
            b.harga_awal,
            l.harga_akhir,
            m.nama_lengkap AS pemenang,
            p.nama_petugas AS petugas,
            l.tgl_lelang
        FROM tb_lelang l
        JOIN tb_barang b ON l.id_barang = b.id_barang
        LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
        LEFT JOIN tb_petugas p ON l.id_petugas = p.id_petugas
        WHERE l.status = 'ditutup' AND l.id_user IS NOT NULL";

$params = [];
$types = '';

// Tambahkan kondisi filter tanggal jika ada
if (!empty($start_date) && validateDate($start_date)) {
    if (!empty($end_date) && validateDate($end_date)) {
        $sql .= " AND DATE(l.tgl_lelang) BETWEEN ? AND ?";
        $params[] = $start_date;
        $params[] = $end_date;
        $types .= 'ss';
    } else {
        $sql .= " AND DATE(l.tgl_lelang) >= ?";
        $params[] = $start_date;
        $types .= 's';
    }
} elseif (!empty($end_date) && validateDate($end_date)) {
    $sql .= " AND DATE(l.tgl_lelang) <= ?";
    $params[] = $end_date;
    $types .= 's';
}

$sql .= " ORDER BY l.tgl_lelang DESC";

// Persiapkan statement
$stmt = mysqli_prepare($conn, $sql);

// Bind parameter jika ada filter tanggal
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Eksekusi query
if (!mysqli_stmt_execute($stmt)) {
    die("Error executing query: " . mysqli_error($conn));
}

$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Laporan Lelang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    body {
      background-color: #f8f9fa;
    }
    /* CSS khusus untuk cetak (print) */


      /* Bikin main content penuh halaman */
      .main-content {
        margin: 3rem;
        padding: 1rem;
        box-shadow: none !important;
        border-radius: 0 !important;
      }

      /* Table full lebar dan rapi */
      table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 11pt;
      }

      table th, table td {
        border: 1px solid #000 !important;
        padding: 8px !important;
        text-align: center !important;
        white-space: normal !important; /* supaya teks bisa wrap */
      }
  </style>
</head>
<body>
<main>
  </div>
</main>
<section>
  <div class="main-content">
    <h2 class="text-center mb-4">History Lelang yang Sudah Dimenangkan</h2>
    <form method="GET" action="" class="row g-3 align-items-end mb-3" id="filterForm">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" 
                           value="<?= htmlspecialchars($start_date) ?>" max="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" 
                           value="<?= htmlspecialchars($end_date) ?>" max="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="history.php" class="btn btn-secondary w-100">Reset</a>
                </div>
                <a href="dashboard.php" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>
            </form>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga Awal</th>
            <th>Harga Akhir</th>
            <th>Pemenang</th>
            <th>Petugas</th>
            <th>Tanggal Lelang</th>
            <th class="no-print">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) > 0): ?>
            <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td>$<?= number_format($row['harga_awal'], 0, ',', '.') ?></td>
                <td>$<?= number_format($row['harga_akhir'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['pemenang']) ?></td>
                <td><?= htmlspecialchars($row['petugas']) ?></td>
                <td><?= date('d-m-Y', strtotime($row['tgl_lelang'])) ?></td>
                <td class="no-print">
                  <a href="detail_lelang.php?id=<?= $row['id_lelang'] ?>" class="btn btn-primary btn-sm">Detail</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center">Belum ada data lelang yang dimenangkan</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
