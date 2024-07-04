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

<body>
<h2>Manage Users</h2>
<!-- Display Users -->
<div class="details">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);
            $counter=1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>" . ($row['is_admin'] ? 'Yes' : 'No') . "</td>
                        <td>
                            <button class='btn update-user-btn' data-id='{$row['id']}'>
                                <ion-icon name='pencil-outline'></ion-icon>
                            </button>
                            <button style='background-color:rgb(209, 17, 17)' class='btn' onclick='deleteUser({$row['id']})'>
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

<!-- Add User Form -->
<div class="details">
    <h3>Add User</h3>
    <form id="addUserForm" method="post" action="add_user.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <label for="is_admin">Is Admin:</label>
        <input class="checkbox" type="checkbox" id="is_admin" name="is_admin">
        <button class="btnform" type="submit">Add User</button>
    </form>
</div>

<!-- Update User Modal -->
<div id="updateUserModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update User</h2>
        <form id="updateUserForm" action="edit_user.php" method="post">
            <input type="hidden" id="updateUserId" name="id">
            <label for="updateUsername">Username:</label>
            <input type="text" id="updateUsername" name="username" required>
            <label for="updateEmail">Email:</label>
            <input type="email" id="updateEmail" name="email" required>
            <label for="updateIsAdmin">Is Admin:</label>
            <input type="checkbox" id="updateIsAdmin" name="is_admin">
            <button type="submit">Update User</button>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>

<style> 
    /* modal style */
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
    .modal-content textarea {
        display: block;
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

    .modal-content input[type="checkbox"] {
        width: auto;
        margin-right: 10px;
        vertical-align: middle; 
        transform: translateY(2px);
    }

    .modal-content input[type="checkbox"] {
        margin-right: 100px;
        transform: translateY(2px);
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
    var modal = document.getElementById('updateUserModal');
    var btns = document.getElementsByClassName('update-user-btn');
    var span = document.getElementsByClassName("close")[0];

    for (var i = 0; i < btns.length; i++) {
        btns[i].onclick = function() {
            modal.style.display = "block";
            var userId = this.getAttribute("data-id");
            fetch('get_user.php?id=' + userId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('updateUserId').value = data.id;
                    document.getElementById('updateUsername').value = data.username;
                    document.getElementById('updateEmail').value = data.email;
                    document.getElementById('updateIsAdmin').checked = data.is_admin == 1;
                })
                .catch(error => console.error('Error:', error));
        }
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Function untuk menghapus data user
    function deleteUser(id) {
        if (confirm('Apakah kamu yakin ingin menghapus user ini?')) {
            fetch('delete_user.php', {
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
    
</script>
<script src="admin/js/script.js"></script>