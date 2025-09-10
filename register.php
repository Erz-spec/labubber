<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "labubuk";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    // Ellenőrizzük, hogy létezik-e már a felhasználó
    $check = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $msg = "⚠️ Ez a felhasználónév már létezik!";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
        if ($conn->query($sql) === TRUE) {
            $msg = "✅ Sikeres regisztráció! Most már beléphetsz.";
        } else {
            $msg = "❌ Hiba történt: " . $conn->error;
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labubu Regisztráció</title>
    <link href="labubu.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="login-box">
        <img src="labubu.webp" alt="Labubu">

        <form method="POST">
            <input type="text" name="username" placeholder="Felhasználónév" required>
            <input type="password" name="password" placeholder="Jelszó" required>
            <button type="submit">Regisztráció</button>
        </form>

        <?php if ($msg != ""): ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php endif; ?>

        <div class="social-links">
            <a href="index.php">⬅️ Vissza a belépéshez</a>
        </div>
    </div>
</body>
</html>
