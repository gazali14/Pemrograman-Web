<?php
session_start();

// Koneksi database
include 'db_koneksi.php';

if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu");
}

// Cek apakah appointment id ditemukan
if (!isset($_POST['appointment_id'])) {
    $_SESSION['message'] = "ID appointment tidak ditemukan";
    header("Location: view_appointment.php");
    exit();
}

$appointmentId = $_POST['appointment_id'];

if (empty($appointmentId)) {
    $_SESSION['message'] = "ID appointment kosong atau tidak valid";
    header("Location: view_appointment.php");
    exit();
}

// Delete appointment
$sql = "DELETE FROM appointments WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    $_SESSION['message'] = "Prepare failed: (" . $conn->errno . ") " . $conn->error;
    header("Location: view_appointment.php");
    exit();
}

$stmt->bind_param("i", $appointmentId);

if (!$stmt->execute()) {
    $_SESSION['message'] = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} else {
    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Appointment berhasil dibatalkan!";
    } else {
        $_SESSION['message'] = "ID appointment tidak ditemukan atau sudah dihapus.";
    }
}

$stmt->close();
$conn->close();

header("Location: view_appointment.php");
exit();
?>
