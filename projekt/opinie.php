<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Document</title>
</head>
<body>
    <a href="główna.php">Powrót do strony głównej</a><br>
    <div id="opinie-container">
    <?php
        $dbuser = 'root';
        $dbpass = '';
        $db = new PDO("mysql:host=localhost;dbname=projekt", $dbuser,$dbpass);
        $zap="SELECT imie, ocena, opinia FROM dzien WHERE opinia NOT LIKE ''";
        $result = $db->query($zap);
        if (!$result) {
            throw new PDOException("Error fetching owners: " . $db->errorInfo()[2]);
          }

          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "Ocena: $row[ocena] Opinia: $row[opinia] Imie: $row[imie] <br>";
          }
    ?>
    </div>
</body>
</html>