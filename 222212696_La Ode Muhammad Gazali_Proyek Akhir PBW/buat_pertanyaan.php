<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

include 'db_koneksi.php';

$question_added = false;

// Proses penambahan pertanyaan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form bertanya
    $user_id = $_SESSION['user_id'];
    $question = $_POST['question'];

    // Query untuk menambahkan pertanyaan ke basis data
    $stmt = $conn->prepare("INSERT INTO questions (user_id, question) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $question);

    if ($stmt->execute()) {
        $question_added = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pertanyaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tanya_jawab.css">
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
</head>
<body style="background-image: url('img/bg.svg')">
    <!-- Navbar Mulai -->
    <nav class="navbar">
        <a href="index.php" class="navbar-logo">Klinik<span>STIS</span></a>
        <div class="navbar-extra">
            <i href="index.php" data-feather="home"></i>
        </div>
    </nav>
    <!-- Navbar Selesai -->

    <!-- section question -->
    <section class="question-section">
        <div class="container">
            <h1 class="judul">Buat Pertanyaan</h1>
            <div class="question">
                <form action="buat_pertanyaan.php" method="POST">
                    <textarea name="question" placeholder="Tulis pertanyaan Anda di sini..." required></textarea>
                    <button type="submit">Kirim</button>
                </form>
            </div>    
        </div>
    </section>
    <!-- Question Selesai -->

    <!-- Modal Popup -->
    <div class="popup-container" id="question-success-popup">
        <div class="popup">
            <i class="fas fa-check-circle"></i>
            <p>Pertanyaan Anda berhasil dikirim!</p>
            <button onclick="closePopup()">Lihat Pertanyaan</button>
        </div>
    </div>

    <script>
        function showPopup() {
            document.getElementById('question-success-popup').style.display = 'flex';
        }
        function closePopup() {
            document.getElementById('question-success-popup').style.display = 'none';
            window.location.href = 'tanya_jawab.php';
        }
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($question_added): ?>
                showPopup();
            <?php endif; ?>
        });
    </script>
</body>
</html>
