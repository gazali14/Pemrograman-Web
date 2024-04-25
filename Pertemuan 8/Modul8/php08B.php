<!DOCTYPE html>
<html lang='en-GB'>
<head>
    <title>PHP 08B</title>
</head>
<body>
    <h1>Hello World</h1>
    <?php
        error_reporting( E_ALL );
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        echo "<h2>Types and Type Casting</h2>\n";
        $mode = rand(1,4);
        if ($mode == 1)
            $randvar = rand();
        elseif ($mode == 2)
            $randvar = (string) rand();
        elseif ($mode == 3)
            $randvar = rand()/(rand()+1);
        else
            $randvar = (bool) $mode;

        echo "The mode is: $mode <br><br>\n";
        echo "Random scalar: $randvar<br>\n"; 

        // Menambahkan pengecekan tipe data
        if (is_int($randvar))
            echo "This is an integer.";
        elseif (is_float($randvar))
            echo "This is a floating-point number.";
        elseif (is_string($randvar))
            echo "This is a string.";
        else
            echo "I don't know what this is.";
    ?>
</body>
</html>
