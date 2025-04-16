<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
$dish_name = "Onbekend gerecht"; // standaardwaarde

// Haal de ID uit de URL op
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Eén keer verbinden met de database
        $conn = new PDO("mysql:host=$servername;dbname=SynixSushi", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Haal de naam van het gerecht op (pas 'titel' aan naar juiste kolomnaam)
        $stmt = $conn->prepare("SELECT title FROM menu WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $gerecht = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($gerecht) {
            $dish_name = $gerecht['title'];
        }

        // Verwijder het gerecht als er op de knop is geklikt
        if (isset($_POST['verwijder'])) {
            $stmt = $conn->prepare("DELETE FROM menu WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $success_message = "Gerecht verwijderd: " . $dish_name;
            } else {
                $error_message = "Er is een fout opgetreden bij het verwijderen.";
            }
        }

    } catch (PDOException $e) {
        $error_message = "Databasefout: " . $e->getMessage();
    }
} else {
    $error_message = "Geen geldig ID opgegeven.";
}
?>



<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verwijder Gerecht</title>
    <link rel="stylesheet" href="css/delete.css">
</head>
<body>

<div class="container">
    <div class="content-wrapper">
        <h1 class="page-title">Verwijder gerecht?</h1>

        <div class="dish-removal-card">
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo $success_message; ?></p>
                <div class="button-container">
                    <a href="adminweb.php" class="button button-secondary">Terug naar admin paneel</a>
                </div>
            <?php elseif (isset($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
                <div class="button-container">
                    <a href="adminweb.php" class="button button-secondary">Terug naar admin paneel</a>
                </div>
            <?php else: ?>
                <p class="dish-name"><?php echo $dish_name; ?></p>

                <div class="button-container">
                    <form class="delete-form" action="delete.php?id=<?php echo $_GET['id']; ?>" method="post">
                        <button type="submit" name="verwijder" class="button button-primary">Verwijder</button>
                    </form>

                    <a href="adminweb.php" class="button button-secondary">Terug naar admin paneel</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>