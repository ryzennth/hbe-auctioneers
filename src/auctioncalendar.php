<?php
session_start();
include '../database/koneksi.php';

// Cek login
if (!isset($_SESSION['id_petugas']) && !isset($_SESSION['id_user'])) {
    header("Location: ../login/login.php");
    exit;
}

// Ambil data lelang untuk kalender
$query = mysqli_query($conn, "
    SELECT 
        l.id_lelang,
        b.nama_barang,
        l.tgl_lelang,
        l.status,
        b.foto,
        b.harga_awal,
        l.harga_akhir,
        m.username AS pemenang,
        p.nama_petugas
    FROM tb_lelang l
    JOIN tb_barang b ON l.id_barang = b.id_barang
    LEFT JOIN tb_masyarakat m ON l.id_user = m.id_user
    LEFT JOIN tb_petugas p ON l.id_petugas = p.id_petugas
    ORDER BY l.tgl_lelang
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Auction Calendar - HBE Auctioneers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .calendar-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .fc-event {
            cursor: pointer;
        }
        .auction-details {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0,0,0,0.3);
            z-index: 1000;
            max-width: 500px;
            width: 90%;
        }
        .close-details {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
        .event-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-open {
            background-color: #28a745;
            color: white;
        }
        .status-closed {
            background-color: #dc3545;
            color: white;
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
          <a href=".../admin/dashboard.php" style="display:block;padding:10px 20px;text-align:left;color:#000;text-decoration:none;">Dashboard Admin</a>
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
<div class="container">
    <h1 class="text-center mb-4">Auction Calendar</h1>
    
    <div class="calendar-container">
        <div id="calendar"></div>
    </div>
    
    <div class="text-center mb-4">
        <a href="../index.php" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>

<!-- Modal untuk detail lelang -->
<div id="auctionDetails" class="auction-details">
    <span class="close-details">&times;</span>
    <div id="detailContent"></div>
</div>

<!-- Overlay -->
<div id="overlay" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:999;"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/id.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Format data untuk FullCalendar
        const auctionEvents = [
            <?php while($row = mysqli_fetch_assoc($query)): ?>
            {
                id: '<?= $row['id_lelang'] ?>',
                title: '<?= addslashes($row['nama_barang']) ?>',
                start: '<?= $row['tgl_lelang'] ?>',
                extendedProps: {
                    status: '<?= $row['status'] ?>',
                    foto: '<?= $row['foto'] ?>',
                    harga_awal: <?= $row['harga_awal'] ?>,
                    harga_akhir: <?= $row['harga_akhir'] ?>,
                    pemenang: '<?= addslashes($row['pemenang'] ?? '-') ?>',
                    petugas: '<?= addslashes($row['nama_petugas'] ?? '-') ?>'
                },
                backgroundColor: '<?= $row['status'] === 'dibuka' ? '#28a745' : '#dc3545' ?>',
                borderColor: '<?= $row['status'] === 'dibuka' ? '#218838' : '#c82333' ?>'
            }
        
    ,
            <?php endwhile; ?>
        ];
        // Inisialisasi kalender
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: auctionEvents,
            eventClick: function(info) {
                showAuctionDetails(info.event);
            },
            eventContent: function(arg) {
                // Custom event content
                const status = arg.event.extendedProps.status === 'dibuka' ? 
                    '<span class="event-status status-open">Aktif</span>' : 
                    '<span class="event-status status-closed">Selesai</span>';
                
                return {
                    html: `
                        <div class="fc-event-main-frame">
                            <div class="fc-event-title-container">
                                <div class="fc-event-title">${arg.event.title}</div>
                            </div>
                            <div class="fc-event-status">${status}</div>
                        </div>
                    `
                };
            }
        });
        calendar.render();
    
        // Fungsi untuk menampilkan detail lelang
        function showAuctionDetails(event) {
            const details = event.extendedProps;
            const statusClass = event.extendedProps.status === 'dibuka' ? 'status-open' : 'status-closed';
            const statusText = event.extendedProps.status === 'dibuka' ? 'Sedang Berlangsung' : 'Selesai';
            
            document.getElementById('detailContent').innerHTML = `
                <h3>${event.title}</h3>
                <div class="text-center mb-3">
                    <img src="../admin/upload/${details.foto}" alt="${event.title}" class="img-fluid" style="max-height: 200px;">
                </div>
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal Lelang</th>
                        <td>${event.startStr}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="event-status ${statusClass}">${statusText}</span></td>
                    </tr>
                    <tr>
                        <th>Harga Awal</th>
                        <td>Rp ${details.harga_awal.toLocaleString('id-ID')}</td>
                    </tr>
                    <tr>
                        <th>Harga Tertinggi</th>
                        <td>Rp ${details.harga_akhir.toLocaleString('id-ID')}</td>
                    </tr>
                    <tr>
                        <th>Pemenang</th>
                        <td>${details.pemenang}</td>
                    </tr>
                    <tr>
                        <th>Petugas</th>
                        <td>${details.petugas}</td>
                    </tr>
                </table>
            `;
            
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('auctionDetails').style.display = 'block';
        }

        // Tutup modal
        document.querySelector('.close-details').addEventListener('click', function() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('auctionDetails').style.display = 'none';
        });
        
        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('auctionDetails').style.display = 'none';
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
          <p>Auction</p>
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