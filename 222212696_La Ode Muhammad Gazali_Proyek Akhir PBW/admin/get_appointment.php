<?php
include('db.php');

$id = $_GET['id'];

$sql = "SELECT appointments.id, appointments.doctor_id, appointments.schedule_id, appointments.patient_name, appointments.complaint, appointments.additional_info, appointments.status,
                doctors.name as doctor_name, schedules.date, schedules.start_time, schedules.end_time
        FROM appointments
        JOIN doctors ON appointments.doctor_id = doctors.id
        JOIN schedules ON appointments.schedule_id = schedules.id
        WHERE appointments.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $appointment = array(
        'id' => $row['id'],
        'doctor_id' => $row['doctor_id'],
        'schedule_id' => $row['schedule_id'],
        'patient_name' => $row['patient_name'],
        'complaint' => $row['complaint'],
        'additional_info' => $row['additional_info'],
        'status' => $row['status']
    );
    
    // Definisikan warna berdasarkan statusnya
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

    $appointment['status_color'] = $status_color;

    echo json_encode($appointment);
} else {
    echo "Appointment tidak ditemukan";
}

$stmt->close();
$conn->close();

