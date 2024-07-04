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

<h2>Manage Articles</h2>

<!-- Display Articles -->
<div class="details">
    <table>
        <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th style="width: 15%;">Judul</th>
            <th style="width: 10;">Tanggal</th>
            <th style="width: 35%;">Konten</th>
            <th style="width: 20%;">Gambar</th>
            <th style="width: 15%;">Actions</th>
        </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM artikel";
            $result = $conn->query($sql);
            $counter=1;
            while ($row = $result->fetch_assoc()) {
                // Path gambar
                $gambarPath = '../img/' . basename($row['gambar']);

                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['judul']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>{$row['konten']}</td>
                        <td><img src='{$gambarPath}' alt='Article Image' width='100'></td>
                        <td>
                            <button class='btn update-article-btn' data-id='{$row['id']}'>
                                <ion-icon name='pencil-outline'></ion-icon>
                            </button>
                            <button style='background-color:rgb(209, 17, 17)' class='btn' onclick=\"deleteArticle({$row['id']})\">
                                <ion-icon name='trash-outline'></ion-icon>
                            </button>
                        </td>
                    </tr>";
                $counter++;
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Article Form -->
<div class="details">
    <h3>Add Article</h3>
    <form id="addArticleForm" method="post" enctype="multipart/form-data" action="add_article.php">
        <label for="judul">Title:</label>
        <input type="text" id="judul" name="judul" required>
        <label for="tanggal">Date:</label>
        <input type="date" id="tanggal" name="tanggal" required>
        <label for="konten">Content:</label>
        <textarea id="konten" name="konten" required></textarea>
        <label for="gambar">Image:</label>
        <input type="file" id="gambar" name="gambar" required>
        <button type="submit" class="btn">Add Article</button>
    </form>
</div>

<!-- Update Article Modal -->
<div id="updateArticleModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Article</h2>
        <form id="updateArticleForm" action="edit_article.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="updateArticleId" name="id">
            <label for="updateJudul">Title:</label>
            <input type="text" id="updateJudul" name="judul" required>
            <label for="updateTanggal">Date:</label>
            <input type="date" id="updateTanggal" name="tanggal" required>
            <label for="updateKonten">Content:</label>
            <textarea id="updateKonten" name="konten" required></textarea>
            <label for="updateGambar">Image:</label>
            <input type="file" id="updateGambar" name="gambar">
            <button type="submit" class="btn">Update Article</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>
<style>
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
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fefefe;
        padding: 20px;
        width: 80%;
        max-width: 500px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .modal-content h2 {
        margin-top: 0;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .modal-content label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    .modal-content input,
    .modal-content textarea {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .modal-content button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
    }

    .modal-content button:hover {
        background-color: #45a049;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        color: #aaa;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
    }
</style>
<script>
    var updateArticleModal = document.getElementById('updateArticleModal');
    var updateArticleBtns = document.querySelectorAll('.update-article-btn');
    var span = document.getElementsByClassName("close")[0];

    for (var i = 0; i < updateArticleBtns.length; i++) {
        updateArticleBtns[i].onclick = function() {
            updateArticleModal.style.display = "block";
            var articleId = this.getAttribute("data-id");
            fetch('get_article.php?id=' + articleId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('updateArticleId').value = data.id;
                    document.getElementById('updateJudul').value = data.judul;
                    document.getElementById('updateTanggal').value = data.tanggal;
                    document.getElementById('updateKonten').value = data.konten;
                })
                .catch(error => console.error('Error:', error));
        }
    }

    span.onclick = function() {
        updateArticleModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == updateArticleModal) {
            updateArticleModal.style.display = "none";
        }
    }

    // Function untuk delete artikel
    function deleteArticle(id) {
        if (confirm('Apakah kamu yakin ingin menghapus artikel ini?')) {
            fetch('delete_article.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                location.reload();
            })
            .catch(error => console.error('Error:', error));
        }
    }

    // Function untuk edit artikel
    function editArticle(id) {
        updateArticleModal.style.display = "block";
        fetch('get_article.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('updateArticleId').value = data.id;
                document.getElementById('updateJudul').value = data.judul;
                document.getElementById('updateTanggal').value = data.tanggal;
                document.getElementById('updateKonten').value = data.konten;
            })
            .catch(error => console.error('Error:', error));
    }
</script>

<?php include('footer.php'); ?>