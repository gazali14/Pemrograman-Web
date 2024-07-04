<?php
session_start();

// Mengecek apakah user sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cek Ketersediaan Obat</title>
    <link rel="stylesheet" href="css/style.css" />
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .suggestion-box {
            border: 1px solid #ccc;
            background: #fff;
            position: absolute;
            max-height: 150px;
            overflow-y: auto;
            width: 100%;
            z-index: 1000;
        }
        .suggestion-box div {
            padding: 8px;
            cursor: pointer;
        }
        .suggestion-box div:hover {
            background: #f0f0f0;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 100%;
            max-width: 400px;
            position: relative;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .medicine-card[aria-disabled="true"] .request-button {
            opacity: 0.5;
            pointer-events: none; 
        }


    </style>
</head>
<body style="background-image: url('img/bg.svg')">
    <!-- Navbar Mulai -->
    <nav class="navbar">
        <a href="mainpage.php" class="navbar-logo">Klinik<span>STIS</span></a>
        <div class="navbar-extra">
            <i href="index.php" data-feather="home"></i>
        </div>
    </nav>
    <!-- Navbar Selesai -->

    <!-- Obat Mulai -->
    <section class="medicine-section">
        <div class="container">
            <h1 class="judul">Cek Ketersediaan Obat</h1>
            <div class="search">
                <input placeholder="Search..." type="text" id="searchInput" oninput="showSuggestions()">
                <button type="button" onclick="searchMedicine()">Go</button>
                <div id="suggestionBox" class="suggestion-box"></div>
            </div>
            <div class="medicine-list">
                <?php include 'fetch_ketersediaan_obat.php'; ?>
            </div>
        </div>
    </section>
    <!-- Obat Selesai -->

    <!-- Modal Popup -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Masukkan Jumlah Obat</h2>
            <form class="modal-box" id="requestForm">
                <input type="hidden" id="medicineId">
                <div class="input-group">
                    <label for="quantity">Jumlah:</label>
                    <input type="number" id="quantity" name="quantity" min="1" required>
                    <button type="submit">Minta Obat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Mulai -->
    <footer>
        <div class="row">
            <div class="col">
                <img src="img/Logo_STIS.png" class="logo" alt="logo" />
            </div>
            <div class="col">
                <h3>Office</h3>
                <p>Jl. Otto Iskandardinata</p>
                <p>Jatinegara, Jakarta Timur</p>
                <p>Indonesia</p>
                <p class="email-id">upk@stis.ac.id</p>
                <h4>082193671786</h4>
            </div>
            <div class="col">
                <h3>links</h3>
                <ul>
                    <li><a href="https://bps.go.id">Badan Pusat Statistik</a></li>
                    <li><a href="https://stis.ac.id">Politeknik Statistika STIS</a></li>
                    <li><a href="https://spmb.stis.ac.id">SPMB STIS</a></li>
                    <li>
                    <a href="https://perkuliahan.sipadu.stis.ac.id">Sipadu STIS</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr />
        <p class="copyrigth">POLITEKNIK STATISTIKA STIS - All rights reserved</p>
    </footer>
    <!-- Footer Selesai -->

    <!-- Feather icons -->
    <script src="js/obat.js"></script>
</body>
</html>
