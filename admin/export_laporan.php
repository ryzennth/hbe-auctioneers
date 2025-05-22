<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login dan sebagai admin/petugas
if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}


include '../database/koneksi.php';

$type = $_GET['type'] ?? 'excel';

// Query untuk mendapatkan data lelang yang sudah ditutup
$sql = "SELECT 
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
        WHERE l.status = 'ditutup' AND l.id_user IS NOT NULL
        ORDER BY l.tgl_lelang DESC";

$result = mysqli_query($conn, $sql);

if ($type == 'excel') {
    // Header untuk file Excel
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Lelang_Dimenangkan_".date('Ymd').".xls");
    
    echo "<table border='1'>";
    echo "<tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga Awal</th>
            <th>Harga Akhir</th>
            <th>Pemenang</th>
            <th>Petugas</th>
            <th>Tanggal Lelang</th>
          </tr>";
    
    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$row['nama_barang']."</td>
                    <td>Rp".number_format($row['harga_awal'], 0, ',', '.')."</td>
                    <td>Rp".number_format($row['harga_akhir'], 0, ',', '.')."</td>
                    <td>".$row['pemenang']."</td>
                    <td>".$row['petugas']."</td>
                    <td>".date('d-m-Y', strtotime($row['tgl_lelang']))."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Belum ada data lelang yang dimenangkan</td></tr>";
    }
    
    echo "</table>";
    exit;
}
?>