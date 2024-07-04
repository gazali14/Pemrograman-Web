<?php
include('db.php');

$judul = $_POST['judul'];
$tanggal = $_POST['tanggal'];
$konten = $_POST['konten'];

$target_dir = "../img/";
$gambar = $target_dir . basename($_FILES["gambar"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

// Cek ukuran file, maksimal 5MB
if ($_FILES["gambar"]["size"] > 5000000) { 
    echo "File terlalu besar.";
    $uploadOk = 0;
}

// Batasi format file yang diupload
$allowed_types = array('jpg', 'jpeg', 'png', 'gif');
if (!in_array($imageFileType, $allowed_types)) {
    echo "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
    $uploadOk = 0;
}


if ($uploadOk == 0) {
    echo "File tidak terunggah.";
} else {
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar)) {
        $sql = "INSERT INTO artikel (judul, tanggal, konten, gambar) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $judul, $tanggal, $konten, $_FILES["gambar"]["name"]);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            echo "Artikel berhasil ditambahkan";
            header('Location: articles.php');
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
