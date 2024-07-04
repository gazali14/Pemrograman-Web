<?php
include('db.php'); 

$nama_obat = $_POST['nama_obat'];
$deskripsi = $_POST['deskripsi'];
$aturan_pakai = $_POST['aturan_pakai'];
$ketersediaan = $_POST['ketersediaan'];


$target_dir = "../img/"; // Sesuaikan direktori tempat Anda menyimpan gambar
$gambar = $target_dir . basename($_FILES["gambar"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

// Batasi ukuran file maksimal 5MB
if ($_FILES["gambar"]["size"] > 5000000) {
    echo "File terlalu besar.";
    $uploadOk = 0;
}

// Izinkan hanya format file tertenut
$allowed_types = array('jpg', 'jpeg', 'png', 'gif');
if (!in_array($imageFileType, $allowed_types)) {
    echo "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "File tidak terunggah.";
} else {
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar)) {
        $sql = "INSERT INTO obat (nama_obat, deskripsi, aturan_pakai, ketersediaan, path_gambar) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $nama_obat, $deskripsi, $aturan_pakai, $ketersediaan, $_FILES["gambar"]["name"]);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            echo "Obat baru berhasil ditambahkan";
            header('Location: medicine.php');
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}

$stmt->close();
$conn->close();
?>
