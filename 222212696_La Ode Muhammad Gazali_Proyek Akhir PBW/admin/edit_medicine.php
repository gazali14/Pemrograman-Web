<?php
include('db.php');

$id = $_POST['id'];
$nama_obat = $_POST['nama_obat'];
$deskripsi = $_POST['deskripsi'];
$aturan_pakai = $_POST['aturan_pakai'];
$ketersediaan = $_POST['ketersediaan'];

// Cek apakah gambar baru diupload
if ($_FILES['gambar']['size'] > 0) {
    $target_dir = "../img/";
    $gambar = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    // Batasi ukuran file maksimal hanya 5MB
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
            $sql = "UPDATE obat SET nama_obat=?, deskripsi=?, aturan_pakai=?, ketersediaan=?, path_gambar=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nama_obat, $deskripsi, $aturan_pakai, $ketersediaan, $_FILES["gambar"]["name"], $id);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                header('Location: medicine.php');
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
        }
    }
} else {
    // Jika tidak ada file yang diunggah, hanya update data lainnya tanpa gambar
    $sql = "UPDATE obat SET nama_obat=?, deskripsi=?, aturan_pakai=?, ketersediaan=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nama_obat, $deskripsi, $aturan_pakai, $ketersediaan, $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        header('Location: medicine.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>
