<?php
session_start();

// Koneksi ke database
include 'db_koneksi.php';

// Cek apakah user telah login
if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu");
}

$appointmentId = $_GET['id'];

// Query untuk menampilkan detail riwayat appointment
$sql = "SELECT appointments.*, doctors.name AS doctor_name, schedules.date, schedules.start_time, schedules.end_time 
        FROM appointments 
        LEFT JOIN schedules ON appointments.schedule_id = schedules.id 
        LEFT JOIN doctors ON appointments.doctor_id = doctors.id 
        WHERE appointments.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $appointmentId);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Details</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/appointments.css">
  <!-- Feather Icons -->
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body style="background-image: url('img/bg.svg')">
    <!-- Navbar Start -->
    <nav class="navbar">
      <a href="index.php" class="navbar-logo">Klinik<span>STIS</span></a>
      <div class="navbar-extra">
        <i href="index.php" data-feather="home"></i>
      </div>
    </nav>
    <!-- Navbar End -->
    <section class="section-view-appointment">
      <div class="container">
        <h1 class="judul">Detail Appointment</h1>
        <div class="appointment-details-container">
            <h1>Appointment</h1>
            <div class="details">
              <?php if ($appointment) { ?>
                  <p><pre><strong>Doctor              :</strong> <?= htmlspecialchars($appointment['doctor_name']) ?></pre></p>
                  <p><pre><strong>Date                  :</strong> <?= htmlspecialchars($appointment['date']) ?></pre></p>
                  <p><pre><strong>Time                  :</strong> <?= htmlspecialchars(substr($appointment['start_time'], 0, 5)) ?> - <?= htmlspecialchars(substr($appointment['end_time'], 0, 5)) ?></pre></p>
                  <p><pre><strong>Patient               :</strong> <?= htmlspecialchars($appointment['patient_name']) ?></pre></p>
                  <p><pre><strong>Complaint         :</strong> <?= htmlspecialchars($appointment['complaint']) ?></pre></p>
                  <p><pre><strong>Additional Info :</strong> <?= htmlspecialchars($appointment['additional_info']) ?></pre></p>
                  <form id="cancel-form" action="cancel_appointment.php" method="post">
                      <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointmentId) ?>">
                      <button type="button" id="cancel-appointment-btn"><i class="fa fa-trash"></i></button>
                  </form>
              <?php } else { ?>
                  <p style="color:red">Appointment Telah Dibatalkan</p>
              <?php } ?>
              <a href="jadwal_dokter.php">Lihat Jadwal</a>
            </div>
          </div>
      </div>
    </section>

    <div class="popup-container" id="confirm-popup" style="display: none;">
        <div class="popup">
            <p>Apakah Anda yakin ingin membatalkan appointment?</p>
            <button id="confirm-yes-btn">Ya</button>
            <button id="confirm-no-btn">Tidak</button>
        </div>
    </div>

    <script>
    // Function untuk menampilkan popup konfirmasi
    function showConfirmation() {
        document.getElementById("confirm-popup").style.display = "block";
    }

    // Function untuk menyembunyikan popup konfirmasi
    function hideConfirmation() {
        document.getElementById("confirm-popup").style.display = "none";
    }

    // Event listener untuk tombol cancel appointment
    document.getElementById("cancel-appointment-btn").addEventListener("click", function() {
        showConfirmation();
    });

    // Event listener jika tombol "Yes" ditekan
    document.getElementById("confirm-yes-btn").addEventListener("click", function() {
        document.getElementById("cancel-form").submit();
    });

    // Event listener jika tombol "No" ditekan
    document.getElementById("confirm-no-btn").addEventListener("click", function() {
        hideConfirmation();
    });
    </script>
</body>
</html>
