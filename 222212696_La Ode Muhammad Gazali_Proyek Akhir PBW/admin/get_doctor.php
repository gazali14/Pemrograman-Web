<?php
include('db.php');

$doctor_id = $_GET['id']; 

$sql = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $doctor = $result->fetch_assoc();
    echo json_encode($doctor);
} else {
    echo json_encode(['error' => 'Doctor not found']);
}

$stmt->close();
$conn->close();
?>
