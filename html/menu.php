<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=SynixSushi", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (isset($_POST['zoekveld']) && !empty($_POST['zoekveld'])) {
    $zoekterm = "%" . $_POST['zoekveld'] . "%";
    $stmt = $conn->prepare("SELECT * FROM `menu` WHERE title LIKE :zoekterm");
    $stmt->bindParam(':zoekterm', $zoekterm, PDO::PARAM_STR);
} else {
    $stmt = $conn->prepare("SELECT * FROM `menu`");
}
$stmt->execute();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/adminlogin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Inder&family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&display=swap"
            rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/menu.css">
    <title>Menu Pagina</title>
</head>

<body class="homepage">
<div class="container">
    <header>
        <div class="headerimages">
            <a href="index.php"><img class="logo" src="images/SynixMainLogo.png" alt="logo"></a>
        </div>
    </header>

    <div class="main">
        <form action="menu.php" method="post">
            <input class="searchfield" placeholder="Zoek een gerecht" type="text" name="zoekveld">
        </form>
    </div>

    <div class="menu-container">
        <?php
        while ($result = $stmt->fetch()) {
            ?>
            <div class="menu-item">
                <h3><?php echo htmlspecialchars($result['title']); ?></h3>
                <p class="desc"><?php echo htmlspecialchars($result['beschrijving']); ?></p>
                <p class="price">€<?php echo number_format($result['prijs'], 2, ',', '.'); ?></p>
            </div>
            <?php
        }
        ?>
    </div>

    <footer>
        <p class="phonenumber">Nr: 0485 3243 0485</p>
        <p class="copyright">SynixMC © 2025 | Gemaakt door voidpacketdev</p>
        <p class="adres">Adres: Janpieterstraat 238, 8390 HB</p>
    </footer>
</div>
</body>

</html>
