<?php
// Memulai session
session_start();

// Cek apakah pengguna belum login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
include 'db_koneksi.php';

// Ambil username pengguna yang sedang login
$username = $_SESSION['username'];

// Query untuk mengambil data riwayat appointment berdasarkan username
$sql = "SELECT appointments.id, doctors.name as doctor_name, schedules.date, schedules.start_time, schedules.end_time, appointments.patient_name, appointments.complaint, appointments.additional_info, appointments.status
              FROM appointments
              LEFT JOIN doctors ON appointments.doctor_id = doctors.id
              LEFT JOIN schedules ON appointments.schedule_id = schedules.id
              WHERE appointments.patient_name = '$username'
              ORDER BY schedules.date DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Appointments</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/appointments.css">
  <style>
    .details {
        padding: 20px;
        box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
        border-radius: 20px;
        background: var(--white);
        margin-top: 5rem;
        margin-bottom: 5rem;
        color: black;
    }
    
    .details table {
        width: 90%;
        border-collapse: collapse;
        margin-top: auto;
        background: var(--white);
        box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
        margin:0 auto;
        text-align: left;
    }

    .details h2 {
        font-weight: 600;
        color: var(--blue);
        margin-bottom: 20px;
    }

    .details table tr th{
        text-align: left;
        font-size: 16px;
        padding: 10px;
        background-color: #3463a7;
        color: #fff;
    }

    .details table tbody td {
        padding: 10px;
        font-size: 14px;
        border-bottom: 2px solid rgba(0, 0, 0, 0.1);
    }

    .details table thead{
        font-weight: 600;
        background: var(--blue);
        color: var(--white);
        padding: 12px;
        padding-top: 20px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .details table tbody tr {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        transition: background 0.3s ease;
    }

    .details table tbody tr:last-child {
        border-bottom: none;
    }

    .details table tbody tr td {
        padding: 10px;
    }

  </style>
</head>
<body>
  <!-- Navbar Start -->
  <nav class="navbar">
    <a href="mainpage.php" class="navbar-logo">Klinik<span>STIS</span></a>
    <div class="navbar-extra">
        <a href="jadwal_dokter.php" class="btn">Kembali ke Jadwal Dokter</a>
    </div>
  </nav>
  <!-- Navbar End -->

  <section class="ask-section">
        <div class="container">
            <h1 class="judul">Riwayat Appoointment</h1>  
            <div class="details">
              <table>
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Dokter</th>
                          <th>Jadwal</th>
                          <th>Nama Pasien</th>
                          <th>Keluhan</th>
                          <th>Keterangan Tambahan</th>
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php
                      $counter=1;
                      while ($row = $result->fetch_assoc()) {
                          // Define status color based on status value
                          $status_color = '';
                          switch ($row['status']) {
                              case 'Disetujui':
                                  $status_color = 'blue';
                                  break;
                              case 'Pending':
                                  $status_color = 'yellow';
                                  break;
                              case 'Ditolak':
                                  $status_color = 'red';
                                  break;
                              default:
                                  $status_color = 'yellow';
                                  break;
                          }
                          echo "<tr>
                                  <td>{$counter}</td>
                                  <td>{$row['doctor_name']}</td>
                                  <td>{$row['date']} {$row['start_time']} - {$row['end_time']}</td>
                                  <td>{$row['patient_name']}</td>
                                  <td>{$row['complaint']}</td>
                                  <td>{$row['additional_info']}</td>
                                  <td class='status' data-status='{$row['status']}' style='background-color: {$status_color};'>{$row['status']}</td>
                              </tr>";
                          
                          $counter++;
                      }
                      ?>
                  </tbody>
              </table>
          </div>
        </div>
    </section>

  <!-- Display Appointments -->
  

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
