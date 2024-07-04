<?php
// Koneksi ke database
include 'db_koneksi.php';

// Update waktu terakhir aksi pengguna
$_SESSION['last_activity'] = time();
// Query untuk mengambil data jadwal dokter beserta informasi dokter
$sql = "SELECT schedules.*, doctors.name AS doctor_name FROM schedules LEFT JOIN doctors ON schedules.doctor_id = doctors.id"; // Sesuaikan dengan nama tabel dan kolom Anda
$result = $conn->query($sql);

$schedules = [];

// Ubah hasil query menjadi array asosiatif
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
}

// Mengirimkan data jadwal sebagai respon JSON
header('Content-Type: application/json');

// Tambahkan informasi apakah tanggal jadwal masih bisa dijadikan appointment
$currentDate = date('Y-m-d');
foreach ($schedules as &$schedule) {
    // Tambahkan informasi apakah tanggal jadwal masih bisa dijadikan appointment
    $schedule['can_appoint'] = ($schedule['date'] >= $currentDate);
}

echo json_encode($schedules);

$conn->close();
?>
