<?php
    require_once 'mylibrary.php';
    destroy_session_and_data();
    echo "<html lang=\"en-GB\"><head></head><body>\n";
    echo "Goodbye visitor!<br />";
    echo '<a href="page1.php">Start again</a></body>';
?>