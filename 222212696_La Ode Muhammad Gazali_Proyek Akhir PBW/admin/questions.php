<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

include('header.php');
include('db.php');
?>

<h2>Manage Questions</h2>

<!-- Display Questions -->
<div class="details">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pertanyaan</th>
                <th>Diajukan pada</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT q.id, u.username, q.question, q.created_at, q.status, 
                        IFNULL(a.answer, '') AS answer
                    FROM questions q
                    LEFT JOIN answers a ON q.id = a.question_id
                    LEFT JOIN users u ON q.user_id = u.id";
            $result = $conn->query($sql);
            $counter=1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $statusClass = $row['status'] === 'Belum Dijawab' ? 'status-belum-dijawab' : 'status-sudah-dijawab';
                    echo "<tr>
                            <td>{$counter}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['question']}</td>
                            <td>{$row['created_at']}</td>
                            <td class='$statusClass'>{$row['status']}</td>
                            <td>
                                <button class='btn' onclick=\"answerQuestion({$row['id']}, '{$row['question']}')\">Jawab</button>
                            </td>
                        </tr>";
                    $counter++;
                }
            } else {
                echo "<tr><td colspan='5'>No questions found</td></tr>";
            }
        ?>

        </tbody>
    </table>
</div>

<!-- Answer Question Modal -->
<div id="answerQuestionModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Answer Question</h2>
        <p id="questionText"></p>
        <form id="answerQuestionForm" method="post" action="add_answer.php">
            <label for="answer">Answer:</label>
            <textarea id="answer" name="answer" required></textarea>
            <input type="hidden" id="question_id" name="question_id">
            <button type="submit">Submit Answer</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>


<style>
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        width: 100vw; 
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5); 
        border: 1px solid #ccc;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        top: 50%;
        left: 50%;
        align-content: center;
        transform: translate(-50%, -50%);
    }

    .modal-content {
        position: relative;
        background-color: #fefefe;
        margin: 1% auto;
        padding: 20px;
        border: 1px solid #888;
        max-width: 300px;
    }

    .modal-content label {
        display: block;
        margin-bottom: 1px;
    }

    .modal-content input,
    .modal-content textarea,
    .modal-content select {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 3px;
        border: 1px solid #ccc;
    }

    .modal-content button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    .modal-content button:hover {
        background-color: #45a049;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .status-belum-dijawab {
        text-align: center;
        font-weight: bold;
        background-color: #ff0000;
        display: inline-block;
        color: #fff;
    }

    .status-sudah-dijawab {
        text-align: center;
        font-weight: bold;
        background-color: blue;
        color: #fff;
        display: inline-block;
    }
</style>

<script>
    var answerQuestionModal = document.getElementById('answerQuestionModal');
    var span = document.getElementsByClassName("close")[0];

    function answerQuestion(questionId, questionText) {
        answerQuestionModal.style.display = "block";
        document.getElementById('questionText').textContent = questionText;
        document.getElementById('question_id').value = questionId;
    }

    span.onclick = function() {
        answerQuestionModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == answerQuestionModal) {
            answerQuestionModal.style.display = "none";
        }
    }
</script>