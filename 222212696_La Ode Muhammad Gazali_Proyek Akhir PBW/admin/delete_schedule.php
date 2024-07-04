<?php
include('db.php');

$id = $_POST['id'];

$sql = "DELETE FROM schedules WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Jadwal Dokter berhasil dihapus";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
