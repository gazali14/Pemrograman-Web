<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Pemesanan Tiket Konser</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="style.css">
  <style>
  /* Reset CSS */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .container {
      width: 45%;
      margin: 20px auto;
      background: transparent;
      backdrop-filter: blur(10px);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border: 2px solid #007bff;
      color: #fff;
    }

    h1 {
      text-align: center;
      color: #007bff;
      margin-bottom: 20px;
      font-size: x-large;
    }

    .invoice-details {
      margin-bottom: 20px;
    }

    .invoice-details p {
      margin-bottom: 10px;
      font-size: 16px;
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
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #0056b3;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      color: green;
      font-style: italic;
    }

    /* Decorative styles */
    .container {
      position: relative;
    }

    .container::before {
      content: '';
      position: absolute;
      top: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 20px;
      background-color: #007bff;
      border-radius: 10px 10px 0 0;
    }

    .container::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 20px;
      background-color: #007bff;
      border-radius: 0 0 10px 10px;
    }

  </style>
</head>

<body>
  <div class="container">
    <h1>Invoice Pemesanan Tiket Konser</h1>
    <div class="invoice-details">
      <?php
      // Memeriksa apakah parameter email telah diterima
      if (isset($_GET['email'])) {
        $email = $_GET['email'];

        // Query untuk mendapatkan data pemesanan berdasarkan email
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

        // Query untuk mendapatkan data pemesanan berdasarkan email
        $sql = "SELECT * FROM booking WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // Output data pemesanan dalam bentuk detail invoice
          while ($row = $result->fetch_assoc()) {
            echo "<pre><strong>Nama          :</strong> " . $row["name"] . "</pre>";
            echo "<pre><strong>E-mail        :</strong> " . $row["email"] . "</pre>";
            echo "<pre><strong>Nomor Telepon :</strong> " . $row["phone"] . "</pre>";
            echo "<pre><strong>Konser        :</strong> " . $row["concert"] . "</pre>";
            echo "<pre><strong>Jenis Tiket   :</strong> " . $row["ticket_type"] . "</pre>";
            echo "<pre><strong>Jumlah Tiket  :</strong> " . $row["quantity"] . "</pre>";
            
          }
        } else {
          echo "Data pemesanan tidak ditemukan.";
        }

        // Menutup koneksi
        $conn->close();
      } else {
        echo "Parameter email tidak ditemukan.";
      }
      ?>
    </div>
    <footer>Terima Kasih Telah Memesan Tiket!</footer>
    <a href="tampilForm.php" class="button">Kembali</a>
  </div>
</body>

</html>