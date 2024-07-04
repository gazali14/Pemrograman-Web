<?php
// db_connection.php
$servername = "localhost";
$username = "dscfexio_klinikstis";
$password = "VYxQrDZBuZnrJc9vCgKm";
$dbname = "dscfexio_klinikstis";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
