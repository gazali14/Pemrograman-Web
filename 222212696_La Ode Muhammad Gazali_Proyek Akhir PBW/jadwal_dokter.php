<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jadwal Praktek Dokter</title>
  <link rel="stylesheet" href="css/style.css">
  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body style="background-image: url('img/bg.svg')">
  <!-- Navbar Start -->
  <nav class="navbar">
    <a href="mainpage.php" class="navbar-logo">Klinik<span>STIS</span></a>
    <div class="navbar-extra">
        <i href="index.php" data-feather="home"></i>
    </div>
  </nav>
  <!-- Navbar End -->

  <!-- Calendar Start -->
  <section class="calendar-section">
    <div class="container">
      <h1 class="judul">Cek Jadwal Dokter</h1>
    </div>
    <div class="calendar-text">
        <p>Untuk membuat appointment, silahkan pilih tanggal yang tersedia</p>
        <hr class="separator" />
    </div>
    <div class="calendar-riwayat">
      <a href="riwayat_appointment.php" class="btn-riwayat">Riwayat Appointment</a>
    </div>
    <div class="calendar">
      <div class="calendar-header">
        <button onclick="prevMonth()">Prev Month</button>
        <h2 id="calendar-title">Jadwal Praktek Dokter</h2>
        <button onclick="nextMonth()">Next Month</button>
      </div>
      <div class="calendar-grid" id="calendar">
        <!-- Days will be dynamically inserted here -->
      </div>
    </div>
    <script src="js/jadwal_dokter.js"></script>
  </section>
  <!-- Calendar end -->

  <!-- footer start -->
  <footer>
    <div class="row">
      <div class="col">
        <img src="img/Logo_STIS.png" class="logo" alt="logo" />
      </div>
      <div class="col">
        <h3>Office</h3>
        <p>Jl. Otto Iskandardinata</p>
        <p>Jatinegara, Jakarta Timur</p>
        <p>Indonesia</p>
        <p class="email-id">upk@stis.ac.id</p>
        <h4>082193671786</h4>
      </div>
      <div class="col">
        <h3>links</h3>
        <ul>
          <li><a href="https://bps.go.id">Badan Pusat Statistik</a></li>
          <li><a href="https://stis.ac.id">Politeknik Statistika STIS</a></li>
          <li><a href="https://spmb.stis.ac.id">SPMB STIS</a></li>
          <li><a href="https://perkuliahan.sipadu.stis.ac.id">Sipadu STIS</a></li>
        </ul>
      </div>

      <div class="col">
        <h3>Newsletter</h3>
        <form>
          <i class="fa-regular fa-envelope"></i>
          <input type="email" placeholder="Enter your email id" required />
          <button type="submit">
            <i class="fa-solid fa-arrow-right"></i>
          </button>
        </form>
        <div class="social-icons">
          <a href="https://www.facebook.com"
            ><i class="fa-brands fa-facebook"></i
          ></a>
          <a href="https://twitter.com"
            ><i class="fa-brands fa-twitter"></i
          ></a>
          <a href="https://api.whatsapp.com"
            ><i class="fa-brands fa-whatsapp"></i
          ></a>
          <a href="https://www.instagram.com"
            ><i class="fa-brands fa-instagram"></i
          ></a>
        </div>
      </div>
    </div>
    <hr />
    <p class="copyrigth">POLITEKNIK STATISTIKA STIS - All rigth reserved</p>
  </footer>
  <!-- footer end  -->
</body>
</html>
