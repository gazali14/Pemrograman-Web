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

<h2>Manage Appointments</h2>

<!-- Display Appointments -->
<div class="details">
    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:10%">Dokter</th>
                <th style="width:15%">Jadwal</th>
                <th style="width:15%">Pasien</th>
                <th style="width:15%">Keluhan</th>
                <th style="width:15%">Keterangan tambahan</th>
                <th style="width:10%">Status</th>
                <th style="width:15%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // SQL query to fetch appointments and order by date and start time
            $sql = "SELECT appointments.id, doctors.name as doctor_name, schedules.date, schedules.start_time, schedules.end_time, appointments.patient_name, appointments.complaint, appointments.additional_info, appointments.status
                    FROM appointments
                    JOIN doctors ON appointments.doctor_id = doctors.id
                    JOIN schedules ON appointments.schedule_id = schedules.id
                    ORDER BY schedules.date DESC, schedules.start_time ASC";
            $counter = 1;
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                // Define color based on status
                $status_color = '';
                switch ($row['status']) {
                    case 'Disetujui':
                        $status_color = 'blue';
                        break;
                    case 'Pending':
                        $status_color = 'yellow';
                        break;
                    case 'Ditolak':
                        $status_color = 'red';
                        break;
                    default:
                        $status_color = 'yellow';
                        break;
                }
                echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['doctor_name']}</td>
                        <td>{$row['date']} {$row['start_time']} - {$row['end_time']}</td>
                        <td>{$row['patient_name']}</td>
                        <td>{$row['complaint']}</td>
                        <td>{$row['additional_info']}</td>
                        <td class='status' data-status='{$row['status']}' style='background-color: {$status_color};'>{$row['status']}</td>
                        <td>
                            <button class=\"btn update-appointment-btn\" data-id=\"{$row['id']}\">
                                <ion-icon name='pencil-outline'></ion-icon>
                            </button>
                            <button style='background-color:rgb(209, 17, 17)' class='btn' onclick=\"deleteAppointment({$row['id']})\">
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

<!-- Update Appointment Modal -->
<div id="updateAppointmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Appointment</h2>
        <form id="updateAppointmentForm" action="edit_appointment.php" method="post">
            <input type="hidden" id="updateAppointmentId" name="id" readonly>
            <input type="hidden" id="updateDoctorIdHidden" name="doctor_id">
            <input type="hidden" id="updateScheduleIdHidden" name="schedule_id">
            <label for="updateDoctorId">Doctor:</label>
            <select id="updateDoctorId" name="doctor_id" disabled>
                <?php
                $sql = "SELECT * FROM doctors";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"{$row['id']}\">{$row['name']}</option>";
                }
                ?>
            </select>
            <label for="updateScheduleId">Schedule:</label>
            <select id="updateScheduleId" name="schedule_id" disabled>
                <?php
                $sql = "SELECT * FROM schedules";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"{$row['id']}\">{$row['date']} {$row['start_time']} - {$row['end_time']}</option>";
                }
                ?>
            </select>
            <label for="updatePatientName">Patient Name:</label>
            <input type="text" id="updatePatientName" name="patient_name" required>
            <label for="updateComplaint">Complaint:</label>
            <textarea id="updateComplaint" name="complaint" required></textarea>
            <label for="updateAdditionalInfo">Additional info:</label>
            <textarea id="updateAdditionalInfo" name="additional_info" required></textarea>
            <label for="updateStatus">Status:</label>
            <select id="updateStatus" name="status" required>
                <option value="Disetujui">Disetujui</option>
                <option value="Pending">Pending</option>
                <option value="Ditolak">Ditolak</option>
            </select>
            <button type="submit">Update Appointment</button>
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

    /* CSS untuk kolom Status */
    td.status {
        font-weight: bold;
        text-align: center;
        color: #fff;
        padding: 8px;
        border-radius: 4px;
    }

    td.status[data-status="Disetujui"] {
        background-color: blue;
        color: white;
    }

    td.status[data-status="Pending"] {
        background-color: yellow;
        color: black;
    }

    td.status[data-status="Ditolak"] {
        background-color: red;
        color: white;
    }
</style>

<script>
    var updateAppointmentModal = document.getElementById('updateAppointmentModal');
    var updateAppointmentBtns = document.querySelectorAll('.update-appointment-btn');
    var span = document.getElementsByClassName("close")[0];

    for (var i = 0; i < updateAppointmentBtns.length; i++) {
        updateAppointmentBtns[i].onclick = function() {
            updateAppointmentModal.style.display = "block";
            var appointmentId = this.getAttribute("data-id");
            fetch('get_appointment.php?id=' + appointmentId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('updateAppointmentId').value = data.id;
                    document.getElementById('updateDoctorId').value = data.doctor_id;
                    document.getElementById('updateScheduleId').value = data.schedule_id;
                    document.getElementById('updatePatientName').value = data.patient_name;
                    document.getElementById('updateComplaint').value = data.complaint;
                    document.getElementById('updateAdditionalInfo').value = data.additional_info;
                    document.getElementById('updateStatus').value = data.status;
                    // Save doctor and schedule values as hidden inputs
                    document.getElementById('updateDoctorIdHidden').value = data.doctor_id
                    document.getElementById('updateDoctorIdHidden').value = data.doctor_id;
                    document.getElementById('updateScheduleIdHidden').value = data.schedule_id;
                })
                .catch(error => console.error('Error:', error));
        }
    }

    span.onclick = function() {
        updateAppointmentModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == updateAppointmentModal) {
            updateAppointmentModal.style.display = "none";
        }
    }

    // Function untuk delete appointment
    function deleteAppointment(id) {
        if (confirm('Apakah kamu yakin ingin menghapus appointment ini?')) {
            fetch('delete_appointment.php', {
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

    // Function untuk submit appointment yang telah diedit
    document.getElementById('updateAppointmentForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        var formData = new FormData(this); 

        fetch('edit_appointment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            updateAppointmentModal.style.display = "none";
            location.reload(); 
        })
        .catch(error => console.error('Error:', error));
    });

</script>