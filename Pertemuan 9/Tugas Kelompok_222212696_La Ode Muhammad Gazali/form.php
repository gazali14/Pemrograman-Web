<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Concert Ticket Booking</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h1>Concert Ticket Booking</h1>
    <div class="form">
      <!-- Formulir Pemesanan Tiket Konser -->
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Label untuk input nama -->
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" placeholder="Nama" value="<?php if (isset($_POST['name'])) echo htmlspecialchars($_POST['name']); ?>"><br>
        <!-- Label untuk input email -->
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="E-mail Anda" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>"><br>
        <!-- Label untuk input nomor telepon -->
        <label for="phone">Nomor Telepon:</label>
        <input type="text" id="phone" name="phone" placeholder="Nomor Telepon" value="<?php if (isset($_POST['phone'])) echo htmlspecialchars($_POST['phone']); ?>"><br>
        <!-- Label untuk pilihan konser -->
        <label for="selectconcert">Pilih Konser:</label>
        <select id="selectconcert" name="concert">
          <option value="" disabled selected>Pilih Opsi</option>
          <option value="Tulus" <?php if (isset($_POST['concert']) && $_POST['concert'] == 'Tulus') echo 'selected'; ?>>Konser Tulus</option>
          <option value="Kobo" <?php if (isset($_POST['concert']) && $_POST['concert'] == 'Kobo') echo 'selected'; ?>>Konser Kobo Kanaeru</option>
          <option value="Taylor" <?php if (isset($_POST['concert']) && $_POST['concert'] == 'Taylor') echo 'selected'; ?>>Konser Taylor Swift</option>
        </select>
        <!-- Label untuk pilihan jenis tiket -->
        <br>
        <label for="jenistiket">Pilih Jenis Tiket:</label>
        <select id="jenistiket" name="ticket_type">
          <option value="" disabled selected>Pilih Opsi</option>
          <option value="Festival" <?php if (isset($_POST['ticket_type']) && $_POST['ticket_type'] == 'Festival') echo 'selected'; ?>>Festival - Rp700.000,00</option>
          <option value="VIP" <?php if (isset($_POST['ticket_type']) && $_POST['ticket_type'] == 'VIP') echo 'selected'; ?>>VIP - Rp1.000.000,00</option>
          <option value="VVIP" <?php if (isset($_POST['ticket_type']) && $_POST['ticket_type'] == 'VVIP') echo 'selected'; ?>>VVIP - Rp1.200.000,00</option>
        </select>
        <br>
        <!-- Label untuk input jumlah tiket -->
        <label for="quantity">Jumlah:</label>
        <input type="number" id="quantity" name="quantity" placeholder="Jumlah Tiket" value="<?php if (isset($_POST['quantity'])) echo htmlspecialchars($_POST['quantity']); ?>">
        <br>

        <?php
        // Membuat koneksi ke database
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

        // Fungsi untuk memeriksa apakah string hanya mengandung huruf
        function isAllLetters($str)
        {
          return preg_match('/^[A-Za-z\s]+$/', $str);
        }

        // Fungsi untuk memeriksa apakah string adalah alamat email yang valid
        function isValidEmail($email)
        {
          return filter_var($email, FILTER_VALIDATE_EMAIL);
        }

        // Fungsi untuk memeriksa apakah string hanya mengandung angka
        function isAllNumbers($str)
        {
          return preg_match('/^[0-9]+$/', $str);
        }

        // Fungsi untuk memvalidasi input jumlah tiket (> 0)
        function isValidTicketQuantity($quantity)
        {
          return $quantity > 0;
        }

        // Fungsi untuk memvalidasi ticket_type
        function isValidTicketType($ticket_type)
        {
            // Daftar jenis tiket yang valid
            $valid_types = array("Festival", "VIP", "VVIP");

            // Memeriksa apakah jenis tiket yang dipilih termasuk dalam daftar valid
            return in_array($ticket_type, $valid_types);
        }

        // Fungsi untuk memvalidasi concert
        function isValidConcert($concert)
        {
            // Daftar konser yang valid
            $valid_concerts = array("Tulus", "Kobo", "Taylor");

            // Memeriksa apakah konser yang dipilih termasuk dalam daftar valid
            return in_array($concert, $valid_concerts);
        }


        // Memeriksa apakah form telah disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $errors = []; // Array untuk menyimpan pesan kesalahan

          // Memeriksa nama
          $nama = $_POST["name"];
          if (empty($nama)) {
            $errors[] = "Nama harus diisi";
          } elseif (strlen($nama) > 50) {
            $errors[] = "Nama maksimal 50 karakter";
          } elseif (!isAllLetters($nama)) {
            $errors[] = "Nama hanya boleh mengandung huruf";
          }

          // Memeriksa email
          $email = $_POST["email"];
          if (empty($email)) {
            $errors[] = "Email harus diisi";
          } elseif (!isValidEmail($email)) {
            $errors[] = "Email tidak valid";
          }

          // Memeriksa nomor telepon
          $telepon = $_POST["phone"];
          if (empty($telepon)) {
            $errors[] = "Nomor telepon harus diisi";
          } elseif (!isAllNumbers($telepon)) {
            $errors[] = "Nomor telepon hanya boleh angka";
          } elseif (strlen($telepon) < 10 || strlen($telepon) > 12) {
            $errors[] = "Nomor telepon harus terdiri dari 10 hingga 12 digit";
          }

          // Memeriksa pilih konser
          $concert = isset($_POST["concert"]) ? $_POST["concert"] : '';
          if (empty($concert)) {
              $errors[] = "Harus memilih konser terlebih dahulu";
          } elseif (!isValidConcert($concert)) {
              $errors[] = "Konser yang dipilih tidak valid";
          }

          // Memeriksa pilih jenis tiket
          $ticket_type = isset($_POST["ticket_type"]) ? $_POST["ticket_type"] : '';
          if (empty($ticket_type)) {
              $errors[] = "Harus memilih jenis tiket terlebih dahulu";
          } elseif (!isValidTicketType($ticket_type)) {
              $errors[] = "Jenis tiket yang dipilih tidak valid";
          }

          // Memeriksa jumlah tiket
          $jumlahTiket = $_POST["quantity"];
          if (empty($jumlahTiket)) {
            $errors[] = "Jumlah tiket harus diisi";
          } elseif (!isValidTicketQuantity($jumlahTiket)) {
            $errors[] = "Jumlah tiket harus lebih dari 0";
          }

          // Memeriksa apakah email yang sama sudah melakukan pembelian tiket sebelumnya
          $sql_check_email = "SELECT COUNT(*) as total FROM booking WHERE email=?";
          $stmt_check_email = $conn->prepare($sql_check_email);
          $stmt_check_email->bind_param("s", $email);
          $stmt_check_email->execute();
          $result_check_email = $stmt_check_email->get_result();
          $row_check_email = $result_check_email->fetch_assoc();

          if ($row_check_email['total'] > 0) {
              // Email sudah melakukan pembelian tiket sebelumnya, tampilkan pesan kesalahan
              $errors[] = "Maaf, Anda tidak dapat menggunakan email yang sama untuk pembelian tiket lebih dari 1 kali";
          }

          // Jika tidak ada kesalahan, lanjutkan dengan pemrosesan formulir
          if (empty($errors)) {
            // Mengambil nilai dari formulir
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $concert = $_POST["concert"];
            $ticket_type = $_POST["ticket_type"];
            $quantity = $_POST["quantity"];

            // SQL untuk menyimpan data ke dalam tabel
            if (preg_match("[\d]", $phone) && $name != null) {
              $sql = "INSERT INTO booking (name, email, phone, concert, ticket_type, quantity) VALUES ('$name', '$email', '$phone', '$concert', '$ticket_type', '$quantity')";
              if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Pemesanan berhasil!');</script>";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
            } else {
              echo '<script>window.alert("Data tidak valid, Ada yang ga beres nih")</script>';
            }

            // Menutup koneksi
            $conn->close();
          } else {
            // Tampilkan pesan kesalahan jika ada
            echo "<div class='error-container'><ul>";
            foreach ($errors as $error) {
              echo "<li>$error</li>";
            }
            echo "</ul></div>";
          }
        }
        ?>

        <button type="submit">Beli Tiket</button> <!-- Tombol untuk membuat invoice -->
        <button class="show-data-button" formaction="tampilForm.php">Tampilkan Pesanan</button> <!-- Tombol untuk menampilkan data -->
      </form>
    </div>
  </div>
</body>

</html>