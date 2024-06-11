<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="główna.php">Powrót do strony głównej</a><br>
    <?php
        $dbuser = 'root';
        $dbpass = '';
        $db = new PDO("mysql:host=localhost;dbname=projekt", $dbuser,$dbpass);
        $zap="SELECT imie, ocena, opinia FROM dzien";
        $result = $db->query($zap);
        if (!$result) {
            throw new PDOException("Error fetching owners: " . $db->errorInfo()[2]);
          }

          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "Ocena: $row[ocena] Opinia: $row[opinia] Imie: $row[imie] <br>";
          }
    ?>
</body>
</html>