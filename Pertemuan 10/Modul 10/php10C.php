<?php
// Mengatur waktu berlaku session menjadi
ini_set('session.gc_maxlifetime', 10);
session_set_cookie_params(10);

session_start ();
// not necessary but convenient
if (isset($_REQUEST['address']))
    $_SESSION['address'] = $_REQUEST['address'];
?>
<!DOCTYPE html>
<html lang='en-GB'>
<head>
    <title>PHP10C</title>
</head>
<body>
    <?php
    echo $_SESSION['item'] , "<br>";
    echo $_SESSION['address'];
    // Once we do not need the data anymore , get rid of it
    session_unset();

    session_destroy();
    ?>
</body>
</html>