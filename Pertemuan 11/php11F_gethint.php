<?php
    // Pengaturan koneksi ke database
    $db_hostname = "localhost"; // Ganti dengan server database Anda
    $db_database = "praktikum9"; // Ganti dengan nama database Anda
    $db_username = "root"; // Ganti dengan username database Anda
    $db_password = ""; // Ganti dengan password database Anda
    $db_charset = "utf8mb4"; // Opsional
    $dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    );
    
    try {
        // Membuat koneksi PDO
        $pdo = new PDO($dsn, $db_username, $db_password, $opt);
        
        // Mendapatkan kata kunci pencarian dari parameter GET
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        
        // Query untuk mendapatkan nama-nama yang memuat kata kunci pencarian yang diinput oleh user
        $stmt = $pdo->prepare("SELECT name FROM meetings WHERE name LIKE :keyword");
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        
        // Menginisialisasi array untuk menyimpan hasil query
        $results = [];
        
        // Memasukkan nama-nama yang memuat kata kunci pencarian ke dalam array
        while ($row = $stmt->fetch()) {
            $results[] = $row;
        }
        
        // Mengirimkan hasil sebagai JSON
        if (!empty($results)) {
            echo json_encode($results);
        } else {
            // Output "no suggestion" jika tidak ada saran yang ditemukan
            $response[] = array('name' => 'no suggestion');
            echo json_encode($response);
        }
        
        // Menutup koneksi database
        $pdo = null;
    } catch (PDOException $e) {
        exit("PDO Error: " . $e->getMessage() . "<br>");
    }
?>
