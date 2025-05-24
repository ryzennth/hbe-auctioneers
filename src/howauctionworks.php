<?php
session_start();
include '../database/koneksi.php';

// Cek login
if (!isset($_SESSION['id_petugas']) && !isset($_SESSION['id_user'])) {
    header("Location: ../login/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cara Kerja Lelang - HBE Auctioneers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg,rgb(74, 72, 170) 0%,rgb(80, 144, 187) 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 50px;
        }
        .step-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 30px;
            height: 100%;
        }
        .step-card:hover {
            transform: translateY(-10px);
        }
        .step-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #6e48aa;
        }
        .step-number {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color:rgb(87, 72, 170);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
            font-weight: bold;
        }
        .faq-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .faq-question {
            font-weight: 600;
            color:rgb(87, 72, 170);
            cursor: pointer;
        }
        .back-btn {
            background-color:rgb(90, 72, 170);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .back-btn:hover {
            background-color:rgb(80, 153, 187);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div id="page-loader">
    <div class="loader-logo">HBE Auctioneers</div>
  </div>
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Bagaimana Lelang Online Bekerja</h1>
            <p class="lead">Pelajari cara mudah berpartisipasi dalam lelang online kami dan dapatkan barang yang Anda inginkan</p>
        </div>
    </section>

    <!-- How It Works Steps -->
    <section class="container mb-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card step-card p-4 text-center">
                    <div class="step-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>1. Temukan Barang</h3>
                    <p>Jelajahi berbagai barang lelang yang tersedia di platform kami. Gunakan filter untuk menemukan barang yang sesuai dengan minat Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card p-4 text-center">
                    <div class="step-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>2. Daftar & Verifikasi</h3>
                    <p>Buat akun dan lengkapi verifikasi identitas Anda untuk dapat berpartisipasi dalam lelang. Proses ini cepat dan mudah.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card p-4 text-center">
                    <div class="step-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <h3>3. Ikuti Lelang</h3>
                    <p>Ajukan penawaran Anda selama periode lelang berlangsung.</p>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card step-card p-4 text-center">
                    <div class="step-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3>4. Menangkan Lelang</h3>
                    <p>Jika penawaran Anda yang tertinggi ketika lelang ditutup, Anda akan dinyatakan sebagai pemenang.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card p-4 text-center">
                    <div class="step-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h3>5. Lakukan Pembayaran</h3>
                    <p>Lakukan pembayaran sesuai dengan harga akhir lelang dalam waktu yang telah ditentukan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card step-card p-4 text-center">
                    <div class="step-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3>6. Terima Barang</h3>
                    <p>Barang akan dikirimkan ke alamat Anda setelah pembayaran dikonfirmasi.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Steps -->
    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h2 class="text-center mb-4">Proses Lebih Detail</h2>
                
                <div class="d-flex align-items-start mb-4">
                    <span class="step-number">1</span>
                    <div>
                        <h4>Pendaftaran Akun</h4>
                        <p>Untuk mulai berpartisipasi dalam lelang, Anda perlu membuat akun terlebih dahulu. Isi formulir pendaftaran dengan data yang valid dan lengkap. Setelah pendaftaran, Anda akan menerima email verifikasi untuk mengaktifkan akun.</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-4">
                    <span class="step-number">2</span>
                    <div>
                        <h4>Verifikasi Identitas</h4>
                        <p>Untuk keamanan transaksi, kami membutuhkan verifikasi identitas. Anda dapat mengunggah foto KTP atau identitas resmi lainnya melalui dashboard akun Anda. Proses verifikasi biasanya selesai dalam 1-2 hari kerja.</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-4">
                    <span class="step-number">3</span>
                    <div>
                        <h4>Penjelajahan Barang Lelang</h4>
                        <p>Gunakan fitur pencarian dan filter untuk menemukan barang yang sesuai. Setiap barang lelang memiliki halaman detail yang berisi informasi lengkap termasuk foto, deskripsi, harga awal, dan waktu berakhirnya lelang.</p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-4">
                    <span class="step-number">4</span>
                    <div>
                        <h4>Proses Penawaran</h4>
                        <p>Untuk mengajukan penawaran:
                            <ul>
                                <li>Masuk ke akun Anda</li>
                                <li>Kunjungi halaman detail barang</li>
                                <li>Masukkan jumlah penawaran (harus lebih tinggi dari harga saat ini)</li>
                                <li>Konfirmasi penawaran</li>
                            </ul>
                            Sistem akan secara otomatis meningkatkan penawaran Anda jika ada penawaran lain yang lebih tinggi.
                        </p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-4">
                    <span class="step-number">5</span>
                    <div>
                        <h4>Penutupan Lelang</h4>
                        <p>Ketika waktu lelang berakhir:
                            <ul>
                                <li>Pemenang adalah peserta dengan penawaran tertinggi</li>
                                <li>Anda akan menerima notifikasi melalui email dan di dashboard akun</li>
                                <li>Detail pembayaran akan dikirimkan kepada pemenang</li>
                            </ul>
                        </p>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-4">
                    <span class="step-number">6</span>
                    <div>
                        <h4>Pembayaran dan Pengiriman</h4>
                        <p>Setelah memenangkan lelang:
                            <ul>
                                <li>Lakukan pembayaran dalam waktu 48 jam</li>
                                <li>Konfirmasi pembayaran dengan mengunggah bukti transfer</li>
                                <li>Barang akan dikirim setelah pembayaran diverifikasi</li>
                                <li>Anda akan menerima nomor resi pengiriman</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center mb-4">Pertanyaan yang Sering Diajukan</h2>
                
                <div class="faq-item">
                    <div class="faq-question">Apa yang terjadi jika saya tidak melakukan pembayaran setelah memenangkan lelang?</div>
                    <div class="faq-answer mt-2">Jika pembayaran tidak dilakukan dalam waktu yang ditentukan, kemenangan lelang akan dibatalkan dan barang akan ditawarkan kembali atau diberikan kepada penawar berikutnya. Akun Anda mungkin juga terkena sanksi.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Bisakah saya membatalkan penawaran yang sudah saya ajukan?</div>
                    <div class="faq-answer mt-2">Penawaran yang sudah diajukan tidak dapat dibatalkan. Pastikan Anda benar-benar ingin membeli barang tersebut sebelum mengajukan penawaran.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Bagaimana cara mengetahui bahwa penawaran saya adalah yang tertinggi?</div>
                    <div class="faq-answer mt-2">Anda dapat melihat status penawaran di halaman detail barang.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Apakah ada biaya tambahan selain harga penawaran?</div>
                    <div class="faq-answer mt-2">Tergantung pada kebijakan penjual. Beberapa barang mungkin memiliki biaya pengiriman atau biaya layanan tambahan yang akan diinformasikan secara jelas di halaman detail barang.</div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">Bagaimana jika barang yang diterima tidak sesuai deskripsi?</div>
                    <div class="faq-answer mt-2">Anda dapat mengajukan klaim dalam waktu 3 hari setelah barang diterima. Tim kami akan memverifikasi dan membantu menyelesaikan masalah tersebut.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Back Button -->
    <div class="container text-center mb-5">
        <a href="../index.php" class="back-btn">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple FAQ toggle functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                answer.style.display = answer.style.display === 'none' ? 'block' : 'none';
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