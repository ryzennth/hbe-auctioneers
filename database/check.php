<?php
include 'database/connect.php';

$username = $_POST['username'];
$password = $_POST['password'];
$sql = "SELECT * FROM account WHERE username = '$username' AND password = '$password'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    header('Location: admin/index.html');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}
?>