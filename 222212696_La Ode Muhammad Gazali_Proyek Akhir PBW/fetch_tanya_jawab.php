<?php
include 'db_koneksi.php';

// Query untuk mendapatkan semua pertanyaan
$sql = "SELECT questions.id, questions.question, questions.user_id, users.username, questions.created_at 
        FROM questions 
        JOIN users ON questions.user_id = users.id 
        ORDER BY questions.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="ask-card" style="position: relative; margin-bottom: 20px;">';
        echo '<div class="ask-info">';
        echo '<h2 class="ask-name">' . htmlspecialchars($row['username']) . '</h2>';
        echo '<p class="ask-description">' . htmlspecialchars($row['question']) . '</p>';
        echo '<p class="ask-usage">Diajukan pada ' . $row['created_at'] . '</p>';

        if ($_SESSION['user_id'] == $row['user_id']) {
            echo '<form style="position: absolute; bottom: 10px; right: 10px;">';
            echo '<button type="button" class="delete-question-btn" data-question-id="' . $row['id'] . '"><i class="fa fa-trash"></i></button>';
            echo '</form>';
        }
        echo '</div>';
        echo '</div>';

        $question_id = $row['id'];
        $sql_answers = "SELECT answers.answer, users.username AS admin_name, answers.created_at 
                        FROM answers 
                        JOIN users ON answers.admin_id = users.id 
                        WHERE answers.question_id = '$question_id' 
                        ORDER BY answers.created_at ASC";
        $result_answers = $conn->query($sql_answers);

        if ($result_answers->num_rows > 0) {
            while ($answer = $result_answers->fetch_assoc()) {
                echo '<div class="answer-card" style="margin-left: 20px; margin-bottom: 20px;">';
                echo '<div class="answer-info">';
                echo '<h3 class="answer-name">' . htmlspecialchars($answer['admin_name']) . '</h3>';
                echo '<p class="answer-description">' . htmlspecialchars($answer['answer']) . '</p>';
                echo '<p class="answer-usage">Dijawab pada ' . $answer['created_at'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="not-answered" style="margin-left: 20px;">Belum ada jawaban.</p>';
        }
    }
} else {
    echo "<p>Belum ada pertanyaan.</p>";
}
$conn->close();
?>
