<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']); // Hapus error setelah ditampilkan
?>



<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Login</title>
  <style>
    body {
      margin: 0;
      font-family: sans-serif;
      background: linear-gradient(to right, #00bcd4, #2196f3);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      width: 300px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .btn {
      width: 100%;
      padding: 10px;
      background-color: #0d6efd;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #0b5ed7;
    }
    .login-link {
      text-align: center;
      margin-top: 10px;
    }
    .login-link a {
      color: #0d6efd;
      text-decoration: none;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Form Login</h2>
    <form method="POST" action="proses_login.php">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" placeholder="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="password" required>

      <!-- Pesan error ditampilkan di bawah input password -->
  <?php if (!empty($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>



      <button class="btn" type="submit">Login</button>
    </form>
    
    <div class="login-link">
      Belum punya akun? <a href="register.php">Daftar</a>
    </div>
  </div>

</body>
</html>