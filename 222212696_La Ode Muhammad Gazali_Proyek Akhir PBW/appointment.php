<?php
session_start();

// Koneksi ke database
include 'db_koneksi.php';

// cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu");
}

$userId = $_SESSION['user_id'];

// Get user details
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $doctorId = $_POST['doctor_id'];
    $scheduleId = $_POST['schedule_id'];
    $patientName = $user['username'];
    $complaint = $_POST['complaint'];
    $additionalInfo = $_POST['additional_info'];

    // Insert appointment
    $sql = "INSERT INTO appointments (doctor_id, schedule_id, patient_name, complaint, additional_info) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $doctorId, $scheduleId, $patientName, $complaint, $additionalInfo);

    if ($stmt->execute()) {
      $appointmentId = $stmt->insert_id; 
      $_SESSION['appointment_success'] = true; 
      $_SESSION['appointment_id'] = $appointmentId;
      header("Location: appointment.php?id=$appointmentId&doctor_id=$doctorId&schedule_id=$scheduleId"); // Redirect to the same page to show popup
      exit();
  } else {
      $message = "Error: " . $stmt->error;
  }

    $conn->close();
} else {
    $doctorId = $_GET['doctor_id'];
    $scheduleId = $_GET['schedule_id'];

    // Query untuk mengambil data dokter dan schedules
    $sql = "SELECT doctors.name AS doctor_name, schedules.date, schedules.start_time, schedules.end_time 
            FROM schedules 
            LEFT JOIN doctors ON schedules.doctor_id = doctors.id 
            WHERE schedules.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $scheduleId);
    $stmt->execute();
    $result = $stmt->get_result();
    $schedule = $result->fetch_assoc();

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/appointments.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>
<body style="background-image: url('img/bg.svg')">
  <!-- Navbar Mulai -->
  <nav class="navbar">
    <a href="mainpage.php" class="navbar-logo">Klinik<span>STIS</span></a>
    <div class="navbar-extra">
        <i href="index.php" data-feather="home"></i>
    </div>
  </nav>

  <section class="appointment-section">
    <div class="container">
      <h1 class="judul">Appointment</h1>
      <div class="appointment-form">
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
          <h1><?= htmlspecialchars($message) ?></h1>
          <a href="index.php">Back to Calendar</a>
        <?php else: ?>
          <div class="appointment-info">
            <h1>Appointment dengan  <?= htmlspecialchars($schedule['doctor_name']) ?></h1>
            <p>Tanngal: <?= htmlspecialchars($schedule['date']) ?></p>
            <p>Waktu: <?= htmlspecialchars(substr($schedule['start_time'], 0, 5)) ?> - <?= htmlspecialchars(substr($schedule['end_time'], 0, 5)) ?></p>
            <form action="appointment.php" method="post" >
              <input type="hidden" name="doctor_id" value="<?= htmlspecialchars($doctorId) ?>">
              <input type="hidden" name="schedule_id" value="<?= htmlspecialchars($scheduleId) ?>">
              <label for="patient_name">Nama:</label>
              <input type="text" id="patient_name" name="patient_name" value="<?= htmlspecialchars($user['username']) ?>" disabled>
              <label for="complaint">Keluhan:</label>
              <textarea id="complaint" name="complaint" required></textarea>
              <label for="additional_info">Keterangan Tambahan:</label>
              <textarea id="additional_info" name="additional_info"></textarea>
              <button type="submit">Book Appointment</button>
            </form>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <!-- popup -->
  <div class="popup-container" id="appointment-success-popup">
    <div class="popup">
      <i class="fas fa-check-circle"></i>
      <p>Appointment berhasil dibuat! <br>Klik untuk melihat appointment anda</p>
      <button id="popup-okay-btn">Oke</button>
    </div>
  </div>
  <!--  -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var appointmentSuccessPopup = document.getElementById('appointment-success-popup');
            var popupOkayBtn = document.getElementById('popup-okay-btn');

            <?php if (isset($_SESSION['appointment_success']) && $_SESSION['appointment_success'] == true): ?>
                appointmentSuccessPopup.style.display = 'block';
                <?php unset($_SESSION['appointment_success']); // Unset the session variable ?>
            <?php endif; ?>

            popupOkayBtn.addEventListener('click', function() {
                appointmentSuccessPopup.style.display = 'none';
                window.location.href = "view_appointment.php?id=<?= $_SESSION['appointment_id'] ?>"; // Redirect to view appointment
            });
        });
    </script>

</body>
</html>

