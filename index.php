<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>HBE Auctioneers</title>
  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
</head>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap');
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: #fff;
      color: #000;
    }
    a {
      color: inherit;
      text-decoration: none;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 16px 40px;
      flex-wrap: wrap;
    }
    .logo {
      font-weight: 800;
      font-size: 18px;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .logo span:first-child {
      font-weight: 800;
    }
    .search-form {
      display: flex;
      border: 1px solid #ccc;
      border-radius: 4px;
      overflow: hidden;
      margin: 8px 0;
      flex-grow: 1;
      max-width: 300px;
      min-width: 180px;
    }
    .search-form input[type="search"] {
      border: none;
      padding: 6px 8px;
      font-size: 14px;
      flex-grow: 1;
      outline-offset: -2px;
    }
    .search-form button {
      background: transparent;
      border: none;
      padding: 6px 10px;
      cursor: pointer;
      color: #000;
      font-size: 16px;
    }
    nav {
      display: flex;
      align-items: center;
      gap: 20px;
      font-size: 14px;
      white-space: nowrap;
    }
    nav a {
      color: #000;
    }
    .btn-signin {
      background: #000;
      color: #fff;
      border-radius: 4px;
      padding: 6px 14px;
      font-size: 14px;
      cursor: pointer;
      border: none;
    }
    main {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 40px 80px;
    }
    h1 {
      font-weight: 800;
      font-size: 28px;
      margin-bottom: 8px;
      line-height: 1.1;
    }
    p.lead {
      color: #666;
      font-size: 14px;
      max-width: 400px;
      margin-top: 0;
      margin-bottom: 40px;
    }
    .hero-image {
      width: 100%;
      border-radius: 8px;
      object-fit: cover;
      height: 300px;
      margin-bottom: 56px;
    }
    h2.section-title {
      font-weight: 600;
      font-size: 20px;
      margin-bottom: 24px;
    }
    .current-auctions {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
      gap: 24px;
      margin-bottom: 56px;
    }
    .auction-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 8px;
    }
    .auction-item h3 {
      font-weight: 600;
      font-size: 14px;
      margin: 0 0 4px 0;
    }
    .auction-item p {
      font-weight: 700;
      font-size: 13px;
      margin: 0;
      display: inline;
    }
    .auction-item span {
      font-weight: 400;
      font-size: 13px;
      margin-left: 4px;
      color: #444;
    }
    .top-trend {
      display: grid;
      grid-template-columns: 1fr 1.5fr;
      gap: 32px;
      margin-bottom: 56px;
    }
    .trend-text p {
      font-size: 13px;
      color: #666;
      margin-top: 4px;
      margin-bottom: 16px;
      max-width: 360px;
      line-height: 1.3;
    }
    .trend-text p strong {
      font-weight: 600;
      color: #000;
      display: block;
      margin-bottom: 4px;
    }
    .trend-image {
      width: 100%;
      border-radius: 8px;
      object-fit: cover;
      height: 400px;
    }
    .others-art {
      margin-bottom: 56px;
    }
    .others-art-list {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(320px,1fr));
      gap: 24px;
    }
    .others-art-item img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 8px;
    }
    .others-art-item h3 {
      font-weight: 600;
      font-size: 14px;
      margin: 0 0 4px 0;
    }
    .others-art-item p {
      font-weight: 700;
      font-size: 13px;
      margin: 0;
      display: inline;
    }
    .others-art-item span {
      font-weight: 400;
      font-size: 13px;
      margin-left: 4px;
      color: #444;
    }
    .top-comment {
      margin-bottom: 56px;
    }
    .comments-list {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
      gap: 24px;
    }
    .comment-card {
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 16px;
      font-size: 13px;
      color: #444;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 140px;
    }
    .comment-text {
      font-weight: 600;
      margin-bottom: 16px;
      text-align: center;
      color: #000;
      font-size: 14px;
      line-height: 1.3;
    }
    .comment-author {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .comment-author img {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      object-fit: cover;
    }
    .author-info p {
      margin: 0;
      line-height: 1.1;
    }
    .author-name {
      font-weight: 600;
      font-size: 13px;
      color: #000;
    }
    .author-role {
      font-weight: 400;
      font-size: 12px;
      color: #888;
    }
    footer {
      background: #f7f7f7;
      padding: 24px 40px;
      font-size: 14px;
      color: #444;
    }
    .footer-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 24px;
      margin-left: 35px;
    }
    .footer-top h3 {
      font-weight: 800;
      font-size: 20px;
      margin: 0 0 12px 0;
    }
    .footer-buttons {
      display: flex;
      gap: 16px;
    }
    .btn-black {
      background: #000;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 8px 20px;
      cursor: pointer;
      font-size: 14px;
    }
    .btn-gray {
      background: #d3d3d3;
      color: #000;
      border: none;
      border-radius: 4px;
      padding: 8px 20px;
      cursor: pointer;
      font-size: 14px;
    }
    .footer-bottom {
      border-top: 1px solid #ccc;
      padding-top: 24px;
      max-width: 1200px;
      margin: 0 auto;
    }
    .footer-bottom-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      margin-bottom: 24px;
    }
    .footer-logo {
      font-weight: 800;
      font-size: 16px;
      display: flex;
      gap: 4px;
      color: #000;
    }
    .footer-logo span:last-child {
      font-weight: 400;
    }
    .social-icons {
      display: flex;
      gap: 20px;
      font-size: 16px;
      color: #444;
    }
    .social-icons a:hover {
      color: #000;
    }
    .footer-links {
      display: grid;
      grid-template-columns: repeat(auto-fit,minmax(160px,1fr));
      gap: 24px;
      font-size: 13px;
      color: #444;
    }
    .footer-links p {
      font-weight: 600;
      margin-bottom: 12px;
      color: #000;
      margin-left: 35px;
    }
    .footer-links ul {
      list-style: none;
      padding: 0;
      margin: 25px;
    }
    .footer-links li {
      margin-bottom: 8px;
      margin: 10px;
    }
    .footer-links a:hover {
      text-decoration: underline;
    }
    @media (max-width: 768px) {
      header {
        padding: 16px 20px;
      }
      main {
        padding: 0 20px 40px;
      }
      .top-trend {
        grid-template-columns: 1fr;
      }
      .trend-image {
        height: 280px;
        margin-top: 16px;
      }
      .footer-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
      }
      .footer-buttons {
        width: 100%;
        justify-content: flex-start;
      }
      .footer-bottom {
        padding: 24px 20px;
      }
    }
    @media (max-width: 400px) {
      .search-form {
        max-width: 100%;
        flex-grow: 1;
      }
      nav {
        gap: 12px;
        font-size: 12px;
      }
      .btn-signin {
        padding: 6px 10px;
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo" aria-label="HBE Auctioneers logo">
      <span>HBE</span><span>Auctioneers</span>
    </div>
    <form class="search-form" role="search" aria-label="Search form">
      <input type="search" placeholder="mulailah mencari penawaran..." aria-label="Search input" />
      <button type="submit" aria-label="Search button"><i class="fas fa-search" aria-hidden="true">&#128269;</i></button>
    </form>
    <nav>
      <a href="login/login.php" aria-label="Log In">Log In</a>
      <a href="login/register.php" class="btn-signin" aria-label="Sign In">Sign in</a>
</nav>
  </header>
  <main>
    <section>
      <h1>Mari mulai sesi lelangmu disini</h1>
      <p class="lead">selamat datang di HBE Auctioneers, tempat lelang online terpercaya nomor 1 di Indonesia</p>
    </section>
    <section>
      <img
        src="https://storage.googleapis.com/a1aa/image/98db40bf-cc89-4371-8d32-470784e39dad.jpg"
        alt="Fantasy forest scene with waterfall, lush greenery, and sunlight streaming through trees"
        class="hero-image"
        width="900"
        height="300"
      />
    </section>
    <section>
      <h2 class="section-title">Lelang Saat ini</h2>
      <div class="current-auctions">
        <article class="auction-item">
          <img
            src="https://storage.googleapis.com/a1aa/image/38f85403-6e93-4ec1-5583-dea36b30a7c1.jpg"
            alt="Mainan Bemo Antik toy truck in orange and black colors with decorative patterns"
            width="300"
            height="200"
          />
          <h3>Mainan Bemo Antik</h3>
          <p>$250</p><span>(10 Bid)</span>
        </article>
        <article class="auction-item">
          <img
            src="https://storage.googleapis.com/a1aa/image/0b425bcd-42d4-47b1-0086-eac34ace9b7c.jpg"
            alt="Gramaphone antique with large horn speaker in front of white curtains"
            width="300"
            height="200"
          />
          <h3>Gramaphone</h3>
          <p>$500</p><span>(70 Bid)</span>
        </article>
        <article class="auction-item">
          <img
            src="https://storage.googleapis.com/a1aa/image/25f718bc-2b97-4afd-b7a5-fc96d22c7e1d.jpg"
            alt="Silver antique teapot from 1930 with intricate floral engravings"
            width="300"
            height="200"
          />
          <h3>Teko Antik (1930)</h3>
          <p>$1000</p><span>(230 Bid)</span>
        </article>
      </div>
    </section>
    <section class="top-trend">
      <div class="trend-text" aria-label="Top Trend Categories text">
        <h2 class="section-title">Top Trend Categories</h2>
        <p><strong>Art</strong>Kategori ini paling diminati karena disini menyediakan banyak sekali lukisan pelukis terkenal seperti Raden Saleh, Basuki Abdullah dan Hendra Gunawan</p>
        <p><strong>Old Toy</strong>Mainan lawas memang banyak diminati di kalangan para kolektor kaya</p>
        <p><strong>Antique Stuff</strong>Barang-barang antik tidak kalah menariknya dengan seni dan mainan lawas, kebanyakan yang mencari ini adalah biasanya kolektor sejati</p>
      </div>
      <img
        src="https://storage.googleapis.com/a1aa/image/889325a2-8626-482a-0645-700c1cc2f34e.jpg"
        alt="Colorful traditional art painting featuring a mask and vibrant colors"
        class="trend-image"
        width="600"
        height="400"
      />
    </section>
    <section class="others-art" aria-label="Others From Art">
      <h2 class="section-title">Others From Art</h2>
      <div class="others-art-list">
        <article class="others-art-item">
          <img
            src="https://storage.googleapis.com/a1aa/image/4d714e4f-89b8-4fd7-2088-4c047795fa84.jpg"
            alt="Diponegoro Door painting by Raden Saleh showing a historical scene with many people"
            width="600"
            height="300"
          />
          <h3>Diponegoro Door - Raden Saleh</h3>
          <p>$40000</p><span>(8000 Bid)</span>
        </article>
        <article class="others-art-item">
          <img
            src="https://storage.googleapis.com/a1aa/image/df247e64-da40-4376-c617-7aa7460153e3.jpg"
            alt="Cart at the Beach painting by Hendra Gunawan showing a colorful beach scene with people and animals"
            width="600"
            height="300"
          />
          <h3>Cart at the Beach - Hendra Gunawan</h3>
          <p>$80000</p><span>(20000 Bid)</span>
        </article>
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
        <a href="#"><button class="btn-black" type="button">Balik Ke Atas</button></a>
        <button class="btn-gray" type="button">Kasih Saran</button>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-bottom-top">
        <div class="footer-logo" aria-label="HBE Auctioneers logo">
          <span>HBE</span><span>Auctioneers</span>
        </div>
        <<div class="col-md-4 mb-4 mb-md-0 text-center text-md-end">
          <a href="#" style="margin-right: 15px; color:rgb(0, 0, 0); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="#" style="margin-right: 15px; color:rgb(10, 10, 10); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-twitter"></i>
          </a>
          <a href="#" style="margin-right: 15px; color:rgb(8, 8, 8); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-instagram"></i>
          </a>
          <a href="#" style="margin-right: 15px; color:rgb(10, 10, 10); font-size: 1.5rem; text-decoration: none;">
            <i class="bi bi-linkedin"></i>
          </a>
        </div>
      </div>
      </div>
      <div class="footer-links">
        <div>
          <p>Company</p>
          <ul>
            <li><a href="#">About</a></li>
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
        <div>
          <p>Selling</p>
          <ul>
            <li><a href="#">Auctioneer Sign In</a></li>
            <li><a href="#">Become a Seller</a></li>
            <li><a href="#">Consign an Item</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>