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
    <h1 class="mb-4">Frequently Asked Questions (FAQ)</h1>
    <div class="accordion" id="faqAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq1-heading">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                    Apa itu HBE Auctioneers?
                </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faq1-heading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    HBE Auctioneers adalah platform lelang online terpercaya yang menghubungkan penjual dan pembeli untuk mendapatkan penawaran terbaik secara transparan dan aman.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq2-heading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                    Bagaimana cara mengikuti lelang?
                </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2-heading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda harus mendaftar akun terlebih dahulu, lalu login dan pilih barang yang ingin diikuti lelangnya. Setelah itu, Anda bisa memasukkan penawaran pada halaman detail barang.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq3-heading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                    Apakah ada biaya untuk mengikuti lelang?
                </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3-heading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Tidak ada biaya pendaftaran. Namun, jika Anda memenangkan lelang, Anda wajib membayar harga akhir barang yang Anda menangkan.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="faq4-heading">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                    Bagaimana jika saya menang lelang?
                </button>
            </h2>
            <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faq4-heading" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Anda akan mendapatkan notifikasi dan instruksi pembayaran melalui akun Anda. Setelah pembayaran diverifikasi, barang akan dikirim ke alamat Anda.
                </div>
            </div>
        </div>
    </div>
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