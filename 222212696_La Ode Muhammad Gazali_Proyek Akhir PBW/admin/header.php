<?php include('footer.php'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin KlinikSTIS</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="css/style.css">
    <script>
        function searchFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            table = document.querySelector('.details table');
            tr = table.getElementsByTagName('tr');

            // Menampilkan semua baris yang cocok dengan pencarian
            for (i = 0; i < tr.length; i++) {
                tds = tr[i].getElementsByTagName("td");
                var found = false;
                for (var j = 0; j < tds.length; j++) {
                    td = tds[j];
                    if (td) {
                        txtValue = td.textContent || td.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            found = true;
                        }
                    }
                }
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }

            // Tampilkan saran pencarian berdasarkan input
            var suggestions = document.querySelector('.suggestions');
            suggestions.innerHTML = '';
            if (filter.trim() !== '') {
                var count = 0;
                for (i = 0; i < tr.length; i++) {
                    tds = tr[i].getElementsByTagName("td");
                    var found = false;
                    for (var j = 0; j < tds.length; j++) {
                        td = tds[j];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().includes(filter) && count < 5) {
                                var suggestion = document.createElement('li');
                                suggestion.textContent = txtValue;
                                suggestion.addEventListener('click', function () {
                                    input.value = this.textContent;
                                    searchFunction(); // Jalankan pencarian kembali setelah memilih saran
                                    suggestions.style.display = 'none'; // Sembunyikan saran setelah memilih
                                });
                                suggestions.appendChild(suggestion);
                                count++;
                                found = true;
                                break;
                            }
                        }
                    }
                    if (found) {
                        suggestions.style.display = "block";
                    }
                }
            } else {
                suggestions.style.display = "none";
            }
        }

        document.addEventListener('click', function (event) {
            var suggestions = document.querySelector('.suggestions');
            if (!event.target.closest('.search')) {
                suggestions.style.display = 'none';
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const toggle = document.querySelector('.toggle');
            const navigation = document.querySelector('.navigation');
            const main = document.querySelector('.main');
            const side = document.querySelector('.side');
            const container = document.querySelector('.container');

            toggle.onclick = function() {
                navigation.classList.toggle('collapsed');
                main.classList.toggle('collapsed');
                side.classList.toggle('hidden');
                container.classList.toggle('collapsed-grid');
            };            
        });
    </script>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <nav class="navbar">
                        <a href="#" class="navbar-logo" style="color:#3463a7">Klinik<span>STIS</span></a>
                    </nav>
                </li>

                <li>
                    <a href="index.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="users.php">
                        <span class="icon">
                            <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Users</span>
                    </a>
                </li>

                <li>
                    <a href="medicine.php">
                        <span class="icon">
                            <ion-icon name="medkit-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Medicine</span>
                    </a>
                </li>

                <li>
                    <a href="doctors.php">
                        <span class="icon">
                            <ion-icon name="medical-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Doctors</span>
                    </a>
                </li>

                <li>
                    <a href="schedules.php">
                        <span class="icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Schedules</span>
                    </a>
                </li>

                <li>
                    <a href="appointments.php">
                        <span class="icon">
                            <ion-icon name="calendar-number-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Appointments</span>
                    </a>
                </li>

                <li>
                    <a href="articles.php">
                        <span class="icon">
                            <ion-icon name="newspaper-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Articles</span>
                    </a>
                </li>

                <li>
                    <a href="questions.php">
                        <span class="icon">
                            <ion-icon name="help-circle-outline"></ion-icon>
                        </span>
                        <span class="title">Manage Questions</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="side">

        </div>
        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="search">
                    <label>
                        <input type="text" id="searchInput" placeholder="Search here" onkeyup="searchFunction()">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                    <ul class="suggestions"></ul>
                </div>



                <div class="user" style="cursor:pointer">
                    <a href="../logout.php" class="icon">
                        <ion-icon name="log-out-outline"></ion-icon> <!-- Mengganti ikon pengguna dengan ikon logout -->
                    </a>
                </div>

            </div>

            
