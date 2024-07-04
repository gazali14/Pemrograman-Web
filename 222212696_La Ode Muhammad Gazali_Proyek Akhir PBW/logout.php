<?php
session_start();

// Unset asemua variabel Session
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect ke login
header("Location: index.php");
exit;
?>
