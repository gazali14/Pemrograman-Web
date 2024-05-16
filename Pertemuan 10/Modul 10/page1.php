<?php
    require_once 'mylibrary.php';
    echo "<html lang=\"en-GB\"><head></head><body>\n";
    echo "Hello visitor!<br />This is your page request no ";
    echo count_requests() . " from this site.<br />\n";
    echo '<a href="page1.php">Continue</a> | <a href="finish.php">Finish</a></body>';
?>