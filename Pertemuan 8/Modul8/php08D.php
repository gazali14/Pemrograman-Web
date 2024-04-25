<!DOCTYPE html>
<html>
<head>
    <title>PHP 08D</title>
    <style>
        table {
            border-collapse : collapse;
        }
        th, td {
            padding : 5px;
            border : 1px solid black;
            text-align : center;
        }
    </style>
</head>
<body>
    <h1>Associative Arrays</h1>
    <?php
        $dict1 = array('a' => 1, 'b' => 2);
        $dict2 = $dict1;
        $dict1['b'] = 4;
        echo "\$dict1['b'] = ", $dict1['b'],"<br>\n";
        echo "\$dict2['b'] = ", $dict2['b'],"<br>\n";

        // Bagian b: Menampilkan pasangan key-value dalam $dict1
        echo "<h2>Menampilkan pasangan key-value dalam dict1 </h2>\n";
        foreach ($dict1 as $key => $value) {
            echo "key = $key  ->  value = $value<br>\n";
        }

        // Bagian c: Menghitung jumlah kemunculan suatu kata dalam string
        echo "<h2>Menghitung jumlah kemunculan suatu kata dalam string</h2>\n";
        $text = 'lorem ipsum elit congue auctor inceptos taciti suscipit
        tortor auctor integer congue hac nullam hac auctor tellus nullam
        inceptos nullam integer tellus nullam auctor elit lorem ipsum elit';
        echo "$text<br><br>";

        // Memisahkan kata-kata dalam teks menjadi array
        $words = array_unique(explode(" ", $text));
        
        // Membuat associative array $dict3 untuk menghitung kemunculan kata
        $dict3 = array();
        foreach ($words as $word) {
            if (!empty($word)) { // Pastikan kata tidak kosong
                $dict3[$word] = substr_count($text, $word);
                echo "$word -> ", $dict3[$word], "<br>\n";
            }
        }

        echo "<br> Tabel urutan jumlah kemunculan kata dari yang terbanyak <br>";
        arsort($dict3);
        echo "<table>\n";
        echo "<tr><th> Kata </th><th> Jumlah Kemunculan </th></tr>\n";

        foreach($dict3 as $kata => $jumlah)
        echo "<tr><td> $kata </td><td>", $jumlah,"</td></tr>\n";

        echo "</table>\n";          

    ?>
</body>
</html>
