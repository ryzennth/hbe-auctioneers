<?php
// koneksi ke database
$conn = new mysqli("localhost", "root", "", "lelang_online");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = $_POST['password']; // Enkripsi password
$telp = $_POST['telp'];

// Simpan ke database
$sql = "INSERT INTO `tb_masyarakat` (`nama_lengkap`, `username`, `password`, `telp`) VALUES (?, ?, ?, ?) ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nama_lengkap, $username, $password, $telp);

if ($stmt->execute()) {
    header("Location: login.php");
    exit();
} else {
    echo "Gagal mendaftar: " . $conn->error;
}

$conn->close();

?>