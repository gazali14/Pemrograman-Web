<?php

header('Content-Type: application/json');

include 'db_koneksi.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['medicine_id']) && isset($data['quantity'])) {
    $medicine_id = $data['medicine_id'];
    $quantity = $data['quantity'];

    // Check current availability
    $stmt = $conn->prepare("SELECT ketersediaan FROM obat WHERE id = ?");
    $stmt->bind_param("i", $medicine_id);
    $stmt->execute();
    $stmt->bind_result($current_availability);
    $stmt->fetch();
    $stmt->close();

    if ($quantity > $current_availability) {
        echo json_encode(["error" => "Jumlah permintaan melebihi ketersediaan."]);
        exit();
    }

    // Update availability
    $update_sql = "UPDATE obat SET ketersediaan = ketersediaan - ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ii", $quantity, $medicine_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Ketersediaan obat berhasil diperbarui."]);
    } else {
        echo json_encode(["error" => "Error: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid input"]);
}

$conn->close();
?>
