<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<?php
include 'db_koneksi.php';

// Query untuk mendapatkan semua pertanyaan
$sql = "SELECT questions.id, questions.question, users.username, questions.created_at 
        FROM questions 
        JOIN users ON questions.user_id = users.id 
        ORDER BY questions.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pertanyaan</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tanya_jawab.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .delete-question-btn {
            background-color: #cc0000;
            color: white;
            border: none;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            margin-top: 1rem;
            right: 10px;
            width: 28px;
        }

        .delete-question-btn:hover {
            background-color: #890000;
        }

        .popup-container {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%);
            z-index: 999;
            top: 50%;
            left: 50%;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
        }

        .popup {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            color: #000;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
        }

        #confirm-no-btn {
            background-color: #ff0000; 
            color: #fff;
            transition: background-color 0.3s ease;
        }

        #confirm-no-btn:hover {
            background-color: #cc0000;         }

        #confirm-yes-btn {
            background-color: #4caf50; 
            color: #fff;
            transition: background-color 0.3s ease;
        }

        #confirm-yes-btn:hover {
            background-color: #388e3c; 
        }
    </style>
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body style="background-image: url('img/bg.svg')">
    <nav class="navbar">
        <a href="mainpage.php" class="navbar-logo">Klinik<span>STIS</span></a>
        <div class="navbar-extra">
            <i href="index.php" data-feather="home"></i>
        </div>
    </nav>

    <section class="ask-section">
        <div class="container">
            <h1 class="judul">Tanya Dokter</h1>  
            <div class="ask-list">
                <a class="create-question-btn" href="buat_pertanyaan.php">Buat Pertanyaan</a>
                <?php
                include 'fetch_tanya_jawab.php';
                ?>
            </div>
        </div>
    </section>

    <div class="popup-container" id="confirm-popup">
        <div class="popup">
            <p>Apakah Anda yakin ingin menghapus pertanyaan Anda?</p>
            <button id="confirm-yes-btn">Ya</button>
            <button id="confirm-no-btn">Tidak</button>
        </div>
    </div>
    
    <form id="delete-form" action="fetch_hapus_pertanyaan.php" method="post" style="display: none;">
        <input type="hidden" name="question_id" id="question-id">
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const deleteButtons = document.querySelectorAll(".delete-question-btn");
            const confirmPopup = document.getElementById("confirm-popup");
            const confirmYesBtn = document.getElementById("confirm-yes-btn");
            const confirmNoBtn = document.getElementById("confirm-no-btn");
            const deleteForm = document.getElementById("delete-form");
            const questionIdInput = document.getElementById("question-id");

            let questionIdToDelete = null;

            function showConfirmation() {
                confirmPopup.style.display = "block";
            }

            function hideConfirmation() {
                confirmPopup.style.display = "none";
            }

            deleteButtons.forEach(button => {
                button.addEventListener("click", function() {
                    questionIdToDelete = this.dataset.questionId;
                    showConfirmation();
                });
            });

            confirmYesBtn.addEventListener("click", function() {
                if (questionIdToDelete) {
                    questionIdInput.value = questionIdToDelete;
                    deleteForm.submit();
                }
            });

            confirmNoBtn.addEventListener("click", function() {
                hideConfirmation();
            });
        });
    </script>
</body>
</html>
