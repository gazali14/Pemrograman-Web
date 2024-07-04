<?php
include('db.php');

$username = $_POST['username'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$is_admin = isset($_POST['is_admin']) ? 1 : 0;

$stmt = $conn->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssi", $username, $email, $password, $is_admin);

if ($stmt->execute()) {
    echo "User berhasil ditambahkan";
    header("Location: users.php");
    exit();
} else {
    echo "Error dalam menambahkan user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
