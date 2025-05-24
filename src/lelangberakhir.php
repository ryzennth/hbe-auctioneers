<?php
session_start();
include '../database/koneksi.php';
$query = "SELECT 
            l.id_lelang,
            b.nama_barang,
            b.foto,
            l.harga_akhir,
            m.username AS pemenang,
            l.tgl_lelang
          FROM tb_lelang l
          JOIN tb_barang b ON l.id_barang = b.id_barang
          JOIN tb_masyarakat m ON l.id_user = m.id_user
          WHERE l.status = 'ditutup'
          ORDER BY l.tgl_lelang DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lelang lainnya</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
<link rel="stylesheet" href="../style.css">
<style>
    .auction-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.auction-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  transition: all 0.3s ease;
  position: relative;
}

.auction-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.auction-badge {
  position: absolute;
  top: 15px;
  right: 15px;
  background-color: #4CAF50;
  color: white;
  padding: 0.3rem 0.8rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: bold;
  z-index: 2;
}

.auction-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-bottom: 1px solid #eee;
}

.auction-details {
  padding: 1.2rem;
}

.auction-title {
  font-size: 1.2rem;
  margin: 0 0 1rem 0;
  color: #333;
}

.auction-info {
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

.info-row {
  display: flex;
  justify-content: space-between;
}

.info-label {
  font-weight: 600;
  color: #555;
  font-size: 0.9rem;
}

.info-value {
  color: #333;
  font-size: 0.9rem;
}

.winner {
  color: #2196F3;
  font-weight: 600;
}

@media (max-width: 768px) {
  .auction-grid {
    grid-template-columns: 1fr;
  }
  
  .section-title {
    font-size: 1.5rem;
  }
}
</style>
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
    <main>
        <section>
   <div class="section-title">
  <a class="section-title">Lelang yang telah berakhir</a>
</div>
</section>
<section class="completed-auctions">
  <div class="auction-grid">
    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="auction-card">
          <div class="auction-badge">TERJUAL</div>
          <img src="../admin/upload/<?= htmlspecialchars($row['foto']) ?>" 
               alt="<?= htmlspecialchars($row['nama_barang']) ?>" 
               class="auction-image">
          <div class="auction-details">
            <h3 class="auction-title"><?= htmlspecialchars($row['nama_barang']) ?></h3>
            <div class="auction-info">
              <div class="info-row">
                <span class="info-label">Terjual:</span>
                <span class="info-value">$ <?= number_format($row['harga_akhir'], 0, ',', '.') ?></span>
              </div>
              <div class="info-row">
                <span class="info-label">Pemenang:</span>
                <span class="info-value winner">@<?= htmlspecialchars($row['pemenang']) ?></span>
              </div>
              <div class="info-row">
                <span class="info-label">Tanggal Tutup:</span>
                <span class="info-value"><?= date('d M Y', strtotime($row['tgl_lelang'])) ?></span>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="no-results">Belum ada lelang yang selesai</p>
    <?php endif; ?>
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