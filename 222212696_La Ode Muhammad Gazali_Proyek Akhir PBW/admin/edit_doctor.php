<?php
include('db.php');

$id = $_POST['id'];
$name = $_POST['name'];
$specialization = $_POST['specialization'];

$sql = "UPDATE doctors SET name=?, specialization=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssi', $name, $specialization, $id);

if ($stmt->execute()) {
    header("Location: doctors.php");
    exit();
} else {
    echo "Error updating Doctor: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
