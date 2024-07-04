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

<h2>Manage Doctors</h2>

<div class="details">
    <!-- Display Doctors -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialization</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM doctors";
            $result = $conn->query($sql);
            $counter=1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['specialization']}</td>
                        <td>
                            <button class='btn' onclick=\"editDoctor({$row['id']})\">
                                <ion-icon name='pencil-outline'></ion-icon>    
                            </button>
                            <button style='background-color:rgb(209, 17, 17)' class='btn' onclick=\"deleteDoctor({$row['id']})\">
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

<!-- Add Doctor Form -->
<div class="details">
    <h3>Add Doctor</h3>
    <form id="addDoctorForm" method="post" action="add_doctor.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" required>
        <button class='btn' type="submit">Add Doctor</button>
    </form>
</div>

<!-- Update Doctor Modal -->
<div id="updateDoctorModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Doctor</h2>
        <form id="updateDoctorForm" action="edit_doctor.php" method="post">
            <input type="hidden" id="updateDoctorId" name="id">
            <label for="updateName">Name:</label>
            <input type="text" id="updateName" name="name" required>
            <label for="updateSpecialization">Specialization:</label>
            <input type="text" id="updateSpecialization" name="specialization" required>
            <button type="submit">Update Doctor</button>
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
        margin-bottom: 10px;
    }

    .modal-content input,
    .modal-content select {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 10px;
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

</style>
<script>
    var updateDoctorModal = document.getElementById('updateDoctorModal');
    var updateDoctorBtns = document.querySelectorAll('.edit-doctor-btn');
    var span = document.getElementsByClassName("close")[0];

    for (var i = 0; i < updateDoctorBtns.length; i++) {
        updateDoctorBtns[i].onclick = function() {
            updateDoctorModal.style.display = "block";
            var doctorId = this.getAttribute("data-id");
            fetch('get_doctor.php?id=' + doctorId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('updateDoctorId').value = data.id;
                    document.getElementById('updateName').value = data.name;
                    document.getElementById('updateSpecialization').value = data.specialization;
                })
                .catch(error => console.error('Error:', error));
        }
    }

    span.onclick = function() {
        updateDoctorModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == updateDoctorModal) {
            updateDoctorModal.style.display = "none";
        }
    }

    // Function untuk delete data dokter
    function deleteDoctor(id) {
        if (confirm('Apakah kamu yakin ingin menghapus data dokter ini?')) {
            fetch('delete_doctor.php', {
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

    // Function untuk edit data dokter
    function editDoctor(id) {
        updateDoctorModal.style.display = "block";
        fetch('get_doctor.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('updateDoctorId').value = data.id;
                document.getElementById('updateName').value = data.name;
                document.getElementById('updateSpecialization').value = data.specialization;
            })
            .catch(error => console.error('Error:', error));
    }

</script>