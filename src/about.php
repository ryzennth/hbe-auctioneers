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
                            <a href="../admin/dashboard.php" style="display:block;padding:10px 20px;text-align:left;color:#000;text-decoration:none;">Dashboard Petugas</a>
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
        <section class="mb-5">
            <h1 class="mb-3">Tentang HBE Auctioneers</h1>
            <p>
                <strong>HBE Auctioneers</strong> adalah platform lelang online terpercaya nomor 1 di Indonesia yang telah menghubungkan ribuan penjual dan pembeli untuk mendapatkan penawaran terbaik. Kami menyediakan pengalaman lelang yang aman, transparan, dan mudah digunakan untuk semua kalangan, baik individu maupun perusahaan.
            </p>
            <p>
                Sejak didirikan, HBE Auctioneers berkomitmen untuk menjadi jembatan antara pemilik barang dan calon pembeli melalui sistem lelang yang inovatif dan efisien. Kami menawarkan berbagai kategori barang mulai dari barang antik, koleksi langka, elektronik, hingga kendaraan.
            </p>
            <p>
                Dengan dukungan tim profesional dan teknologi terkini, kami memastikan setiap proses lelang berjalan adil dan transparan. Keamanan data dan transaksi pengguna menjadi prioritas utama kami.
            </p>
        </section>
        <section class="mb-5">
            <h2 class="mb-3">Visi & Misi</h2>
            <ul>
                <li><strong>Visi:</strong> Menjadi platform lelang online terdepan dan terpercaya di Indonesia.</li>
                <li><strong>Misi:</strong>
                    <ul>
                        <li>Menyediakan layanan lelang yang mudah, aman, dan transparan.</li>
                        <li>Mendukung pertumbuhan ekonomi digital melalui transaksi lelang online.</li>
                        <li>Menghubungkan penjual dan pembeli dari seluruh Indonesia.</li>
                    </ul>
                </li>
            </ul>
        </section>
        
        <section>
            <h2>Our Team</h2>
            <div class="ourteam">
                    <div class="ourteam">
                        <img src="../img/kosong.jpeg" alt="Team Member 1">
                        <h5>Fauzan Muflih Hidayat</h5>
                        <p>Project Manager & Backend</p>
                    </div>
                    <div class="ourteam">
                        <img src="../img/kosong.jpeg" alt="Team Member 2">
                        <h5>Ashil Al-Aziz</h5>
                        <p>Frontend</p>
                    </div>
                    <div class="ourteam">
                        <img src="../img/kosong.jpeg" alt="Team Member 3">
                        <h5>Andien Khairun Nisa</h5>
                        <p>Graphic Desainer</p>
                    </div>
                    <div class="ourteam">
                        <img src="../img/kosong.jpeg" alt="Team Member 4">
                        <h5>Indri Nabila</h5>
                        <p>Social Media Admin</p>
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
            <li><a href="gethelp.php">Get Help</a></li>
            <li><a href="faq.php">FAQ</a></li>
          </ul>
        </div>
        <div>
          <p>Winning</p>
          <ul>
            <li><a href="howauctionworks.php">How Auction Works</a></li>
            <li><a href="auctioncalendar.php">Auction Calendar</a></li>
            <li><a href="auctionpriceresult.php">Auction Price Results</a></li>
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