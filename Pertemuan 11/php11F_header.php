<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP11F Header</title>
    <style>
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        nav ul li {
            display: inline;
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .active{
            background-color: lightcoral;
            color: #fff;
            padding: 10px 5px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a class="active" href="#">Data Meeting</a></li>
                <li><a href="php11F_logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
