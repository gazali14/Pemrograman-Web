<?php
// Mengatur waktu berlaku session menjadi 1 jam (3600 detik)
ini_set('session.gc_maxlifetime', 10);
session_set_cookie_params(10);

session_start ();
if (isset($_REQUEST['item']))
    $_SESSION['item'] = $_REQUEST['item'];
?>
<!DOCTYPE html>
<html lang='en-GB'>
<head><title>PHP10B</title></head>
<body>
    <form action="php10C.php" method="post">
        <label>Address: <input type="text" name="address"></label>
        <!-- no hidden input required -->
        <input type="submit" value="Send">
    </form>
</body>
</html>