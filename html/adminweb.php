<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit;
}

$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=SynixSushi", $username, $password);
} catch(PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
}

// Haal alle menu-items op
$stmt = $conn->prepare("SELECT * FROM menu");
$stmt->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inder&family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminweb.css">
    <title>Menu Pagina</title>
</head>

<body>
<div class="container">
    <h1 class="titleform">Menu Beheer</h1>

    <nav class="button-group">
        <a href="add.php" class="btn">Gerecht toevoegen</a>
        <a href="index.php" class="btn">Terug naar home</a>
    </nav>

    <div class="menu-list">
        <?php while ($row = $stmt->fetch()): ?>
            <div class="menu-item">
                <div class="menu-text">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="price">€<?= number_format($row['prijs'], 2, ',', '.') ?></p>
                </div>
                <div class="actions">
                    <a href="bewerken.php?id=<?= $row['id'] ?>" class="btn">Bewerken</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Verwijderen</a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>



</html>

