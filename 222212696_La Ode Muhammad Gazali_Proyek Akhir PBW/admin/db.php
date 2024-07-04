<?php
$servername = "localhost";
$username = "dscfexio_klinikstis";
$password = "VYxQrDZBuZnrJc9vCgKm";
$dbname = "dscfexio_klinikstis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
