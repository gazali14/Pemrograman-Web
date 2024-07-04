<?php
include 'db_koneksi.php';

// Function untuk mengambil dan menampilkan data obat
function fetchMedicineData($conn) {
    $sql = "SELECT * FROM obat";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="medicine-card">';
            echo '<img src="img/' . htmlspecialchars($row["path_gambar"]) . '" alt="Medicine Image" class="medicine-image"/>';
            echo '<div class="medicine-info">';
            echo '<h2 class="medicine-name">' . htmlspecialchars($row["nama_obat"]) . '</h2>';
            echo '<p class="medicine-description">' . htmlspecialchars($row["deskripsi"]) . '</p>';
            echo '<p class="medicine-usage">' . htmlspecialchars($row["aturan_pakai"]) . '</p>';
            echo '</div>';
            echo '<p class="medicine-quantity">Jumlah tersedia: ' . htmlspecialchars($row["ketersediaan"]) . '</p>';
            $disabled = ($row["ketersediaan"] == 0) ? 'disabled' : '';
            echo '<button class="request-button" data-id="' . htmlspecialchars($row["id"]) . '" data-name="' . htmlspecialchars($row["nama_obat"]) . '" ' . $disabled . '>Minta Obat</button>';
            echo '</div>';
        }
    } else {
        echo "Tidak ada obat tersedia.";
    }
}

fetchMedicineData($conn);

$conn->close();
?>
