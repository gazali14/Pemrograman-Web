<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

include('db.php');

// Mengambil data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];

    $stmt = $conn->prepare("INSERT INTO doctors (name, specialization) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $specialization);

    if ($stmt->execute()) {
        header("Location: doctors.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
