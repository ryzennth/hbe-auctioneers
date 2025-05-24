<?php
session_start();
include '../database/koneksi.php';

// Cek login
if (!isset($_SESSION['id_petugas']) && !isset($_SESSION['id_user'])) {
    header("Location: ../login/login.php");
    exit;
}

// Query untuk mendapatkan data hasil lelang
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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Lelang - HBE Auctioneers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .header-section {
            background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
        }
        .auction-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .auction-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        .auction-img {
            height: 200px;
            object-fit: fill;
            width: 100%;
        }
        .price-badge {
            font-size: 1.1rem;
            padding: 8px 15px;
            border-radius: 20px;
        }
        .original-price {
            text-decoration: line-through;
            color: #6c757d;
        }
        .winner-badge {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
        }
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .status-closed {
            background-color: #dc3545;
            color: white;
        }
        .search-box {
            max-width: 500px;
            margin: 0 auto 40px;
        }
        .pagination .page-item.active .page-link {
            background-color: #6e48aa;
            border-color: #6e48aa;
        }
        .pagination .page-link {
            color: #6e48aa;
        }
        .back-btn {
            background-color: #6e48aa;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background-color: #9d50bb;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            color: white;
        }
        .no-results {
            text-align: center;
            padding: 50px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .completed-auctions {
  max-width: 1200px;
  margin: 3rem auto;
  padding: 0 1rem;
}

.section-title2 {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 1.5rem;
  text-align: center;
  font-weight: 600;
  position: relative;
}

.section-title2::after {
  content: "";
  display: block;
  width: 80px;
  height: 3px;
  background: #4CAF50;
  margin: 0.5rem auto 0;
}

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
  height: 300px;
  object-fit: fill;
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
.auction-badge.ongoing {
  background-color: #FFC107; /* Warna kuning untuk lelang berlangsung */
  color: #333;
}

.no-results {
  grid-column: 1 / -1;
  text-align: center;
  padding: 2rem;
  color: #666;
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
    <!-- Header Section -->

    <!-- Search and Filter Section -->
    <div class="container">
        <div class="search-box">
            <div class="input-group mb-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari barang lelang..." aria-label="Cari barang lelang">
                <button class="btn btn-outline-secondary" type="button" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Auction Results Section -->
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
              <div>
                <a href="detail_lelang.php?id=<?= $row['id_lelang'] ?>" class="btn btn-primary btn-sm">Detail</a>
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

        

    <!-- Back Button -->
    <div class="container text-center mb-5">
        <a href="dashboard.php" class="back-btn">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi pencarian
        document.getElementById('searchButton').addEventListener('click', function() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const auctionItems = document.querySelectorAll('.auction-item');
            
            auctionItems.forEach(item => {
                const itemName = item.querySelector('.card-title').textContent.toLowerCase();
                if (itemName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Fungsi enter untuk pencarian
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('searchButton').click();
            }
        });

        // Animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.auction-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
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