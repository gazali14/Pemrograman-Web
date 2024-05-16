<?php 
    session_start(); // Memulai session

    if (!isset($_SESSION['username'])){
        header("Location: php10D.php");
    }
?>
<?php
// Menyertakan atau menetapkan nilai koneksi database
$db_hostname = "localhost";
$db_database = "praktikum9";
$db_username = "root";
$db_password = "";

// Koneksi ke database
$pdo = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_username, $db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Memeriksa apakah metode permintaan adalah GET dan apakah parameter slot diberikan
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["slot"])) {
    // Mengambil slot dari parameter GET
    $slotToDelete = $_GET["slot"];

    // Menyiapkan dan mengeksekusi pernyataan SQL untuk menghapus data pertemuan
    $stmt = $pdo->prepare("DELETE FROM meetings WHERE slot = :slot");
    $stmt->execute(array(':slot' => $slotToDelete));

    // Redirect kembali ke halaman php10F.php setelah berhasil menghapus data
    header("Location: phpq10F.php?success=1");
    exit();
}
?>
