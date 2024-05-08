<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemesanan Tiket Konser</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: auto;
            padding: auto;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background: transparent;
            backdrop-filter: blur(20px);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #fff;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: purple;
        }

        tr:hover {
            background-color: darkgray;
            color: #fff;
        }

        a {
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>DAFTAR PEMESANAN TIKET KONSER</h1>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>E-mail</th>
                    <th>Nomor Telepon</th>
                    <th>Konser</th>
                    <th>Jenis Tiket</th>
                    <th>Jumlah Tiket</th>
                    <th>Invoice</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "konser";

                // Membuat koneksi
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Memeriksa koneksi
                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                // Query untuk mengambil data dari tabel booking
                $sql = "SELECT * FROM booking";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data dalam bentuk tabel
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["concert"] . "</td>";
                        echo "<td>" . $row["ticket_type"] . "</td>";
                        echo "<td>" . $row["quantity"] . "</td>";
                        // Tambahkan link untuk cetak invoice dengan mengirimkan email melalui URL
                        echo "<td><a href='invoice.php?email=" . http_build_query($row) . "'>Cetak Invoice</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada pemesanan.</td></tr>";
                }

                // Menutup koneksi
                $conn->close();
                ?>
            </tbody>
        </table>
        <a href="form.php" class="button">Kembali</a>
    </div>
</body>

</html>