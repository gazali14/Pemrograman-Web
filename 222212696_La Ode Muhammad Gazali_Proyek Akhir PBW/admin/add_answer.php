<?php
session_start(); 

include('db.php');

if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu");
}

$admin_id = $_SESSION['user_id'];
$question_id = $_POST['question_id'];
$answer = $_POST['answer'];

$stmt = $conn->prepare("INSERT INTO answers (question_id, admin_id, answer) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $question_id, $admin_id, $answer);

if ($stmt->execute()) {
    $stmt->close();
    
    $updateStatusSql = "UPDATE questions SET status = 'Sudah Dijawab' WHERE id = ?";
    $stmtUpdate = $conn->prepare($updateStatusSql);
    $stmtUpdate->bind_param("i", $question_id);
    
    if ($stmtUpdate->execute()) {
        $stmtUpdate->close();
        $conn->close();
        echo "<script>window.location.href = 'questions.php';</script>";
        exit();
    } else {
        echo "Error updating status: " . $stmtUpdate->error;
    }
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
