<?php
include('db.php');

$id = mysqli_real_escape_string($conn, $_POST['id']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$is_admin = isset($_POST['is_admin']) ? 1 : 0;

$sql = "UPDATE users SET username=?, email=?, is_admin=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssii', $username, $email, $is_admin, $id);

if ($stmt->execute()) {
    header("Location: users.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
