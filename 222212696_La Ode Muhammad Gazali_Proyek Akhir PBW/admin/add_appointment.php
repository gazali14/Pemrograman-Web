<?php
include('db.php');

$doctor_id = $_POST['doctor_id'];
$schedule_id = $_POST['schedule_id'];
$patient_name = $_POST['patient_name'];
$complaint = $_POST['complaint'];
$additional_info = $_POST['additional_info'];

$sql = "INSERT INTO appointments (doctor_id, schedule_id, patient_name, complaint, additional_info) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisss", $doctor_id, $schedule_id, $patient_name, $complaint, $additional_info);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header('Location: appointments.php');
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$stmt->close();
$conn->close();
?>
