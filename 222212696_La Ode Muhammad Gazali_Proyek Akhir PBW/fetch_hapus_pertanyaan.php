<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        die("Anda harus login terlebih dahulu");
    }

    $question_id = $_POST['question_id'];
    $user_id = $_SESSION['user_id'];

    include 'db_koneksi.php';

    // Hapus jawaban terkait terlebih dahulu
    $sql_delete_answers = "DELETE FROM answers WHERE question_id = ?";
    $stmt_delete_answers = $conn->prepare($sql_delete_answers);
    $stmt_delete_answers->bind_param("i", $question_id);
    $stmt_delete_answers->execute();
    $stmt_delete_answers->close();

    // Hapus pertanyaan
    $sql_delete_question = "DELETE FROM questions WHERE id = ? AND user_id = ?";
    $stmt_delete_question = $conn->prepare($sql_delete_question);
    $stmt_delete_question->bind_param("ii", $question_id, $user_id);
    $stmt_delete_question->execute();
    $stmt_delete_question->close();

    $conn->close();
    header("Location: tanya_jawab.php");
    exit();
} else {
    header("Location: tanya_jawab.php");
    exit();
}
?>
