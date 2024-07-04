<?php
include('db.php'); 

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM appointments WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Appointment berhasil dihapus";
} else {
    echo "Error deleting appointment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
