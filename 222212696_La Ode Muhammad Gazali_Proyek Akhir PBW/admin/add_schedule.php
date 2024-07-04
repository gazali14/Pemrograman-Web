<?php
include('db.php');

$doctor_id = $_POST['doctor_id'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$status = $_POST['status'];

$sql = "INSERT INTO schedules (doctor_id, date, start_time, end_time, status) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $doctor_id, $date, $start_time, $end_time, $status);

if ($stmt->execute()) {
    echo "Jadwal berhasil ditambahkan";
    header("Location: schedules.php");
} else {
    echo "Error dalam menambahkan jadwal: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
