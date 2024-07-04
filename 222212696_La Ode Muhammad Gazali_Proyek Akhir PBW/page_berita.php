<?php 
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>
<?php
include 'db_koneksi.php';

// Mendapatkan ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Mengambil data artikel berdasarkan ID
$sql = "SELECT * FROM artikel WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $judul = $row["judul"];
    $tanggal = date("d M Y", strtotime($row["tanggal"]));
    $konten = nl2br($row["konten"]);
    $gambar = $row["gambar"];
} else {
    echo "Artikel tidak ditemukan.";
    exit;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $judul; ?></title>
    <link rel="stylesheet" href="css/style.css" />
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body style="  background-image: url('img/bg.svg')">
    <!-- Navbar Start -->
    <nav class="navbar">
      <a href="mainpage.php" class="navbar-logo">Klinik<span>STIS</span></a>
      <div class="navbar-extra">
        <i href="index.php" data-feather="home"></i>
      </div>
    </nav>
    <!-- Navbar End -->

    <!-- Artikel Detail start -->
    <section class="berita-section" style="margin-top: 5rem">
        <div class="berita">
            <h1 class="judul"><?php echo $judul; ?></h1>
            <h6 class="tanggal"><?php echo $tanggal; ?></h6>
            <hr class="separator" />
            <img src="img/<?php echo $gambar; ?>" alt="Gambar Artikel" class="gambar-artikel" />
            <p class="paragraf-berita"><?php echo $konten; ?></p>
        </div>
    </section>

    <!-- Artikel Detail end -->

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
            <li>
              <a href="https://perkuliahan.sipadu.stis.ac.id">Sipadu STIS</a>
            </li>
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
  </body>
</html>
