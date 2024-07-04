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

<h2>Manage Schedules</h2>

<!-- Display Schedules -->
<div class="details">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Dokter </th>
                <th>Tanggal</th>
                <th>Mulai</th>
                <th>Berakhir</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $sql = "SELECT schedules.*, doctors.name AS doctor_name 
                    FROM schedules 
                    JOIN doctors ON schedules.doctor_id = doctors.id
                    ORDER BY schedules.date DESC";
            $result = $conn->query($sql);
            $counter = 1;
            while ($row = $result->fetch_assoc()) {
                $status_color = '';
                switch ($row['status']) {
                    case 'on-time':
                        $status_color = 'blue';
                        break;
                    case 'delayed':
                        $status_color = 'yellow';
                        break;
                    case 'cancelled':
                        $status_color = 'red';
                        break;
                    default:
                        $status_color = 'blue';
                        break;
                }
                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['doctor_name']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['start_time']}</td>
                        <td>{$row['end_time']}</td>
                        <td class='status' data-status='{$row['status']}' style='background-color: {$status_color};'>{$row['status']}</td>
                        <td>
                            <button class='btn update-schedule-btn' data-id='" . htmlspecialchars($row['id']) . "'>
                                <ion-icon name='pencil-outline'></ion-icon>    
                            </button>
                            <button style='background-color:rgb(209, 17, 17)' class='btn' onclick='deleteSchedule(" . htmlspecialchars($row['id']) . ")'>
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
<?php
    $sql = "SELECT id, name FROM doctors";
    $result = $conn->query($sql);
    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
?>

<!-- Add Schedule Form -->
<div class="details">
    <h3>Add Schedule</h3>
    <form id="addScheduleForm" method="post" action="add_schedule.php">
        <label for="doctor_id">Doctor:</label>
        <select id="doctor_id" name="doctor_id" required>
            <option value="">Select Doctor</option>
            <?php foreach ($doctors as $doctor) : ?>
                <option value="<?php echo htmlspecialchars($doctor['id']); ?>">
                    <?php echo htmlspecialchars($doctor['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required>
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="on-time">On Time</option>
            <option value="delayed">Delayed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <button class="btn" type="submit">Add Schedule</button>
    </form>
</div>
<!-- Update Schedule Modal -->
<div id="updateScheduleModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Schedule</h2>
        <form id="updateScheduleForm" action="edit_schedule.php" method="post">
            <input type="hidden" id="updateScheduleId" name="id">
            <label for="updateDoctorId">Doctor:</label>
            <select id="updateDoctorId" name="doctor_id" required>
                <?php foreach ($doctors as $doctor) : ?>
                    <option value="<?php echo htmlspecialchars($doctor['id']); ?>">
                        <?php echo htmlspecialchars($doctor['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="updateDate">Date:</label>
            <input type="date" id="updateDate" name="date" required>
            <label for="updateStartTime">Start Time:</label>
            <input type="time" id="updateStartTime" name="start_time" required>
            <label for="updateEndTime">End Time:</label>
            <input type="time" id="updateEndTime" name="end_time" required>
            <label for="updateStatus">Status:</label>
            <select id="updateStatus" name="status">
                <option value="on-time">On Time</option>
                <option value="delayed">Delayed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button type="submit">Update Schedule</button>
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
        margin: 2% auto;
        padding: 20px;
        border: 1px solid #888;
        max-width: 300px;
        box-shadow:rgba(0, 0, 0, 0.5);
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
    td.status[data-status="on-time"] {
        background-color: blue;
        color: white;
    }

    td.status[data-status="delayed"] {
        background-color: yellow;
        color: black;
    }

    td.status[data-status="cancelled"] {
        background-color: red;
        color: white;
    }

</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var updateScheduleModal = document.getElementById('updateScheduleModal');
        var updateScheduleBtns = document.getElementsByClassName('update-schedule-btn');
        var span = document.getElementsByClassName("close")[0];

        Array.prototype.forEach.call(updateScheduleBtns, function(btn) {
            btn.onclick = function() {
                updateScheduleModal.style.display = "block";
                var scheduleId = this.getAttribute("data-id");
                fetch('get_schedule.php?schedule_id=' + scheduleId)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            document.getElementById('updateScheduleId').value = data.id;
                            document.getElementById('updateDoctorId').value = data.doctor_id;
                            document.getElementById('updateDate').value = data.date;
                            document.getElementById('updateStartTime').value = data.start_time;
                            document.getElementById('updateEndTime').value = data.end_time;
                            document.getElementById('updateStatus').value = data.status;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            };
        });

        span.onclick = function() {
            updateScheduleModal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == updateScheduleModal) {
                updateScheduleModal.style.display = "none";
            }
        };

        // Function untuk menghapus jadwal
        window.deleteSchedule = function(id) {
            if (confirm('Apa Anda yakin ingin menghapus jadwal ini ?')) {
                fetch('delete_schedule.php', {
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
        };
    });
</script>