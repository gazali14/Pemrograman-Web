<?php 
    session_start(); // Memulai session
    
    if (!isset($_SESSION['username'])){
        header("Location: php10D.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meeting</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
    <h1>Edit Meeting</h1>
    <div class="container">
        <form action="php10G.php" method="post">
            <input type="hidden" name="old_slot" value="<?php echo isset($_GET['slot']) ? $_GET['slot'] : ''; ?>">
            <label for="new_slot">New Slot:</label>
            <input type="text" id="new_slot" name="new_slot" value="<?php echo isset($_GET['slot']) ? $_GET['slot'] : ''; ?>"><br>
            <label for="new_name">New Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>"><br>
            <label for="new_email">New Email:</label>
            <input type="text" id="new_email" name="new_email" value="<?php echo isset($_GET['email']) ? $_GET['email'] : ''; ?>"><br>
            <input type="submit" value="Save">
        </form>
    </div>

    <?php
        // Menyertakan atau menetapkan nilai koneksi database
        $db_hostname = "localhost";
        $db_database = "praktikum9";
        $db_username = "root";
        $db_password = "";

        // Koneksi ke database
        $pdo = new PDO("mysql:host=$db_hostname;dbname=$db_database", $db_username, $db_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Memeriksa apakah metode permintaan adalah POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Mengambil data dari formulir edit
            $oldSlot = $_POST["old_slot"];
            $newSlot = $_POST["new_slot"];
            $newName = $_POST["new_name"];
            $newEmail = $_POST["new_email"];

            try {
                // Menyiapkan dan mengeksekusi pernyataan SQL untuk mengubah data pertemuan
                $stmt = $pdo->prepare("UPDATE meetings SET slot = :new_slot, name = :new_name, email = :new_email WHERE slot = :old_slot");
                $stmt->execute(array(':new_slot' => $newSlot, ':new_name' => $newName, ':new_email' => $newEmail, ':old_slot' => $oldSlot));

                // Redirect kembali ke halaman php10F.php setelah berhasil mengubah data
                header("Location: php10F.php");
                exit();
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    ?>
</body>
</html>
