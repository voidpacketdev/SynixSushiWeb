<?php
// Controleer of de 'verwijder' knop is ingedrukt
if (isset($_POST['verwijder'])) {
    // Haal de ID uit de URL op via $_GET
    $id = $_GET['id'];

    // Verbinden met de database
    $servername = "mysql_db";
    $username = "root";
    $password = "rootpassword";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=SynixSushi", $username, $password);
        // Zet de PDO foutmodus op uitzondering
        echo "Verbinding succesvol<br>";
    } catch(PDOException $e) {
        echo "Verbinding mislukt: " . $e->getMessage();
    }

    // SQL-query om het gerecht te verwijderen

    $sql = "DELETE FROM menu WHERE id = :id";
    $stmt = $conn->prepare($sql);

    // Bind de parameter ':id' aan de waarde van de id uit $_GET
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Voer de query uit
    if ($stmt->execute()) {
        echo "Gerecht verwijderd met ID: " . $id;
    } else {
        echo "Er is een fout opgetreden bij het verwijderen.";
    }
}

?>


<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verwijder Gerecht</title>
</head>
<body>

<h1>Verwijder gerecht?</h1>

<form action="delete.php?id=<?php echo $_GET['id']; ?>" method="post">
    <input type="submit" name="verwijder" value="Ja, verwijder">
</form>
<a href="adminweb.php"><button>Terug naar admin paneel</button></a>


</body>
</html>