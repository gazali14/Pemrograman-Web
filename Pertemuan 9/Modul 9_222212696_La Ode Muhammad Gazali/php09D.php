<!DOCTYPE html> 
<html lang='en-GB'>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP09 D</title>
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
    </style>
</head>
<body>
    <h1>PHP and Databases</h1>
    <?php
    $db_hostname = "localhost"; // Ganti dengan server database Anda
    $db_database = "praktikum9"; // Ganti dengan nama database Anda
    $db_username = "root"; // Ganti dengan username database Anda
    $db_password = ""; // Ganti dengan password database Anda
    // Untuk praktikum, lebih baik jangan gunakan password asli Anda

    $db_charset = "utf8mb4"; // Opsional
    $dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    );
    try {
        $pdo = new PDO($dsn, $db_username, $db_password, $opt);
        echo "<h2>Data in meeting table (Using Table)</h2>\n";
        $stmt = $pdo->query("SELECT * FROM meetings ORDER BY slot");
        $rows = $stmt->fetchAll();

        if (count($rows) > 0) {
            echo "<table>";
            echo "<tr><th>Slot</th><th>Name</th><th>Email</th></tr>";
            foreach ($rows as $row) {
                echo "<tr>";
                echo "<td>" . $row["slot"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No data found.";
        }

        $pdo = NULL;
    } catch (PDOException $e) {
        exit("PDO Error: " . $e->getMessage() . "<br>");
    }
    ?>
</body>
</html>
