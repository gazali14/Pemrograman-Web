<!DOCTYPE html> 
<html lang='en-GB'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP09 F</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }

        .btn-container a {
            margin: 0 5px;
        }
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Data Meeting</h1>
    <?php
        // Tampilkan pemberitahuan jika ada parameter success di URL
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<div class='success-message'>Data berhasil dihapus.</div>";
        }
    ?>

    <?php
    // Pengaturan koneksi ke database
    $db_hostname = "localhost"; // Ganti dengan server database Anda
    $db_database = "praktikum9"; // Ganti dengan nama database Anda
    $db_username = "root"; // Ganti dengan username database Anda
    $db_password = ""; // Ganti dengan password database Anda

    // Koneksi ke database
    $pdo = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mendapatkan data dari tabel meetings
    $stmt = $pdo->query("SELECT * FROM meetings ORDER BY slot");
    $rows = $stmt->fetchAll();

    if (count($rows) > 0) {
        echo "<table>";
        echo "<tr><th>Slot</th><th>Name</th><th>Email</th><th>Action</th></tr>";
        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . $row["slot"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td class='btn-container'>";
            echo "<a href='php09G.php?slot=" . $row["slot"] . "'><img src='img/edit.png' style='width:30px;height:30px;' alt='Edit' title='Edit'></a>";
            echo "<a href='php09H.php?slot=" . $row["slot"] . "'><img src='img/remove.png' style='width:30px;height:30px;' alt='Delete' title='Delete'></a>";
            echo "</td>";
            echo "</tr>";
        }        
        echo "</table>";
    } else {
        echo "No data found.";
    }

    

    // Menutup koneksi database
    $pdo = null;
    ?>
</body>
</html>
