<?php
include 'db_koneksi.php';

$sql = "SELECT * FROM artikel"; // Ambil artikel dengan id
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="berita">';
        echo '<h1 class="judul">' . $row["judul"] . '</h1>';
        echo '<h6 class="tanggal">' . date("d M Y", strtotime($row["tanggal"])) . '</h6>';
        echo '<hr class="separator" />';
        echo '<img src="' . $row["gambar"] . '" alt="Gambar Artikel" class="gambar-artikel" />';
        echo '<p class="paragraf-berita">' . nl2br($row["konten"]) . '</p>';
        echo '</div>';
    }
} else {
    echo "0 hasil";
}
$conn->close();
?>
