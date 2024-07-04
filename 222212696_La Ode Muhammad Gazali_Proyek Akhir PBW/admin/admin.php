<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}
?>
<?php include('header.php'); ?>
<?php include('db.php');

// Mengambil data untuk ringkasan
$sql_artikel = "SELECT COUNT(*) as total FROM artikel";
$result_artikel = $conn->query($sql_artikel);
$total_artikel = $result_artikel->fetch_assoc()['total'];

$sql_obat = "SELECT COUNT(*) as total FROM obat";
$result_obat = $conn->query($sql_obat);
$total_obat = $result_obat->fetch_assoc()['total'];

$sql_appointments = "SELECT COUNT(*) as total FROM appointments";
$result_appointments = $conn->query($sql_appointments);
$total_appointments = $result_appointments->fetch_assoc()['total'];

$sql_questions = "SELECT COUNT(*) as total FROM questions";
$result_questions = $conn->query($sql_questions);
$total_questions = $result_questions->fetch_assoc()['total'];

// Menutup koneksi
$conn->close();
?>

<!-- ======================= Cards ================== -->
<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers"><?php echo $total_artikel; ?></div>
            <div class="cardName">Total Artikel</div>
        </div>
        <div class="iconBx">
            <ion-icon name="document-text-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><?php echo $total_obat; ?></div>
            <div class="cardName">Total Obat</div>
        </div>
        <div class="iconBx">
            <ion-icon name="medkit-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><?php echo $total_appointments; ?></div>
            <div class="cardName">Total Janji Temu</div>
        </div>
        <div class="iconBx">
            <ion-icon name="calendar-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers"><?php echo $total_questions; ?></div>
            <div class="cardName">Total Pertanyaan</div>
        </div>
        <div class="iconBx">
            <ion-icon name="help-circle-outline"></ion-icon>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
