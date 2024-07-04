<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

include('header.php');
include('db.php');
?>

<h2>Manage Medicines</h2>

<!-- Display Medicines -->
<div class="details">
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Nama</th>
                <th style="width: 20%;">Deskripsi</th>
                <th style="width: 20%;">Instruksi</th>
                <th style="width: 10%;">Ketersediaan</th>
                <th style="width: 15%;">Gambar</th>
                <th style="width: 15%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM obat";
            $result = $conn->query($sql);
            $counter=1;
            while ($row = $result->fetch_assoc()) {
                $gambarPath = '../img/' . $row['path_gambar']; // Sesuaikan dengan struktur direktori yang benar

                if (strpos($gambarPath, '..') !== false) {
                    $gambarPath = '../img/'. basename($gambarPath);
                }

                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['nama_obat']}</td>
                        <td>{$row['deskripsi']}</td>
                        <td>{$row['aturan_pakai']}</td>
                        <td>{$row['ketersediaan']}</td>
                        <td><img src='{$gambarPath}' alt='Medicine Image' style='max-width: 100px;'></td>
                        <td>
                            <button class='btn edit-medicine-btn' 
                                    data-id='{$row['id']}' 
                                    data-nama='{$row['nama_obat']}' 
                                    data-deskripsi='{$row['deskripsi']}' 
                                    data-aturan='{$row['aturan_pakai']}' 
                                    data-ketersediaan='{$row['ketersediaan']}' 
                                    data-gambar='{$gambarPath}'>
                                <ion-icon name='pencil-outline'></ion-icon>
                            </button>
                            <button style='background-color:rgb(209, 17, 17)' action='delete_medicine.php' class='btn delete-medicine-btn' onclick=\"deleteMedicine({$row['id']})\">
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

<!-- Add Medicine Form -->
<div class="details">
    <h3>Add Medicine</h3>
    <form id="addMedicineForm" method="post" enctype="multipart/form-data" action="add_medicine.php">
        <label for="nama_obat">Name:</label>
        <input type="text" id="nama_obat" name="nama_obat" required>
        <label for="deskripsi">Description:</label>
        <textarea id="deskripsi" name="deskripsi" required></textarea>
        <label for="aturan_pakai">Instructions:</label>
        <textarea id="aturan_pakai" name="aturan_pakai" required></textarea>
        <label for="ketersediaan">Availability:</label>
        <input type="number" id="ketersediaan" name="ketersediaan" required>
        <label for="gambar">Image:</label>
        <input type="file" id="gambar" name="gambar" required>
        <button class="btn" type="submit">Add Medicine</button>
    </form>
</div>

<!-- Edit Medicine Modal -->
<div id="editMedicineModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Medicine</h2>
        <form id="editMedicineForm" action="edit_medicine.php" method="post" enctype="multipart/form-data">
            <input type="hidden" id="editMedicineId" name="id">
            <label for="editNamaObat">Name:</label>
            <input type="text" id="editNamaObat" name="nama_obat" required>
            <label for="editDeskripsi">Description:</label>
            <textarea id="editDeskripsi" name="deskripsi" required></textarea>
            <label for="editAturanPakai">Instructions:</label>
            <textarea id="editAturanPakai" name="aturan_pakai" required></textarea>
            <label for="editKetersediaan">Availability:</label>
            <input type="number" id="editKetersediaan" name="ketersediaan" required>
            <label for="editGambar">Image:</label>
            <input type="file" id="editGambar" name="gambar">
            <button type="submit">Update Medicine</button>
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
        position: relative;
        background-color: #fefefe;
        margin: 2% auto;
        padding: 20px;
        border: 1px solid #888;
        max-width: 300px;
        
    }

    .modal-content label {
        display: block;
        margin-bottom: 1px;
    }

    .modal-content input,
    .modal-content textarea {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 4px;
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

    .delete-medicine-btn{
        background-color: rgb(209, 17, 17);
    }
    

</style>

<script>
    var editMedicineModal = document.getElementById('editMedicineModal');
    var editMedicineBtns = document.querySelectorAll('.edit-medicine-btn');
    var span = document.getElementsByClassName("close")[0];

    for (var i = 0; i < editMedicineBtns.length; i++) {
        editMedicineBtns[i].onclick = function() {
            editMedicineModal.style.display = "block";
            var medicineId = this.getAttribute("data-id");
            var namaObat = this.getAttribute("data-nama");
            var deskripsi = this.getAttribute("data-deskripsi");
            var aturanPakai = this.getAttribute("data-aturan");
            var ketersediaan = this.getAttribute("data-ketersediaan");
            var gambar = this.getAttribute("data-gambar");

            document.getElementById('editMedicineId').value = medicineId;
            document.getElementById('editNamaObat').value = namaObat;
            document.getElementById('editDeskripsi').value = deskripsi;
            document.getElementById('editAturanPakai').value = aturanPakai;
            document.getElementById('editKetersediaan').value = ketersediaan;
            document.getElementById('editGambar').value = '';

            var previewImg = editMedicineModal.querySelector('.preview-img');
            previewImg.src = gambar;
        }
    }

      // Function untuk delete obat
      function deleteMedicine(id) {
        if (confirm('Apakah kamu yakin ingin menghapus obat ini?')) {
            fetch('delete_medicine.php', {
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

    span.onclick = function() {
        editMedicineModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == editMedicineModal) {
            editMedicineModal.style.display = "none";
        }
    }
</script>
