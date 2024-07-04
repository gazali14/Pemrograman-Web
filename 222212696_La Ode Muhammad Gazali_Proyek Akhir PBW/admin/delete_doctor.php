<?php
include('db.php');

$id = $_POST['id'];

$sql = "DELETE FROM doctors WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Data Dokter berhasil dihapus";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
