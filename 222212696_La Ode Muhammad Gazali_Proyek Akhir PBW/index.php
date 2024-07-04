<?php
session_start();

include 'db_koneksi.php';

$usernameError = "";
$passwordError = "";

// Proses sign up
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Ambil data dari form sign up
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Enkripsi password dengan MD5

    // Query untuk menambahkan pengguna baru ke basis data
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        echo "";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Proses sign in
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    // Ambil data dari form sign in
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Enkripsi password dengan MD5

    // Query ke basis data untuk mencari pengguna dengan username yang sesuai
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika ditemukan pengguna dengan username yang sesuai
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if ($password == $row['password']) {
            // Simpan informasi pengguna ke dalam sesi
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['is_admin'] = $row['is_admin'];

            // Redirect ke halaman yang sesuai berdasarkan status admin
            if ($_SESSION['is_admin'] == 1) {
                header("Location: admin/admin.php");
            } else {
                header("Location: mainpage.php");
            }
            exit();
        } else {
            $passwordError = "Password yang anda masukan salah";
        }
    } else {
        $usernameError = "Username tidak dikenali";
    }
    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login_style.css">
    <title>Signin/Signup</title>
    <style>
        .error {
            color: red;
        }
        .input-field {
            width: 100%;
            height: 50px;
            background: #fff;
            margin: 10px 0;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 20px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="signin-signup">
            <form action="" class="sign-in-form" method="POST">
                <h2 class="title">Sign in</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <?php if (!empty($usernameError)) { echo "<p class='error'>$usernameError</p>"; } ?>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" required>
                </div>
                <?php if (!empty($passwordError)) { echo "<p class='error'>$passwordError</p>"; } ?>
                <input type="submit" value="Login" class="btn" name="signin">
                <p class="account-text">Don't have an account? <a href="#" id="sign-up-btn2">Sign up</a></p>
            </form>
            <form action="" class="sign-up-form" method="POST" onsubmit="return validateSignupForm()">
                <h2 class="title">Sign up</h2>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Username" name="username" id="signup-username" required>                    
                </div>
                <p id="usernameError" class="error"></p>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="email" id="signup-email" required>
                </div>
                <p id="emailError" class="error"></p>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password" id="signup-password" required>
                </div>
                <p id="passwordError" class="error"></p>
                <input type="submit" value="Sign up" class="btn" name="signup">
                <p class="account-text">Already have an account? <a href="#" id="sign-in-btn2">Sign in</a></p>
            </form>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Sudah Punya Akun?</h3>
                    <img src="img/pict2.png" alt="" class="image">
                    <button class="btn-signin" id="sign-in-btn">Sign in</button>
                </div>
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Belum Punya Akun?</h3>
                    <img src="img/pict2.png" alt="" class="image">
                    <button class="btn-signup" id="sign-up-btn">Sign up</button>
                </div>
            </div>
        </div>
        <div class="popup-container" id="signup-success-popup">
            <div class="popup">
                <i class="fas fa-check-circle"></i>
                <p>Sign up berhasil! <br>Silahkan Sign In untuk menuju halaman utama</p>
                <button id="popup-okay-btn">Oke</button>
            </div>
        </div>
    </div>

    <script src="js/login.js"></script>
    <script>
        // Menampilkan popup
        document.addEventListener('DOMContentLoaded', function() {
            var signupSuccessPopup = document.getElementById('signup-success-popup');
            var popupOkayBtn = document.getElementById('popup-okay-btn');

            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) { ?>
                signupSuccessPopup.style.display = 'block';
            <?php } ?>

            popupOkayBtn.addEventListener('click', function() {
                signupSuccessPopup.style.display = 'none';
            });
        });
    </script>
</body>
</html>
