<?php
session_start();
include '../database/koneksi.php';

if (!isset($_SESSION['id_petugas']) || !in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../login/login.php");
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
if (!$id) {
    header("Location: barang.php");
    exit;
}

// Ambil nama file foto
$result = mysqli_query($conn, "SELECT foto FROM tb_barang WHERE id_barang='$id'");
$data = mysqli_fetch_assoc($result);

if ($data && !empty($data['foto'])) {
    $foto_path = "upload/" . $data['foto'];
    if (file_exists($foto_path)) {
        unlink($foto_path); // Hapus file foto
    }
}

// Hapus data barang dari database
$query = "DELETE FROM tb_barang WHERE id_barang='$id'";
mysqli_query($conn, $query); // ← ini yang tadinya kurang

echo "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          Swal.fire({
            title: 'Berhasil!',
            text: 'Barang berhasil dihapus',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#007bff',
            allowOutsideClick: false
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = 'pendataanbarang.php';
            }
          });
        });
      </script>";
exit;
?>
