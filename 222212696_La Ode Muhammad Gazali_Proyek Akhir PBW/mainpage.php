<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
include 'db_koneksi.php';

$namaUser = $_SESSION['username']; // Ambil nama pengguna dari sesi

// Query untuk mengambil informasi pengguna dari database berdasarkan username
$sql = "SELECT profile_image, email FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $namaUser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  if ($row['profile_image'] !== null) {
      $profileImage = './' . $row['profile_image']; // Path relatif ke gambar profil jika tidak NULL
  } else {
      $profileImage = './img/default-profile.png'; // Default jika gambar profil NULL
  }
} else {
  $profileImage = './default-profile.png'; // Default jika data pengguna tidak ditemukan
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <s>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KlinikSTIS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
      rel="stylesheet"
    />
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My style -->
    <link rel="stylesheet" href="css/style.css" />
    <style>
      .sub-menu-wrap{
        position: absolute;
        top:100%;
        right: 10%;
        width:320px;
        max-height: 0px;
        overflow: hidden;
        transition: max-height 0.5s;
      }
      .sub-menu-wrap.open-menu{
        max-height: 400px;
      }
      .sub-menu{
        background: #fff;
        border-radius: 5px;
        box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
        padding: 20px;
        margin: 1px;
      }
      .user-info {
          display: flex;
          align-items: center;
      }

      .user-info img {
          width: 60px;
          border-radius: 50%;
          margin-right: 15px;
      }

      .user-details {
          display: flex;
          flex-direction: column; /* Mengatur tata letak elemen user-details menjadi vertikal */
      }

      .user-details h3 {
          font-weight: 500;
          margin-bottom: 5px;
      }

      .user-details p {
          margin-top: 0;
          color: #666;
      }

      .sub-menu hr{
        border:0;
        height: 1px;
        width: 100%;
        background: #ccc;
        margin:15px 10px;
      }
      .sub-menu-link{
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #525252;
        margin: 12px 0;
      }

      .sub-menu-link p{
        width: 100%;
        margin-left: 5px;
      }
      .sub-menu-link span{
        font-size: 21px;
      }

      .sub-menu-link:hover span{
        transform: translateX(5ox);
      }

      .user-info {
          position: relative;
      }

      .edit-icon {
          cursor: pointer;
          position: absolute;
          top: 95%;
          left:20%;
          transform: translate(-50%, -50%);
          border-radius: 50%;
          padding: 5px;
      }

      #upload-form {
        margin-top: 10px;
      }

      #upload-form input[type="file"] {
        display: block;
      }

      #upload-form button {
        margin-top: 10px;
      }
    </style>
  </head>
  <body style="  background-image: url('img/bg.svg')">
    <!-- Navbar Start -->
    <nav class="navbar">
      <a href="#" class="navbar-logo">Klinik<span>STIS</span></a>

      <div class="navbar-nav">
        <a href="#home">Home</a>
        <a href="#about-us">Tentang kami</a>
        <a href="#fitur">Fitur</a>
        <a href="#berita">Artikel</a>
      </div>
      <div class="navbar-extra" style="color: blue">
          <i style="cursor:pointer" data-feather="user" onclick="toggleMenu()"></i>
          <div class="sub-menu-wrap" id="subMenu">
              <div class="sub-menu">
                  <div class="user-info">
                      <i id="edit-icon" data-feather="edit-2" class="edit-icon"></i>
                      <img id="profileImage" src="<?php echo $profileImage; ?>" alt="User Avatar">
                      <div class="user-details">
                          <h3><?php echo htmlspecialchars($namaUser); ?></h3>
                          <p><?php echo $row['email']; ?></p>
                      </div>
                      <input type="file" id="fileInput" style="display: none;" accept="image/*">
                  </div>
                  <hr>
                  <a href="logout.php" class="sub-menu-link">
                      <img src="./img/logout.svg" alt="logout">
                      <p>Logout</p>
                      <span>></span>
                  </a>
              </div>
          </div>
          <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>



    </nav>
    <!-- Navbar End -->

    <!-- Hero section start -->
    <section class="hero" id="home">
      <img src="img/pict1.png" class="hero-image" alt="Deskripsi Gambar" />
      <main class="content">
        <h1>Statistisi Sehat <br /><span>Statistisi Berkualitas</span></h1>
        <p>
          Tingkatkan kualitas data dengan hidup sehat dan berkualitas.
        </p>
        <a href="#about-us" class="cta">Selengkapnya</a>
      </main>
    </section>

    <!-- About us Section-->
    <section id="about-us" class="about-us">
      <div class="container">
        <h1 class="judul">Tentang Kami</h1>
        <div class="row">
          <div class="col-md-6">
            <div class="about-info">
              <div class="col-md-6">
                <img
                  src="img/dokter.png"
                  class="aboutus-image"
                  alt="Tentang Kami"
                />
              </div>
              <p>
                Klinik Politeknik Statistika STIS hadir sebagai wujud kepedulian
                kami terhadap kesejahteraan mahasiswa dan seluruh pegawai
                Politeknik Statistika STIS. Kami berkomitmen untuk menyediakan
                pelayanan kesehatan yang berkualitas dan mendukung perkembangan
                akademik serta sosial-emotional setiap mahasiswa. Dengan tim
                medis yang berpengalaman dan fasilitas yang memadai, kami
                berupaya menjadi mitra terpercaya dalam menjaga kesehatan dan
                keseimbangan hidup mahasiswa di lingkungan kampus <br /><br />
                Dengan demikian, kami memastikan bahwa setiap mahasiswa
                mendapatkan pelayanan yang optimal dan komprehensif. Kami
                percaya bahwa kesehatan yang baik adalah kunci keberhasilan
                akademik dan kehidupan yang seimbang, dan kami berkomitmen untuk
                mendukung mahasiswa dalam mencapai kedua tujuan tersebut.
              </p>
              <br />
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="fitur-section" id="fitur">
      <div class="container">
        <h1 class="judul">Fitur Website</h1>
        <div class="fitur-container">
          <div class="fitur">
            <a href="jadwal_dokter.php">
              <img src="img/fitur3.png" alt="Fitur 3" />
            </a>
            <h3>
              <a href="jadwal_dokter.php">Cek Jadwal Dokter</a>
            </h3>
          </div>
          <div class="fitur">
            <a href="tanya_jawab.php">
              <img src="img/fitur1.png" alt="Fitur 1" />
            </a>
            <h3>
              <a href="tanya_jawab.php">Tanya Dokter</a>
            </h3>
          </div>
          <div class="fitur">
            <a href="cek_obat.php">
              <img src="img/fitur2.png" alt="Fitur 2" />
            </a>
            <h3>
              <a href="cek_obat.php">Cek Ketersediaan Obat</a>
            </h3>
          </div>
          <!-- tambahkan lebih banyak div .fitur sesuai dengan jumlah fitur -->
        </div>
      </div>
    </section>

    <section class="berita-section" id="berita">
      <div class="berita">
        <h1 class="judul">Artikel Kesehatan</h1>
        <div class="box-berita">
          <?php
            include 'db_koneksi.php';

            // Function to fetch an article by its ID
            function getArticleById($id, $connection) {
                $query = "SELECT judul, konten, gambar FROM artikel WHERE id = $id";
                $result = $connection->query($query);

                if ($result && $result->num_rows > 0) {
                    return $result->fetch_assoc();
                } else {
                    return null;
                }
            }

            // IDs of the articles to be displayed
            $articleIds = [1, 2, 3, 4]; // Or you can fetch these IDs dynamically from the database

            foreach ($articleIds as $articleId) {
                $article = getArticleById($articleId, $conn);
            
                if ($article) {
                    echo '<div class="b' . $articleId . '">';
                    echo '<img src="img/' . $article['gambar'] . '" alt="gambar' . $articleId . '" />';
                    echo '<p><b>' . $article['judul'] . '</b></p>';
                    // Display a portion of the article content
                    echo '<p class="p-konten">' . substr($article['konten'], 0, 50) . '...</p>';
                    echo '<a href="page_berita.php?id=' . $articleId . '">...Selengkapnya</a>';
                    echo '</div>';
                }
            }
          

            // Menutup koneksi database
            $conn->close();
          ?>
        </div>
      </div>
    </section>


    <!-- footer start -->
    <footer>
      <div class="row">
        <div class="col">
          <img src="./img/Logo_STIS.png" class="logo" alt="logo" />
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
    <!-- footer end -->

    <!-- Feather icons -->
    <script>
      feather.replace();
    </script>

    <!-- Font Awesome -->
    <script
      src="https://kit.fontawesome.com/2ee5469def.js"
      crossorigin="anonymous"
    ></script>

    <!-- My javascript -->
    <script src="js/script.js"></script>
    <script src="js/fitur.js"></script>
    <script>
      let subMenu = document.getElementById("subMenu");

      function toggleMenu(){
        subMenu.classList.toggle("open-menu");
      }

      document.addEventListener('DOMContentLoaded', function () {
          const editIcon = document.getElementById('edit-icon');
          const fileInput = document.getElementById('fileInput');
          const profileImage = document.getElementById('profileImage');

          editIcon.addEventListener('click', () => {
              fileInput.click();
          });

          fileInput.addEventListener('change', async () => {
              const formData = new FormData();
              formData.append('file', fileInput.files[0]);

              try {
                  const response = await fetch('upload_image.php', {
                      method: 'POST',
                      body: formData
                  });
                  const data = await response.json();
                  if (data.success) {
                      profileImage.src = 'img/' + data.filename;
                  } else {
                      console.error(data.error);
                  }
              } catch (error) {
                  console.error('Error uploading image:', error);
              }
          });
      });

    </script>
  </body>
</html>
