<?php
include('db.php');

$id = $_POST['id'];
$judul = $_POST['judul'];
$tanggal = $_POST['tanggal'];
$konten = $_POST['konten'];
$gambar = '';

// Cek apakah ada gambar baru yang diunggah
if (!empty($_FILES['gambar']['name'])) {
    $target_dir = "../img/"; 
    $gambar = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    // batasi ukuran file gambar maksimal 5MB
    if ($_FILES["gambar"]["size"] > 5000000) {
        echo "File terlalu besar.";
        $uploadOk = 0;
    }

    // Hanya izinkan format tertentu
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "File tidak terunggah.";
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar)) {
            $gambar = $_FILES["gambar"]["name"];
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
            $uploadOk = 0;
        }
    }
}

if ($uploadOk == 1 && !empty($gambar)) {
    $sql = "UPDATE artikel SET judul=?, tanggal=?, konten=?, gambar=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $judul, $tanggal, $konten, $gambar, $id);
} else {
    $sql = "UPDATE artikel SET judul=?, tanggal=?, konten=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $judul, $tanggal, $konten, $id);
}

if ($stmt->execute()) {
    header("Location: articles.php");
    exit();
} else {
    echo "Error updating article: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>