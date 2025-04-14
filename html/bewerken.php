<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
$dbname = "SynixSushi";

try {
    $conn = new PDO("mysql:host=$servername;dbname=SynixSushi", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check of een ID is meegegeven
    if (!isset($_GET['id']) && !isset($_POST['id'])) {
        echo "Geen gerecht ID opgegeven.";
        exit;
    }

    $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];

    // Bij versturen formulier: updaten
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['title']) && !empty($_POST['prijs']) && !empty($_POST['beschrijving'])) {
            $title = $_POST['title'];
            $prijs = $_POST['prijs'];
            $beschrijving = $_POST['beschrijving'];

            $sql = "UPDATE menu SET title = :title, prijs = :prijs, beschrijving = :beschrijving WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':prijs', $prijs);
            $stmt->bindParam(':beschrijving', $beschrijving);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                $message = "Gerecht succesvol bijgewerkt!";
            } else {
                $message = "Er is iets misgegaan bij het bijwerken.";
            }
        } else {
            $message = "Vul alle velden in!";
        }
    }

    // Ophalen huidige gegevens
    $stmt = $conn->prepare("SELECT * FROM menu WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $gerecht = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$gerecht) {
        echo "Gerecht niet gevonden.";
        exit;
    }
} catch (PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
    exit;
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Gerecht Bewerken</title>
    <link rel="stylesheet" href="css/bewerken.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Gerecht Bewerken</h1>

    <?php if (isset($message)) : ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" class="form">
        <input type="hidden" name="id" value="<?= isset($gerecht['id']) ? $gerecht['id'] : (isset($_POST['id']) ? $_POST['id'] : '') ?>">

        <div class="input-group">
            <label for="title">Titel</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars(isset($gerecht['title']) ? $gerecht['title'] : (isset($_POST['title']) ? $_POST['title'] : '')) ?>" required>
        </div>

        <div class="input-group">
            <label for="prijs">Prijs (€)</label>
            <input type="number" id="prijs" step="0.01" name="prijs" value="<?= htmlspecialchars(isset($gerecht['prijs']) ? $gerecht['prijs'] : (isset($_POST['prijs']) ? $_POST['prijs'] : '')) ?>" required>
        </div>

        <div class="input-group">
            <label for="beschrijving">Beschrijving</label>
            <textarea id="beschrijving" name="beschrijving" required><?= htmlspecialchars(isset($gerecht['beschrijving']) ? $gerecht['beschrijving'] : (isset($_POST['beschrijving']) ? $_POST['beschrijving'] : '')) ?></textarea>
        </div>

        <button type="submit">Opslaan</button>
    </form>

    <form action="adminweb.php" method="get">
        <button type="submit" class="returnbtn">Terug naar adminpaneel</button>
    </form>
</div>
</body>
</html>
