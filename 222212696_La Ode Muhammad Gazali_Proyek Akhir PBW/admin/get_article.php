<?php
include('db.php');

$id = $_GET['id'];
$sql = "SELECT * FROM artikel WHERE id=$id";
$result = $conn->query($sql);
$article = $result->fetch_assoc();

echo json_encode($article);

$conn->close();
?>
