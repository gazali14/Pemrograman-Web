<?php
$db_hostname = "localhost"; // Ganti dengan server database Anda
$db_database = "praktikum9"; // Ganti dengan nama database Anda
$db_username = "root"; // Ganti dengan username database Anda
$db_password = ""; // Ganti dengan password database Anda
// Untuk praktikum, lebih baik jangan gunakan password asli Anda

$db_charset = "utf8mb4"; // Opsional
$dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
$opt = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
);

try {
    // Membuat koneksi ke database
    $pdo = new PDO($dsn, $db_username, $db_password, $opt);

    // Mengambil nilai dari formulir
    $slot = $_POST["slot"];
    $name = $_POST["name"];
    $email = $_POST["email"];

    // Menyiapkan pernyataan SQL untuk menyisipkan data
    $stmt = $pdo->prepare("INSERT INTO meetings (slot, name, email) VALUES (:slot, :name, :email)");

    // Mengeksekusi pernyataan SQL dengan mengikat parameter
    $stmt->execute(array(':slot' => $slot, ':name' => $name, ':email' => $email));

    // Menutup koneksi database
    $pdo = NULL;

    // Redirect ke halaman php11F.php setelah penyisipan berhasil
    header("Location: php11F.php");
    exit();
} catch (PDOException $e) {
    // Menampilkan pesan error jika terjadi kesalahan
    echo "Error: " . $e->getMessage();
    die();
}
?>
