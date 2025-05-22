<?php
session_start();
include 'database/koneksi.php';
// Ambil lelang yang sedang dibuka beserta data barangnya
$lelang = mysqli_query($conn, "
  SELECT l.id_lelang, l.id_barang, l.tgl_lelang, l.harga_akhir, l.status, b.nama_barang, b.foto, b.harga_awal
  FROM tb_lelang l
  JOIN tb_barang b ON l.id_barang = b.id_barang
  WHERE l.status = 'dibuka'
  ORDER BY l.tgl_lelang DESC
  LIMIT 6
");
?>

<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>HBE Auctioneers</title>
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="style.css">
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
          <a href="admin/dashboard.php" style="display:block;padding:10px 20px;text-align:left;color:#000;text-decoration:none;">Dashboard Admin</a>
        <?php elseif (isset($_SESSION['level']) && $_SESSION['level'] == 2): ?>
          <a href="admin/dashboardpetugas.php" style="display:block;padding:10px 20px;text-align:left;color:#000;text-decoration:none;">Dashboard Petugas</a>
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
    <a href="login/login.php" aria-label="Log In">Log In</a>
    <a href="login/register.php" class="btn-signin" aria-label="Sign In">Sign in</a>
  <?php endif; ?>
</nav>
  </header>
  <main>
    <section>
      <h1>Mari mulai sesi lelangmu disini</h1>
      <p class="lead">selamat datang di HBE Auctioneers, tempat lelang online terpercaya nomor 1 di Indonesia</p>
    </section>
    <!-- Carousel Section -->
<section>
  <div class="carousel-container" style="position:relative; width:100%; height:300px; margin-bottom:32px;">
    <img class="carousel-slide" src="img/Platform lelang terlengkap se indonesia.png" alt="hbebanner" style="width:100%; height:100%; object-fit:cover; border-radius:8px; position:absolute; left:0; top:0; opacity:1; transition:opacity 0.7s;">
    <img class="carousel-slide" src="img/billy.jpeg" alt="billy kid" style="width:100%; height:100%; object-fit:cover; border-radius:8px; position:absolute; left:0; top:0; opacity:0; transition:opacity 0.7s;">
    <img class="carousel-slide" src="img/anton.jpeg" alt="anton ivanov" style="width:100%; height:100%; object-fit:cover; border-radius:8px; position:absolute; left:0; top:0; opacity:0; transition:opacity 0.7s;">
    <img class="carousel-slide" src="img/anby.jpeg" alt="anby demara" style="width:100%; height:100%; object-fit:cover; border-radius:8px; position:absolute; left:0; top:0; opacity:0; transition:opacity 0.7s;">
  </div>
</section>
    <section>
      <div class="section-title">
  <a href="src/lelang.php" class="section-title">Lelang Saat ini</a>
</div>
  <div class="current-auctions">
    <?php if (mysqli_num_rows($lelang) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($lelang)): ?>
        <article class="auction-item">
          <a href="lelang/penawaran.php?id=<?php echo $row['id_barang']; ?>">
            <img class="auction-item img"
              src="admin/upload/<?php echo htmlspecialchars($row['foto']); ?>"
              alt="<?php echo htmlspecialchars($row['nama_barang']); ?>"
            />
          </a>
          <h3><?php echo htmlspecialchars($row['nama_barang']); ?></h3>
          <p>
            $<?php
              $harga = ($row['harga_akhir'] > 0) ? $row['harga_akhir'] : $row['harga_awal'];
              echo number_format($harga, 2, '.', ',');
            ?>
          </p>
          <span>(Sedang Berlangsung)</span>
        </article>
      <?php endwhile; ?>
    <?php else: ?>
      <p>Tidak ada lelang yang sedang berlangsung saat ini.</p>
    <?php endif; ?>
  </div>
</section>
</div>
    </section>
    <section class="top-comment" aria-label="Top Comment">
      <h2 class="section-title">Top Comment</h2>
      <div class="comments-list">
        <article class="comment-card">
          <p class="comment-text">“Bisa sediain Monalisa ga?”</p>
          <div class="comment-author">
            <img
              src="https://storage.googleapis.com/a1aa/image/bcb01df4-91d3-459b-f8eb-a6cb475b085a.jpg"
              alt="Avatar of Arthur Jayawardana Diningrat"
              width="24"
              height="24"
            />
            <div class="author-info">
              <p class="author-name">Arthur Jayawardana Diningrat</p>
              <p class="author-role">JW CEO</p>
            </div>
          </div>
        </article>
        <article class="comment-card">
          <p class="comment-text">“A fantastic bit of feedback”</p>
          <div class="comment-author">
            <img
              src="https://storage.googleapis.com/a1aa/image/2ed44253-fbe6-48f0-eddf-0a441af9b4ce.jpg"
              alt="Avatar of Lily Serval Viriel"
              width="24"
              height="24"
            />
            <div class="author-info">
              <p class="author-name">Lily Serval Viriel</p>
              <p class="author-role">United Kingdom Princess</p>
            </div>
          </div>
        </article>
        <article class="comment-card">
          <p class="comment-text">“Mainan lama bikin nostalgia”</p>
          <div class="comment-author">
            <img
              src="https://storage.googleapis.com/a1aa/image/061ae910-d34c-412a-fd3d-59d6c3d00f70.jpg"
              alt="Avatar of Gunawan Saputra"
              width="24"
              height="24"
            />
            <div class="author-info">
              <p class="author-name">Gunawan Saputra</p>
              <p class="author-role">Old Toy Collector</p>
            </div>
          </div>
        </article>
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
            <li><a href="src/about.php">About</a></li>
            <li><a href="src/gethelp.php">Get Help</a></li>
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
  <footer class="text-center py-4"><p class="mt-2 mb-0">&copy; <?php echo date('Y'); ?> HBE Auctioneers. All rights reserved.</p></footer>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script>
  let slideIndex = 0;
  const slides = document.querySelectorAll('.carousel-slide');
  function showSlides() {
    slides.forEach((img, i) => {
      img.style.opacity = (i === slideIndex) ? '1' : '0';
    });
    slideIndex = (slideIndex + 1) % slides.length;
    setTimeout(showSlides, 3000); // Ganti gambar setiap 3 detik
  }
  if (slides.length > 0) showSlides();
</script>
<script>
  // ...carousel script...
  // Smooth scroll to top
  document.getElementById('btn-top').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
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