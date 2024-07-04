<?php
include('db.php');

$id = $_GET['id'];
$sql = "SELECT * FROM questions WHERE id=$id";
$result = $conn->query($sql);
$question = $result->fetch_assoc();

echo json_encode($question);

$conn->close();
?>
