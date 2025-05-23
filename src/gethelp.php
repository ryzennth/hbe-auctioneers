<?php
session_start();
include '../database/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - HBE Auctioneers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div id="page-loader">
    <div class="loader-logo">HBE Auctioneers</div>
  </div>
    <header>
        <div class="logo" aria-label="HBE Auctioneers logo">
            <span>HBE</span><span>Auctioneers</span>
        </div>
        <nav>
            <?php if (isset($_SESSION['username'])): ?>
                <div class="user-dropdown" style="position:relative;">
                    <button id="userBtn" style="background:none;border:none;font-weight:600;cursor:pointer;">
                        👤 <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </button>
                    <div id="logoutMenu" style="display:none;position:absolute;right:0;top:120%;background:#fff;border:1px solid #ccc;border-radius:4px;box-shadow:0 2px 8px #0001;z-index:10;min-width:140px;">
                        <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
                            <a href="../admin/dashboard.php" style="display:block;padding:10px 20px;text-align:left;color:#000;text-decoration:none;">Dashboard Admin</a>
                        <?php elseif (isset($_SESSION['level']) && $_SESSION['level'] == 2): ?>
                            <a href="../admin/dashboardpetugas.php" style="display:block;padding:10px 20px;text-align:left;color:#000;text-decoration:none;">Dashboard Petugas</a>
                        <?php endif; ?>
                        <form method="post" style="margin:0;">
                            <button type="submit" name="logout" style="background:none;border:none;padding:10px 20px;width:100%;text-align:left;cursor:pointer;">Logout</button>
                        </form>
                    </div>
                </div>
                <?php
                if (isset($_POST['logout'])) {
                    session_destroy();
                    echo "<script>window.location.href=window.location.pathname;</script>";
                    exit;
                }
                ?>
                <script>
                    const userBtn = document.getElementById('userBtn');
                    const logoutMenu = document.getElementById('logoutMenu');
                    document.addEventListener('click', function(e) {
                        if (userBtn && logoutMenu) {
                            if (userBtn.contains(e.target)) {
                                logoutMenu.style.display = logoutMenu.style.display === 'block' ? 'none' : 'block';
                            } else {
                                logoutMenu.style.display = 'none';
                            }
                        }
                    });
                </script>
            <?php else: ?>
                <a href="../login/login.php" aria-label="Log In">Log In</a>
                <a href="../login/register.php" class="btn-signin" aria-label="Sign In">Sign in</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="container py-5">
        <section>
            <div class="container mt-5">
                <div class="card shadow">
                    <div class="card-body">
                        <div>
                        <img src="../img/mascot.png" alt="mascot" class="float-start me-3" style="width: 300px; height: 300px;">
                        <h2 class="mb-3">Kontak Kami</h2>
                        <p>
                            Jika Anda memiliki pertanyaan, saran, atau ingin bekerja sama, silakan hubungi kami melalui:
                        </p>
                        <ul>
                            <li>Email: <a href="mailto:info@hbeauctioneers.com">info@hbeauctioneers.com</a></li>
                            <li>WhatsApp: <a href="https://wa.me/+6281387318907" target="_blank">+62 813-8731-8907</a></li>
                            <li>Instagram: <a href="https://www.instagram.com/hbe_auctioneers" target="_blank">@hbe_auctioneers</a></li>
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
    <div class="footer-top">
      <h3>Mentok...</h3>
      <div class="footer-buttons">
        <a href="#" id="btn-top"><button class="btn-black" type="button">Balik Ke Atas</button></a>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-bottom-top">
        <div class="footer-logo" aria-label="HBE Auctioneers logo">
          <span>HBE</span><span>Auctioneers</span>
        </div>
        <div class="col-md-4 mb-4 mb-md-0 text-center text-md-end">
          <a href="#" style="margin-right: 15px; color:rgb(0, 0, 0); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="https://wa.me/+6281387318907" style="margin-right: 15px; color:rgb(10, 10, 10); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-whatsapp"></i>
          </a>
          <a href="https://www.instagram.com/hbe_auctioneers?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" style="margin-right: 15px; color:rgb(8, 8, 8); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-instagram"></i>
          </a>
          <a href="https://www.tiktok.com/@hbe_auctioneers?is_from_webapp=1&sender_device=pc" style="margin-right: 15px; color:rgb(10, 10, 10); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-tiktok"></i>
          </a>
        </div>
      </div>
      </div>
      <div class="footer-links">
        <div>
          <p>HBE Auctioneers is the most comprehensive and trusted online auction platform in Indonesia, which has successfully connected sellers and buyers to get the best deals.</p>
      </div>
      <div>
          <p>Company</p>
          <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="#">Get Help</a></li>
            <li><a href="#">Careers</a></li>
          </ul>
        </div>
        <div>
          <p>Winning</p>
          <ul>
            <li><a href="#">How Auction Works</a></li>
            <li><a href="#">Auction Calendar</a></li>
            <li><a href="#">Auction Price Results</a></li>
          </ul>
        </div>
      </div>
    </div>   
  </footer>
    <footer class="text-center py-4">
        <p class="copyright">&copy; <?php echo date('Y'); ?> HBE Auctioneers. All rights reserved.</p>
    </footer>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
  const loader = document.getElementById('page-loader');
  setTimeout(() => {
    document.body.classList.add('loaded');
    setTimeout(() => {
      if (loader) loader.style.display = 'none';
    }, 700);
  }, 1000);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>