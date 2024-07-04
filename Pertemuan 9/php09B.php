<!DOCTYPE html>
<html lang='en-GB'>
<head>
<title>PHP09 B</title>
</head>
<body>
<?php
    // Simpan nilai item dalam input tersembunyi
    echo '
        <form action="php09C.php" method="post">
            <input type="hidden" name="item" value="' . $_REQUEST['item'] . '">
            <label>Item: ', $_REQUEST['item'], '</label><br>
            <label>Address: <input type="text" name="address"></label><br>
        </form>';
?>
</body>
</html>
