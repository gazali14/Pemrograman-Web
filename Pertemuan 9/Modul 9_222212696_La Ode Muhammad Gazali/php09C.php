<!DOCTYPE html>
<html lang='en-GB'>
<head>
<title>PHP09 C</title>
</head>
<body>
<?php
    echo 'Item: ', $_POST['item'], '<br>';
    echo 'Alamat: ', $_POST['address'], '<br>';
?>
<button onclick="goBack()">Back</button>

<script>
function goBack() {
  window.location.href = 'php09A.php';
}
</script>
</body>
</html>
