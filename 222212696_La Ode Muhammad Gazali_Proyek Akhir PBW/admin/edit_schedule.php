<?php
include('db.php');

// Validasi inputan
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
$doctor_id = filter_input(INPUT_POST, 'doctor_id', FILTER_SANITIZE_NUMBER_INT);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$start_time = filter_input(INPUT_POST, 'start_time', FILTER_SANITIZE_STRING);
$end_time = filter_input(INPUT_POST, 'end_time', FILTER_SANITIZE_STRING);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

$sql = "UPDATE schedules SET doctor_id = ?, date = ?, start_time = ?, end_time = ?, status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("issssi", $doctor_id, $date, $start_time, $end_time, $status, $id);
if ($stmt->execute()) {
    header("Location: schedules.php");
    exit();
} else {
    echo "Error updating schedule: " . htmlspecialchars($stmt->error);
}

$stmt->close();
$conn->close();
?>