<?php
include('db.php');

$id = $_POST['id'];
$doctor_id = $_POST['doctor_id'];
$schedule_id = $_POST['schedule_id'];
$patient_name = $_POST['patient_name'];
$complaint = $_POST['complaint'];
$additional_info = $_POST['additional_info'];
$status = $_POST['status'];

$stmt = $conn->prepare("UPDATE appointments SET doctor_id=?, schedule_id=?, patient_name=?, complaint=?, additional_info=?, status=? WHERE id=?");
$stmt->bind_param("iissssi", $doctor_id, $schedule_id, $patient_name, $complaint, $additional_info, $status, $id);

if ($stmt->execute()) {
    header("Location: appointmentss.php");
    exit();
} else {
    echo "Error updating appointment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>