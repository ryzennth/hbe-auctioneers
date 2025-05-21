<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Registrasi</title>
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
    <h2>Form Registrasi</h2>
    <form method="POST" action="proses_register.php">
      <label for="nama_lengkap">Nama lengkap</label>
      <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="nama lengkap" required>

      <label for="username">Username</label>
      <input type="text" id="password" name="username" placeholder="username" required>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="password" required>

      <label for="telp">No. Telepon</label>
      <input type="text" id="telp" name="telp" placeholder="No. Telepon" required>
      <!-- Pesan error ditampilkan di bawah input password -->
  <?php if (!empty($error)): ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
      <button class="btn" type="submit">Daftar</button>
    </form>
    
    <div class="login-link">
      Sudah punya akun? <a href="login.php">Login</a>
    </div>
  </div>

</body>
</html>