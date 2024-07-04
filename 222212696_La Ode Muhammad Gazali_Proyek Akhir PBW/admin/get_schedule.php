<?php
include('db.php');

$schedule_id = filter_input(INPUT_GET, 'schedule_id', FILTER_SANITIZE_NUMBER_INT);

if (!$schedule_id) {
    echo json_encode(['error' => 'Invalid schedule ID']);
    exit();
}

$sql = "SELECT * FROM schedules WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['error' => htmlspecialchars($conn->error)]);
    exit();
}

$stmt->bind_param("i", $schedule_id);
$stmt->execute();
$result = $stmt->get_result();
$schedule = $result->fetch_assoc();

if ($schedule) {
    echo json_encode($schedule);
} else {
    echo json_encode(['error' => 'Jadwal tidak ditemukan']);
}

$stmt->close();
$conn->close();
?>