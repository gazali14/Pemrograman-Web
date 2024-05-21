<?php
session_start(); // Memulai session

// Menghapus semua session
session_unset();
session_destroy();

// Mengarahkan kembali ke halaman login
header("Location: php11D.php");
exit();
?>
