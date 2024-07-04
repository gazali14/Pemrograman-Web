<?php
include('db.php');

$id = $_POST['id'];

$sql = "DELETE FROM artikel WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Artikel berhasil dihapus";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
