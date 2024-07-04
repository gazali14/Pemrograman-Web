<?php
include('db.php');

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id=$id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

echo json_encode($user);

$conn->close();
?>
