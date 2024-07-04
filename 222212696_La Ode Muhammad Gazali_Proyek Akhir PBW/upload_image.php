<?php
include 'db_koneksi.php';

$userId = $_SESSION['user_id'];

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $uploadFileDir = './img/';
    $newFileName = $uploadFileDir . $fileName;

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

    if (in_array($fileExtension, $allowedfileExtensions)) {
        if (move_uploaded_file($fileTmpPath, $newFileName)) {
            $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newFileName, $userId);

            if ($stmt->execute()) {
                echo json_encode(["success" => true, "filename" => $fileName]);
            } else {
                echo json_encode(["success" => false, "error" => "Failed to update profile image in the database."]);
            }

            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => "Failed to move uploaded file."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "File type is not allowed."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded or an error occurred."]);
}

$conn->close();
?>
