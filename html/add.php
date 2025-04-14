<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
$dbname = "SynixSushi";
try {
    $conn = new PDO("mysql:host=$servername;dbname=SynixSushi", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Controleer of het formulier is verzonden
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Controleer of alle velden zijn ingevuld
        if (!empty($_POST['title']) && !empty($_POST['prijs']) && !empty($_POST['beschrijving'])) {
            $title = $_POST['title'];
            $prijs = $_POST['prijs'];
            $beschrijving = $_POST['beschrijving'];

            // SQL-query voorbereiden en uitvoeren
            $sql = "INSERT INTO menu (title, prijs, beschrijving) VALUES (:title, :prijs, :beschrijving)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':prijs', $prijs);
            $stmt->bindParam(':beschrijving', $beschrijving);

            if ($stmt->execute()) {
                echo "Gerecht succesvol toegevoegd!";
            } else {
                echo "Er is een fout opgetreden bij het toevoegen van het gerecht.";
            }
        } else {
            echo "Vul alle velden in!";
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nieuw Gerecht Toevoegen</title>
    <link rel="stylesheet" href="css/add.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Inder&family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&display=swap"
            rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Gerecht Toevoegen</h1>

    <form method="POST" class="form">
        <div class="input-group">
            <label for="title">Titel</label>
            <input type="text" id="title" name="title" placeholder="Bijv. Sushi Roll" required>
        </div>

        <div class="input-group">
            <label for="prijs">Prijs (€)</label>
            <input type="number" id="prijs" step="0.01" name="prijs" placeholder="Bijv. 12.50" required>
        </div>

        <div class="input-group">
            <label for="beschrijving">Beschrijving</label>
            <textarea id="beschrijving" name="beschrijving" placeholder="Korte omschrijving..." required></textarea>
        </div>

        <button type="submit">Toevoegen</button>
    </form>
    <form action="adminweb.php" method="get">
        <button type="submit" class="returnbtn">Terug naar adminpaneel</button>
    </form>

</div>
</body>


</html>
