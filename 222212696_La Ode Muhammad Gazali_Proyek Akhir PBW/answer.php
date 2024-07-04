<?php
session_start();

include 'db_koneksi.php';

// Proses penambahan jawaban
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answer_submit'])) {
    // Ambil data dari form menjawab
    $admin_id = $_SESSION['user_id'];
    $question_id = $_POST['question_id'];
    $answer = $_POST['answer'];

    // Query untuk menambahkan jawaban ke basis data
    $sql = "INSERT INTO answers (question_id, admin_id, answer) VALUES ('$question_id', '$admin_id', '$answer')";

    if ($conn->query($sql) === TRUE) {
        echo "Jawaban berhasil dikirim!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

header("Location: ask.php");
exit();
?>
