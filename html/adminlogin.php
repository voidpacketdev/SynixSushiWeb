<?php
$loginIncorrect = false;
session_start();

if(isset($_POST['loginbtn'])) {
    $servername = "mysql_db";
    $username = "root";
    $password = "rootpassword";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=SynixSushi", $username, $password);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

// voeren query uit
    $sql = "SELECT * FROM `gebruikers` WHERE `password` = :password AND username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':password', $_POST['password']);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->execute();
    $gebruiker = $stmt->fetch();

    if($gebruiker) {
        $_SESSION['admin'] = true;
        header("Location: adminweb.php");
    } else {
        $loginIncorrect = true;
    }

}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Login</title>
    <link rel="stylesheet" href="css/adminlogin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inder&family=Inknut+Antiqua:wght@300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&display=swap"
        rel="stylesheet">
</head>

<body>
<div class="logoclass">
    <a href="index.php">
        <img class="logo" src="images/SynixMainLogo.png" alt="logo">
    </a>
</div>

<div class="logincontainer">
    <form method="post" action="adminlogin.php" class="loginform">
        <?php if ($loginIncorrect): ?>
            <div class="error">Onjuiste gebruikersnaam of wachtwoord!</div>
        <?php endif; ?>

        <p class="formtext">Admin Panel Login</p>

        <div class="inputcontainer">
            <div class="inputbox">
                <img class="user-icon" src="images/user.png" alt="user">
                <input name="username" type="text" placeholder="Gebruikersnaam" class="inputfield" required>
            </div>
        </div>

        <div class="inputcontainer">
            <div class="inputbox">
                <img class="lock-icon" src="images/lock.png" alt="lock">
                <input name="password" type="password" placeholder="Wachtwoord" class="inputfield" required>
            </div>
        </div>

        <div class="login-container">
            <button name="loginbtn" type="submit" class="login-btn">
                <img class="bracket-icon" src="images/bracket.png" alt="bracket">
                Inloggen
            </button>
        </div>
    </form>
</div>
</body>


</html>